<?php

namespace App\Services\Contracts;

interface PasswordServiceInterface
{
    public function hashPassword(string $password): string;
    public function verifyPassword(string $password, string $hash): bool;
    public function needsRehash(string $hash): bool;
    public function generateRandomPassword(int $length = 12): string;
    public function validatePasswordStrength(string $password): array;
}