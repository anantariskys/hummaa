<?php

namespace App\Services;

use App\Services\Contracts\EmailVerificationServiceInterface;
use App\Services\Contracts\NotificationServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmailVerificationService implements EmailVerificationServiceInterface
{
    public function __construct(
        private NotificationServiceInterface $notificationService
    ) {}

    public function sendVerificationEmail($user): bool
    {
        try {
            $this->notificationService->sendEmailVerification($user);
            return true;
        } catch (\Exception $e) {
            Log::error('Email verification failed: ' . $e->getMessage());
            return false;
        }
    }

    public function verifyEmail(string $token, int $userId): bool
    {
        $user = User::find($userId);
        
        if (!$user || $user->hasVerifiedEmail()) {
            return false;
        }

        // Laravel handles signature validation through signed middleware
        $user->markEmailAsVerified();
        return true;
    }

    public function isEmailVerified($user): bool
    {
        return $user->hasVerifiedEmail();
    }
}