<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Tentukan primary key kustom.
     */
    protected $primaryKey = 'question_id';

    protected $fillable = [
        'category_id',
        'question_type_id',
        'question_text',
        'image_url',
        'explanation',
        'correct_answer_text',
    ];

    /**
     * Satu soal dimiliki oleh satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(QuestionBankCategory::class, 'category_id');
    }

    /**
     * Satu soal memiliki satu tipe.
     */
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    /**
     * Satu soal (pilihan ganda) memiliki banyak opsi jawaban.
     */
    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'question_id');
    }
}