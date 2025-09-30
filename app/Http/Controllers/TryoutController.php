<?php

namespace App\Http\Controllers;

use App\Models\QuestionBankCategory;
use Illuminate\Http\Request;
use App\Models\Tryout;
use App\Models\TryoutAttempt;
use App\Models\UserAnswer;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TryoutController extends Controller
{
    /**
     * Memulai sesi tryout, membuat attempt, dan menampilkan halaman soal.
     */
    public function start($tryout_id)
    {
        $tryout = Tryout::findOrFail($tryout_id);
        $user = Auth::user();

        $attempt = TryoutAttempt::create([
            'user_id' => $user->id,
            'tryout_id' => $tryout->tryout_id,
            'start_time' => now(),
            'status' => 'in_progress',
        ]);

        // Kode di bawah ini untuk mengambil dan memformat soal tidak perlu diubah
        $questions = $tryout
            ->questions()
            ->with(['options', 'questionType'])
            ->orderBy('tryout_questions.question_number', 'asc')
            ->get();

        $formattedQuestions = $questions->map(function ($q, $index) {
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $q->questionType->type == 'Pilihan Ganda' ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }),
                'explanation' => $q->explanation,
                'correctAnswer' => $q->questionType->type == 'Pilihan Ganda' ? ($q->options->search(fn($opt) => $opt->is_correct) !== false ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) : null) : $q->correct_answer_text,
            ];
        });

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'questions' => $formattedQuestions,
            'attempt' => $attempt,
        ]);
    }

    /**
     * Menerima dan memproses jawaban dari pengguna.
     */
    public function submit(Request $request, $attempt_id)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $attempt = TryoutAttempt::findOrFail($attempt_id);

        if ($attempt->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();

            $attempt = TryoutAttempt::with('tryout.questions')->findOrFail($attempt_id);
            $answers = $request->input('answers');

            $correctAnswersCount = 0;

            $tryoutQuestions = $attempt->tryout->questions->keyBy('question_id');

            foreach ($answers as $question_id => $answerData) {
                $question = $tryoutQuestions->get($question_id);
                if (!$question) {
                    continue;
                }
                $isCorrect = false;
                if ($question->questionType->type == 'Pilihan Ganda') {
                    $selectedOptionId = $answerData['optionId'] ?? null;
                    $correctOption = $question->options->firstWhere('is_correct', true);
                    if ($correctOption && $selectedOptionId == $correctOption->option_id) {
                        $isCorrect = true;
                    }
                } elseif ($question->questionType->type == 'Isian Singkat') {
                    $userText = $answerData['text'] ?? '';
                    if (strcasecmp(trim($userText), trim($question->correct_answer_text)) == 0) {
                        $isCorrect = true;
                    }
                }

                if ($isCorrect) {
                    $correctAnswersCount++;
                }

                UserAnswer::create([
                    'attempt_id' => $attempt_id,
                    'question_id' => $question_id,
                    'selected_option_id' => $answerData['optionId'] ?? null,
                    'answer_text' => $answerData['text'] ?? null,
                ]);
            }

            $totalQuestions = $tryoutQuestions->count();
            $finalScore = $totalQuestions > 0 ? ($correctAnswersCount / $totalQuestions) * 100 : 0;

            $attempt->update([
                'end_time' => now(),
                'score' => $finalScore,
                'status' => 'submitted',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Jawaban berhasil disimpan!',
                'result_url' => route('tryout.result', ['attempt_id' => $attempt_id]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal submit tryout: ' . $e->getMessage());

            return response()->json(
                [
                    'message' => 'Terjadi kesalahan saat menyimpan jawaban.',
                    'error' => config('app.debug') ? $e->getMessage() : 'Terjadi kesalahan pada server.',
                ],
                500,
            );
        }
    }

    public function showResult($attempt_id)
    {
        $attempt = TryoutAttempt::with('tryout')->findOrFail($attempt_id);

        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        return view('tryout.tryout-completed-page', [
            'attempt' => $attempt,
        ]);
    }

    public function review($tryout_id)
    {
        $user = Auth::user();
        $tryout = Tryout::findOrFail($tryout_id);

        $latestAttempt = TryoutAttempt::where('user_id', $user->id)->where('tryout_id', $tryout_id)->where('status', 'submitted')->latest('updated_at')->first();

        if (!$latestAttempt) {
            return redirect()->route('bank-soal.index')->with('error', 'Anda harus menyelesaikan mode tryout terlebih dahulu sebelum masuk ke mode belajar.');
        }

        $questions = $tryout
            ->questions()
            ->with(['options', 'questionType'])
            ->get();
        $userAnswers = UserAnswer::where('attempt_id', $latestAttempt->attempt_id)->get()->keyBy('question_id');

        $formattedQuestions = $questions->map(function ($q, $index) {
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $q->questionType->type == 'Pilihan Ganda' ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }),
                'explanation' => $q->explanation,
                'correctAnswer' => $q->questionType->type == 'Pilihan Ganda' ? ($q->options->search(fn($opt) => $opt->is_correct) !== false ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) : null) : $q->correct_answer_text,
            ];
        });

        $formattedAnswers = [];
        foreach ($userAnswers as $question_id => $answer) {
            $formattedAnswers[$question_id] = [
                'key' => $answer->selectedOption ? chr(65 + $questions->find($question_id)->options->search(fn($opt) => $opt->option_id == $answer->selected_option_id)) : null,
                'optionId' => $answer->selected_option_id,
                'text' => $answer->answer_text,
            ];
        }

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'attempt' => $latestAttempt,
            'questions' => $formattedQuestions,
            'userAnswers' => $formattedAnswers,
        ]);
    }

    // Tambahkan metode ini di TryoutController Anda

    public function startLearningMode($tryout_id)
    {
        $tryout = Tryout::with(['questions.options', 'questions.questionType'])->findOrFail($tryout_id);

        // 1. KITA TIDAK MENGAMBIL JAWABAN LAMA DARI DATABASE

        $formattedQuestions = $tryout->questions->map(function ($q, $index) {
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $q->questionType->type == 'Pilihan Ganda' ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }),
                'explanation' => $q->explanation,
                'correctAnswer' => $q->questionType->type == 'Pilihan Ganda' ? ($q->options->search(fn($opt) => $opt->is_correct) !== false ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) : null) : $q->correct_answer_text,
            ];
        });

        // 2. BUAT SEBUAH OBJECT ATTEMPT PALSU ATAU SEDERHANA HANYA UNTUK VIEW
        // Ini agar view Anda tidak error karena $attempt tidak ada.
        $mockAttempt = (object) [
            'attempt_id' => 0, // ID 0 atau null, karena ini bukan attempt sungguhan
        ];

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'attempt' => $mockAttempt, // Menggunakan attempt palsu
            'questions' => $formattedQuestions,
            'userAnswers' => [], // 3. KIRIM ARRAY KOSONG SEBAGAI userAnswers
        ]);
    }

    public function showHistory($tryout_id)
    {
        // 1. Ambil informasi tryout berdasarkan ID
        $tryout = Tryout::findOrFail($tryout_id);

        // 2. Ambil pengguna yang sedang login
        $user = Auth::user();

        // 3. Ambil semua riwayat pengerjaan (attempts) yang relevan dari database
        $attempts = TryoutAttempt::where('user_id', $user->id)
            ->where('tryout_id', $tryout->tryout_id)
            ->where('status', 'submitted') // Hanya tampilkan yang sudah selesai
            ->orderBy('end_time', 'desc') // Urutkan dari yang terbaru
            ->get();

        // 4. Kirim data ke view baru
        return view('tryout.tryout-history', [
            'tryout' => $tryout,
            'attempts' => $attempts,
        ]);
    }


    public function indexAdmin(Request $request)
    {
        $search = $request->input('search');

        $query = Tryout::with('category');
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        // paginate 10 per halaman
        $allTryout = $query->paginate(10);

        return view('admin.tryout.index', compact('allTryout', 'search'));
    }

    public function create()
    {
        $categories = QuestionBankCategory::all();
        return view('admin.tryout.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:' . date('Y'),
            'duration_minutes' => 'required|integer|min:1',
            'category_id' => 'required|exists:question_bank_categories,id',
        ]);

        Tryout::create([
            'title' => $request->title,
            'year' => $request->year,
            'duration_minutes' => $request->duration_minutes,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.tryout')->with('success', 'Try Out berhasil ditambahkan!');
    }

    public function edit(Tryout $tryout)
    {
        $categories = QuestionBankCategory::all();
        
        return view('admin.tryout.edit', compact('tryout', 'categories'));
    }
    

    public function update(Request $request, Tryout $tryout)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:' . date('Y'),
            'duration_minutes' => 'required|integer|min:1',
            'category_id' => 'required|exists:question_bank_categories,id',
        ]);

        $tryout->update([
            'title' => $request->title,
            'year' => $request->year,
            'duration_minutes' => $request->duration_minutes,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.tryout')->with('success', 'Try Out berhasil diperbarui!');
    }

    public function destroy(Tryout $tryout)
    {
        $tryout->delete();
        return redirect()->route('admin.tryout')->with('success', 'Try Out berhasil dihapus!');
    }

    public function show(Tryout $tryout, Request $request)
    {
        // 1. Ambil informasi tryout berdasarkan ID
        $tryout = Tryout::with('questions')->findOrFail($tryout->tryout_id);

        // 2. Paginate questions
        $questions = $tryout->questions()->paginate(10);

        return view('admin.tryout.show', compact('tryout', 'questions'));
    }
}
