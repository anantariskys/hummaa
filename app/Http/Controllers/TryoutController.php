<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tryout;
use App\Models\TryoutAttempt;
use App\Models\UserAnswer;
use App\Models\Question;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TryoutController extends Controller
{
    /**
     * Menampilkan halaman landing tryout dengan daftar semua tryout yang tersedia
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua events yang memiliki tryout terhubung
        $tryouts = Events::with(['tryout' => function($query) {
                            $query->with('questions');
                        }])
                        ->whereHas('tryout')
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function($event) use ($user) {
                            // Tambahkan status pendaftaran ke setiap event
                            $event->is_registered = $event->isRegisteredBy($user->id);
                            return $event;
                        });

        return view('tryout.tryout-landing-page', compact('tryouts'));
    }

    /**
     * ========== METHOD BARU: PENDAFTARAN EVENT ==========
     */
    
    /**
     * Mendaftarkan user ke event tryout
     */
    public function registerEvent(Request $request, $event_id)
    {
        $user = Auth::user();
        $event = Events::findOrFail($event_id);

        // Cek apakah sudah terdaftar
        if ($event->isRegisteredBy($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar untuk event ini.',
            ], 400);
        }

        try {
            // Buat pendaftaran
            EventRegistration::create([
                'user_id' => $user->id,
                'event_id' => $event_id,
                'registered_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftar event! Tryout sekarang tersedia di Bank Soal.',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mendaftar event: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * ========== METHOD LAMA TETAP ADA ==========
     */

    public function start($tryout_id)
    {
        $tryout = Tryout::findOrFail($tryout_id);
        $user = Auth::user();

        // CEK APAKAH USER SUDAH MENDAFTAR EVENT INI
        if ($tryout->event_id) {
            $event = Events::findOrFail($tryout->event_id);
            
            if (!$event->isRegisteredBy($user->id)) {
                return redirect()
                    ->route('tryout.index')
                    ->with('error', 'Anda harus mendaftar event terlebih dahulu untuk mengakses tryout ini.');
            }
        }

        $attempt = TryoutAttempt::create([
            'user_id' => $user->id,
            'tryout_id' => $tryout->tryout_id,
            'start_time' => now(),
            'status' => 'in_progress',
        ]);

        $questions = $tryout
            ->questions()
            ->with(['options', 'questionType'])
            ->orderBy('tryout_questions.question_number', 'asc')
            ->get();

        $formattedQuestions = $questions->map(function ($q, $index) {
            $questionType = $q->questionType->type;
            $isMultipleChoice = ($questionType === 'multiple_choice');
            
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $isMultipleChoice ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $isMultipleChoice ? $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }) : collect([]),
                'explanation' => $q->explanation,
                'correctAnswer' => $isMultipleChoice 
                    ? ($q->options->search(fn($opt) => $opt->is_correct) !== false 
                        ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) 
                        : null) 
                    : $q->correct_answer_text,
            ];
        });

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'questions' => $formattedQuestions,
            'attempt' => $attempt,
        ]);
    }

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

            $attempt = TryoutAttempt::with('tryout.questions.options', 'tryout.questions.questionType')
                ->findOrFail($attempt_id);
            $answers = $request->input('answers');

            $correctAnswersCount = 0;
            $tryoutQuestions = $attempt->tryout->questions->keyBy('question_id');

            foreach ($answers as $question_id => $answerData) {
                $question = $tryoutQuestions->get($question_id);
                if (!$question) {
                    continue;
                }
                
                $isCorrect = false;
                $questionType = $question->questionType->type;
                
                if ($questionType === 'multiple_choice') {
                    $selectedOptionId = $answerData['optionId'] ?? null;
                    $correctOption = $question->options->firstWhere('is_correct', true);
                    if ($correctOption && $selectedOptionId == $correctOption->option_id) {
                        $isCorrect = true;
                    }
                } elseif ($questionType === 'essay') {
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

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan jawaban.',
                'error' => config('app.debug') ? $e->getMessage() : 'Terjadi kesalahan pada server.',
            ], 500);
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

        $latestAttempt = TryoutAttempt::where('user_id', $user->id)
            ->where('tryout_id', $tryout_id)
            ->where('status', 'submitted')
            ->latest('updated_at')
            ->first();

        if (!$latestAttempt) {
            return redirect()->route('bank-soal.index')
                ->with('error', 'Anda harus menyelesaikan mode tryout terlebih dahulu sebelum masuk ke mode belajar.');
        }

        $questions = $tryout
            ->questions()
            ->with(['options', 'questionType'])
            ->get();
        $userAnswers = UserAnswer::where('attempt_id', $latestAttempt->attempt_id)
            ->get()
            ->keyBy('question_id');

        $formattedQuestions = $questions->map(function ($q, $index) {
            $questionType = $q->questionType->type;
            $isMultipleChoice = ($questionType === 'multiple_choice');
            
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $isMultipleChoice ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $isMultipleChoice ? $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }) : collect([]),
                'explanation' => $q->explanation,
                'correctAnswer' => $isMultipleChoice 
                    ? ($q->options->search(fn($opt) => $opt->is_correct) !== false 
                        ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) 
                        : null) 
                    : $q->correct_answer_text,
            ];
        });

        $formattedAnswers = [];
        foreach ($userAnswers as $question_id => $answer) {
            $question = $questions->find($question_id);
            if ($question && $question->questionType->type === 'multiple_choice') {
                $formattedAnswers[$question_id] = [
                    'key' => $answer->selected_option_id ? chr(65 + $question->options->search(fn($opt) => $opt->option_id == $answer->selected_option_id)) : null,
                    'optionId' => $answer->selected_option_id,
                    'text' => null,
                ];
            } else {
                $formattedAnswers[$question_id] = [
                    'key' => null,
                    'optionId' => null,
                    'text' => $answer->answer_text,
                ];
            }
        }

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'attempt' => $latestAttempt,
            'questions' => $formattedQuestions,
            'userAnswers' => $formattedAnswers,
        ]);
    }

    public function startLearningMode($tryout_id)
    {
        $user = Auth::user();
        $tryout = Tryout::with(['questions.options', 'questions.questionType'])->findOrFail($tryout_id);

        $existingAttempt = TryoutAttempt::where('user_id', $user->id)
            ->where('tryout_id', $tryout->tryout_id)
            ->where('status', 'submitted')
            ->first();

        if (!$existingAttempt) {
            return redirect()
                ->route('bank-soal.index')
                ->with('error', 'Anda harus menyelesaikan Mode Tryout terlebih dahulu sebelum mengakses Mode Belajar.');
        }

        $formattedQuestions = $tryout->questions->map(function ($q, $index) {
            $questionType = $q->questionType->type;
            $isMultipleChoice = ($questionType === 'multiple_choice');
            
            return [
                'id' => $q->question_id,
                'number' => $index + 1,
                'text' => $q->question_text,
                'type' => $isMultipleChoice ? 'pilihan_ganda' : 'isian',
                'image' => $q->image_url ? asset($q->image_url) : null,
                'options' => $isMultipleChoice ? $q->options->mapWithKeys(function ($opt, $optIndex) {
                    $key = chr(65 + $optIndex);
                    return [$key => ['id' => $opt->option_id, 'text' => $opt->option_text]];
                }) : collect([]),
                'explanation' => $q->explanation,
                'correctAnswer' => $isMultipleChoice 
                    ? ($q->options->search(fn($opt) => $opt->is_correct) !== false 
                        ? chr(65 + $q->options->search(fn($opt) => $opt->is_correct)) 
                        : null) 
                    : $q->correct_answer_text,
            ];
        });

        $mockAttempt = (object) [
            'attempt_id' => 0,
        ];

        return view('tryout.tryout-page', [
            'tryout' => $tryout,
            'attempt' => $mockAttempt,
            'questions' => $formattedQuestions,
            'userAnswers' => [],
        ]);
    }

    public function showHistory($tryout_id)
    {
        $tryout = Tryout::findOrFail($tryout_id);
        $user = Auth::user();

        $attempts = TryoutAttempt::where('user_id', $user->id)
            ->where('tryout_id', $tryout->tryout_id)
            ->where('status', 'submitted')
            ->orderBy('end_time', 'desc')
            ->get();

        return view('tryout.tryout-history', [
            'tryout' => $tryout,
            'attempts' => $attempts,
        ]);
    }
}