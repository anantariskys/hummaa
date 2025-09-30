<?php

namespace App\Services\Contracts;

interface EmailVerificationServiceInterface
{
    public function sendVerificationEmail($user): bool;
    public function verifyEmail(string $token, int $userId): bool;
    public function isEmailVerified($user): bool;
}

interface PasswordResetServiceInterface
{
    public function sendResetLink(string $email): string;
    public function resetPassword(array $credentials): string;
    public function validateResetToken(string $token, string $email): bool;
}

interface NotificationServiceInterface
{
    public function sendEmailVerification($user): void;
    public function sendPasswordResetLink($user, string $token): void;
}

interface ErrorHandlingServiceInterface
{
    public function handleEmailError(\Exception $e, string $context): void;
    public function logSecurityEvent(string $event, array $data): void;
}

interface RateLimitServiceInterface
{
    public function attemptEmailVerification($request): bool;
    public function attemptPasswordReset($request): bool;
    public function clearAttempts(string $key): void;
}