<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;

    /**
     * Tentukan primary key kustom.
     */
    protected $primaryKey = 'tryout_id';

    protected $fillable = [
        'title',
        'duration_minutes',
        'year',
        'category_id',
    ];

    /**
     * Relasi many-to-many antara Tryout dan Question.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'tryout_questions', 'tryout_id', 'question_id')
                    ->using(TryoutQuestion::class) // <-- Tambahkan baris ini
                    ->withPivot('question_number')
                    ->orderBy('pivot_question_number', 'asc');
    }

    /**
     * Relasi many-to-one ke Category.
     */
    public function category()
    {
        return $this->belongsTo(QuestionBankCategory::class, 'category_id', 'id');
    }



    /**
     * Satu tryout bisa dikerjakan berkali-kali (banyak attempt).
     */
    public function attempts()
    {
        return $this->hasMany(TryoutAttempt::class, 'tryout_id', 'tryout_id');
    }
}