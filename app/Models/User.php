<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Services\Contracts\FileUploadServiceInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nama_depan',
        'nama_belakang',
        'email',
        'no_whatsapp',
        'tanggal_lahir',
        'jenis_kelamin',
        'avatar', 
        'password',
        'provider',
        'provider_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        // Fallback to 'name' field if nama_depan/nama_belakang not set
        if ($this->nama_depan || $this->nama_belakang) {
            return trim($this->nama_depan . ' ' . $this->nama_belakang);
        }
        
        return $this->name ?? '';
    }

    /**
     * Get the user's profile picture URL.
     */
    public function getProfilePictureUrlAttribute(): string
    {
        $fileUploadService = app(FileUploadServiceInterface::class);
        
        return $fileUploadService->getProfilePhotoUrl($this->avatar);
    }

    /**
     * Check if user registered via social provider
     */
    public function isSocialUser(): bool
    {
        return !is_null($this->provider);
    }

    /**
     * Check if user registered via Google
     */
    public function isGoogleUser(): bool
    {
        return $this->provider === 'google';
    }

    /**
     * Check if user can change password
     * Social users might not be able to change password
     */
    public function canChangePassword(): bool
    {
        return !$this->isSocialUser();
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->no_whatsapp) {
            return '';
        }

        $phone = $this->no_whatsapp;
        
        // If starts with +62, format it nicely
        if (str_starts_with($phone, '+62')) {
            return '+62 ' . substr($phone, 3);
        }
        
        return $phone;
    }

    /**
     * Scope to filter by gender
     */
    public function scopeByGender($query, string $gender)
    {
        return $query->where('jenis_kelamin', $gender);
    }

    /**
     * Scope to filter verified users
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
}