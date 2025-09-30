<?php

namespace App\Services;

use App\Services\Contracts\NotificationServiceInterface;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;

class NotificationService implements NotificationServiceInterface
{
    public function sendEmailVerification($user): void
    {
        $user->sendEmailVerificationNotification();
    }

    public function sendPasswordResetLink($user, string $token): void
    {
        $user->sendPasswordResetNotification($token);
    }
}
