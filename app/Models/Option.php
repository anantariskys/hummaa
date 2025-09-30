<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * Tentukan primary key kustom.
     */
    protected $primaryKey = 'option_id';

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    /**
     * Satu opsi jawaban dimiliki oleh satu soal.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}