<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionBankCategory;
use App\Models\Question;
use App\Models\Tryout;
use App\Models\TryoutQuestion;
use App\Models\QuestionType;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTryoutController extends Controller
{
    /**
     * Display a listing of tryouts.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Tryout::with('category');
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('year', 'like', '%' . $search . '%');
            });
        }

        $allTryout = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.tryout.index', compact('allTryout', 'search'));
    }

    /**
     * Show the form for creating a new tryout.
     */
    public function create()
    {
        $categories = QuestionBankCategory::all();
        return view('admin.tryout.create', compact('categories'));
    }

    /**
     * Store a newly created tryout in storage.
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

        return redirect()->route('admin.tryout.index')->with('success', 'Try Out berhasil ditambahkan!');
    }

    /**
     * Display the specified tryout with questions.
     */
    public function show($tryout_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        
        // Get questions through pivot table
        $questionsQuery = Question::join('tryout_questions', 'questions.question_id', '=', 'tryout_questions.question_id')
            ->where('tryout_questions.tryout_id', $tryout->tryout_id)
            ->orderBy('tryout_questions.question_number', 'asc')
            ->select('questions.*', 'tryout_questions.question_number');
        
        $questions = $questionsQuery->paginate(10);

        return view('admin.tryout.show', compact('tryout', 'questions'));
    }

    /**
     * Show the form for editing the specified tryout.
     */
    public function edit($tryout_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        $categories = QuestionBankCategory::all();
        
        return view('admin.tryout.edit', compact('tryout', 'categories'));
    }

    /**
     * Update the specified tryout in storage.
     */
    public function update(Request $request, $tryout_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:' . date('Y'),
            'duration_minutes' => 'required|integer|min:1',
            'category_id' => 'required|exists:question_bank_categories,id',
        ]);

        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        
        $tryout->update([
            'title' => $request->title,
            'year' => $request->year,
            'duration_minutes' => $request->duration_minutes,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.tryout.index')->with('success', 'Try Out berhasil diperbarui!');
    }

    /**
     * Remove the specified tryout from storage.
     */
    public function destroy($tryout_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        $tryout->delete();
        
        return redirect()->route('admin.tryout.index')->with('success', 'Try Out berhasil dihapus!');
    }

    /**
     * Show form to create question for tryout
     */
    public function createQuestion($tryout_id)
    {
        $tryout = Tryout::with('category')->where('tryout_id', $tryout_id)->firstOrFail();
        
        // Get next question number
        $maxNumber = TryoutQuestion::where('tryout_id', $tryout->tryout_id)
            ->max('question_number');
            
        $nextQuestionNumber = $maxNumber ? $maxNumber + 1 : 1;
        
        // Get question types
        $questionTypes = QuestionType::all();
        
        return view('admin.tryout.questions.create', compact('tryout', 'nextQuestionNumber', 'questionTypes'));
    }

    /**
     * Store question for tryout
     */
    public function storeQuestion(Request $request, $tryout_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        
        $rules = [
            'question_text' => 'required|string',
            'question_type_id' => 'required|exists:question_types,id',
            'question_number' => 'required|integer|min:1',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|url',
        ];
        
        // Get question type to check if multiple choice
        $questionType = QuestionType::find($request->question_type_id);
        
        // Add validation - sesuaikan dengan nilai di database: "multiple_choice" dan "essay"
        if ($questionType && $questionType->type === 'multiple_choice') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.option_text'] = 'required|string';
            $rules['options.*.is_correct'] = 'required|boolean';
        } else if ($questionType && $questionType->type === 'essay') {
            // Untuk essay, kunci jawaban wajib diisi
            $rules['correct_answer_text'] = 'required|string';
        }
        
        $validated = $request->validate($rules);
        
        DB::beginTransaction();
        
        try {
            // Create question data dengan category_id dari tryout
            $questionData = [
                'question_text' => $validated['question_text'],
                'question_type_id' => $validated['question_type_id'],
                'category_id' => $tryout->category_id,
                'explanation' => $validated['explanation'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
                'correct_answer_text' => $validated['correct_answer_text'] ?? null,
            ];
            
            // Create the question
            $question = Question::create($questionData);
            
            // Create options for multiple choice
            if ($questionType && $questionType->type === 'multiple_choice' && isset($validated['options'])) {
                foreach ($validated['options'] as $option) {
                    Option::create([
                        'question_id' => $question->question_id,
                        'option_text' => $option['option_text'],
                        'is_correct' => $option['is_correct'] ?? false,
                    ]);
                }
            }
            
            // Create pivot record in tryout_questions
            TryoutQuestion::create([
                'tryout_id' => $tryout->tryout_id,
                'question_id' => $question->question_id,
                'question_number' => $validated['question_number'],
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('admin.tryout.show', $tryout_id)
                ->with('success', 'Soal berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan soal: ' . $e->getMessage()]);
        }
    }

    /**
     * Show form to edit question
     */
    public function editQuestion($tryout_id, $question_id)
    {
        $tryout = Tryout::with('category')->where('tryout_id', $tryout_id)->firstOrFail();
        $question = Question::where('question_id', $question_id)->with('options')->firstOrFail();
        
        // Get question number from pivot table
        $tryoutQuestion = TryoutQuestion::where('tryout_id', $tryout->tryout_id)
            ->where('question_id', $question->question_id)
            ->first();
        
        $questionNumber = $tryoutQuestion ? $tryoutQuestion->question_number : 1;
        
        // Get question types
        $questionTypes = QuestionType::all();
        
        return view('admin.tryout.questions.edit', compact('tryout', 'question', 'questionNumber', 'questionTypes'));
    }

    /**
     * Update question
     */
    public function updateQuestion(Request $request, $tryout_id, $question_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        $question = Question::where('question_id', $question_id)->firstOrFail();
        
        $rules = [
            'question_text' => 'required|string',
            'question_type_id' => 'required|exists:question_types,id',
            'question_number' => 'required|integer|min:1',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|url',
        ];
        
        // Get question type to check if multiple choice
        $questionType = QuestionType::find($request->question_type_id);
        
        // Add validation - sesuaikan dengan nilai di database: "multiple_choice" dan "essay"
        if ($questionType && $questionType->type === 'multiple_choice') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*.option_text'] = 'required|string';
            $rules['options.*.is_correct'] = 'required|boolean';
        } else if ($questionType && $questionType->type === 'essay') {
            // Untuk essay, kunci jawaban wajib diisi
            $rules['correct_answer_text'] = 'required|string';
        }
        
        $validated = $request->validate($rules);
        
        DB::beginTransaction();
        
        try {
            // Update question data dengan category_id dari tryout
            $question->update([
                'question_text' => $validated['question_text'],
                'question_type_id' => $validated['question_type_id'],
                'category_id' => $tryout->category_id,
                'explanation' => $validated['explanation'] ?? null,
                'image_url' => $validated['image_url'] ?? null,
                'correct_answer_text' => $validated['correct_answer_text'] ?? null,
            ]);
            
            // Update options for multiple choice
            if ($questionType && $questionType->type === 'multiple_choice' && isset($validated['options'])) {
                // Delete old options
                Option::where('question_id', $question->question_id)->delete();
                
                // Create new options
                foreach ($validated['options'] as $option) {
                    Option::create([
                        'question_id' => $question->question_id,
                        'option_text' => $option['option_text'],
                        'is_correct' => $option['is_correct'] ?? false,
                    ]);
                }
            } else {
                // Clear options if changed to essay
                Option::where('question_id', $question->question_id)->delete();
            }
            
            // Update question number in pivot table
            TryoutQuestion::where('tryout_id', $tryout->tryout_id)
                ->where('question_id', $question->question_id)
                ->update(['question_number' => $validated['question_number']]);
            
            DB::commit();
            
            return redirect()
                ->route('admin.tryout.show', $tryout_id)
                ->with('success', 'Soal berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui soal: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete question
     */
    public function destroyQuestion($tryout_id, $question_id)
    {
        $tryout = Tryout::where('tryout_id', $tryout_id)->firstOrFail();
        $question = Question::where('question_id', $question_id)->firstOrFail();
        
        DB::beginTransaction();
        
        try {
            // Delete pivot record
            TryoutQuestion::where('tryout_id', $tryout->tryout_id)
                ->where('question_id', $question->question_id)
                ->delete();
            
            // Check if question is used in other tryouts
            $usedInOtherTryouts = TryoutQuestion::where('question_id', $question->question_id)
                ->exists();
            
            // If not used anywhere else, delete the question and its options
            if (!$usedInOtherTryouts) {
                Option::where('question_id', $question->question_id)->delete();
                $question->delete();
            }
            
            DB::commit();
            
            return redirect()
                ->route('admin.tryout.show', $tryout_id)
                ->with('success', 'Soal berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withErrors(['error' => 'Gagal menghapus soal: ' . $e->getMessage()]);
        }
    }
}