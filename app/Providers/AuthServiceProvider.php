<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\EmailVerificationServiceInterface;
use App\Services\Contracts\PasswordResetServiceInterface;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Contracts\ErrorHandlingServiceInterface;
use App\Services\Contracts\RateLimitServiceInterface;
use App\Services\EmailVerificationService;
use App\Services\PasswordResetService;
use App\Services\NotificationService;
use App\Services\ErrorHandlingService;
use App\Services\RateLimitService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            EmailVerificationServiceInterface::class,
            EmailVerificationService::class
        );

        $this->app->bind(
            PasswordResetServiceInterface::class,
            PasswordResetService::class
        );

        $this->app->bind(
            NotificationServiceInterface::class,
            NotificationService::class
        );

        $this->app->bind(
            ErrorHandlingServiceInterface::class,
            ErrorHandlingService::class
        );

        $this->app->bind(
            RateLimitServiceInterface::class,
            RateLimitService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}