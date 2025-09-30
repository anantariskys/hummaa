<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * CORS (Cross-Origin Resource Sharing) middleware
 */
class CorsMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return $this->handlePreflightRequest();
        }

        $response = $next($request);

        return $this->addCorsHeaders($response);
    }

    /**
     * Handle preflight OPTIONS request
     */
    private function handlePreflightRequest()
    {
        return response('', 200)
            ->header('Access-Control-Allow-Origin', $this->getAllowedOrigins())
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->header('Access-Control-Max-Age', '86400');
    }

    /**
     * Add CORS headers to response
     */
    private function addCorsHeaders($response)
    {
        return $response
            ->header('Access-Control-Allow-Origin', $this->getAllowedOrigins())
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Expose-Headers', 'Authorization, X-Request-ID');
    }

    /**
     * Get allowed origins
     */
    private function getAllowedOrigins(): string
    {
        // You can make this configurable
        $allowedOrigins = [
            'http://localhost:3000',
            'http://localhost:8000',
            'http://localhost:5173',
            'http://localhost:8080',
            'https://yourdomain.com'
        ];

        $origin = request()->header('Origin');
        
        if (in_array($origin, $allowedOrigins)) {
            return $origin;
        }

        return '*'; // Be careful with this in production
    }
}