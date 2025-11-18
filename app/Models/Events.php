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

    /**
 * Relasi many-to-many dengan Users melalui event_registrations
 */
public function registeredUsers()
{
    return $this->belongsToMany(User::class, 'event_registrations', 'event_id', 'user_id')
                ->withTimestamps()
                ->withPivot('registered_at');
}

/**
 * Cek apakah user tertentu sudah mendaftar event ini
 */
public function isRegisteredBy($userId): bool
{
    return $this->registeredUsers()->where('user_id', $userId)->exists();
}

/**
 * Hitung total peserta yang sudah mendaftar
 */
public function getTotalRegistrantsAttribute(): int
{
    return $this->registeredUsers()->count();
}

}