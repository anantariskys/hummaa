<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TryoutQuestion extends Pivot
{
    /**
     * Tentukan nama tabel secara eksplisit karena nama model tidak mengikuti konvensi.
     */
    protected $table = 'tryout_questions';

    /**
     * Tentukan kolom yang bisa diisi.
     */
    protected $fillable = [
        'tryout_id',
        'question_id',
        'question_number',
    ];

    /**
     * Pivot ini tidak memiliki primary key incrementing.
     */
    public $incrementing = true; // Karena Anda punya kolom 'id' di migrasi

    /**
     * Pivot ini memiliki timestamps.
     */
    public $timestamps = true;

    // Anda juga bisa menambahkan relasi dari pivot itu sendiri jika perlu
    public function tryout()
    {
        return $this->belongsTo(Tryout::class, 'tryout_id', 'tryout_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}