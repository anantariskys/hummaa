<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    /**
     * Tabel ini tidak memiliki kolom created_at dan updated_at.
     */
    public $timestamps = false;

    /**
     * Satu tipe soal dimiliki oleh banyak soal.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'question_type_id');
    }
}