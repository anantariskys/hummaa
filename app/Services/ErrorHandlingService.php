<?php

namespace App\Services;

use App\Services\Contracts\ErrorHandlingServiceInterface;
use Illuminate\Support\Facades\Log;

class ErrorHandlingService implements ErrorHandlingServiceInterface
{
    public function handleEmailError(\Exception $e, string $context): void
    {
        Log::error("Email Error in {$context}: " . $e->getMessage(), [
            'exception' => $e,
            'context' => $context,
            'trace' => $e->getTraceAsString()
        ]);
    }

    public function logSecurityEvent(string $event, array $data): void
    {
        Log::info("Security Event: {$event}", $data);
    }
}