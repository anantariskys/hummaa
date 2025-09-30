<?php

namespace App\Services;

use App\Services\Contracts\RateLimitServiceInterface;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitService implements RateLimitServiceInterface
{
    public function attemptEmailVerification($request): bool
    {
        $key = 'email-verification:' . $request->user()->id;
        
        return RateLimiter::attempt($key, 3, function() {
        
        }, 3600); // 1 hour window
    }

    public function attemptPasswordReset($request): bool
    {
        $key = 'password-reset:' . $request->ip() . ':' . $request->input('email');
        
        return RateLimiter::attempt($key, 5, function() {
            // Allow the attempt
        }, 3600); // 1 hour window
    }

    public function clearAttempts(string $key): void
    {
        RateLimiter::clear($key);
    }
}