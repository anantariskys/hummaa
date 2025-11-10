<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'badge',
        'duration',
        'question_count',
        'test_parts',
    ];

    protected $casts = [
        'test_parts' => 'array',
    ];

    /**
     * Relasi One-to-One dengan Tryout
     * Setiap event memiliki satu tryout
     */
    public function tryout()
    {
        return $this->hasOne(Tryout::class, 'event_id', 'id');
    }
}