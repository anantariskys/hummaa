<?php

namespace App\Providers;

use App\Services\FileUploadService;
use App\Services\PasswordService;
use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\Contracts\PasswordServiceInterface;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind FileUploadService interface
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
        
        // Bind PasswordService interface
        $this->app->bind(PasswordServiceInterface::class, PasswordService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}