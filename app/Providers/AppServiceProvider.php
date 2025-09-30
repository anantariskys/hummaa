<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\Contracts\CloudinaryServiceInterface;
use App\Services\FileUploadService;
use App\Services\CloudinaryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Repository Interfaces
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        
        // Bind Cloudinary Service
        $this->app->bind(CloudinaryServiceInterface::class, CloudinaryService::class);
        
        // Bind File Upload Service
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}