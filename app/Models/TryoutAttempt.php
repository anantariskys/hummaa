<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutAttempt extends Model
{
    use HasFactory;

    /**
     * Tentukan primary key kustom.
     */
    protected $primaryKey = 'attempt_id';

    protected $fillable = [
        'user_id',
        'tryout_id',
        'start_time',
        'end_time',
        'score',
        'status',
    ];

    /**
     * Konversi otomatis kolom ke tipe data Carbon/DateTime.
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Satu attempt dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Satu attempt merujuk ke satu tryout.
     */
    public function tryout()
    {
        return $this->belongsTo(Tryout::class, 'tryout_id', 'tryout_id');
    }

    /**
     * Satu attempt memiliki banyak jawaban pengguna.
     */
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'attempt_id', 'attempt_id');
    }
}