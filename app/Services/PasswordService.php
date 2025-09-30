<?php

namespace App\Services;

use App\Services\Contracts\PasswordServiceInterface;
use Illuminate\Support\Facades\Hash;

class PasswordService implements PasswordServiceInterface
{
    /**
     * Hash a password
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Verify a password against a hash
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return Hash::check($password, $hash);
    }

    /**
     * Check if password needs to be rehashed
     */
    public function needsRehash(string $hash): bool
    {
        return Hash::needsRehash($hash);
    }

    /**
     * Generate a random password
     */
    public function generateRandomPassword(int $length = 12): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    /**
     * Validate password strength
     */
    public function validatePasswordStrength(string $password): array
    {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'Password minimal 8 karakter';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf besar';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf kecil';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password harus mengandung angka';
        }
        
        return $errors;
    }
}