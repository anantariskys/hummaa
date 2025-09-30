<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'answer_text',
    ];

    /**
     * Satu jawaban dimiliki oleh satu attempt.
     */
    public function attempt()
    {
        return $this->belongsTo(TryoutAttempt::class, 'attempt_id', 'attempt_id');
    }

    /**
     * Satu jawaban merujuk ke satu soal.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }

    /**
     * Satu jawaban (jika PG) merujuk ke satu opsi yang dipilih.
     */
    public function selectedOption()
    {
        return $this->belongsTo(Option::class, 'selected_option_id', 'option_id');
    }
}