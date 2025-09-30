<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionBankCategory;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Question::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question_text', 'like', '%' . $search . '%');
            });
        }

        // paginate 10 per halaman
        $questions = $query->paginate(10);

        return view('admin.question.index', compact('questions', 'search'));
    }

    public function create()
    {
        $categories = QuestionBankCategory::all();
        $questionTypes = QuestionType::all();
        return view('admin.question.create', compact('categories', 'questionTypes'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'category_id'        => 'required|exists:question_bank_categories,id',
            'question_type_id'   => 'required|exists:question_types,id',
            'question_text'      => 'required|string',
            'explanation'        => 'required|string',
            'image'              => 'nullable|image|max:2048', // kalau ada upload gambar
        ]);

        // kalau tipe 1 (multiple choice) wajib ada options
        if ($request->question_type_id == 1) {
            $request->validate([
                'options'           => 'required|array|size:4', // 4 opsi
                'options.*.text'    => 'required|string',
                'options.*.is_correct' => 'boolean'
            ]);
        }

        // kalau tipe 2 (short answer) wajib ada correct_answer_text
        if ($request->question_type_id == 2) {
            $request->validate([
                'correct_answer_text' => 'required|string'
            ]);
        }

        // Upload image kalau ada
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = $request->file('image')->store('question_images', 'public');
        }

        // Simpan question dulu
        $question = Question::create([
            'category_id'         => $request->category_id,
            'question_type_id'    => $request->question_type_id,
            'question_text'       => $request->question_text,
            'image_url'           => $imageUrl,
            'explanation'         => $request->explanation,
            'correct_answer_text' => $request->question_type_id == 2 ? $request->correct_answer_text : null,
        ]);


        // Kalau multiple choice simpan options
        if ($request->question_type_id == 1) {
            foreach ($request->options as $opt) {
                Option::create([
                    'question_id' => $question->question_id,
                    'option_text' => $opt['text'],
                    'is_correct'  => !empty($opt['is_correct']) ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('admin.questions', $request->tryout_id)
            ->with('success', 'Soal berhasil ditambahkan.');
    }
}
