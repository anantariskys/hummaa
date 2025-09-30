<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Periksa apakah pengguna memiliki salah satu peran yang diizinkan
        if (!in_array($user->role, $roles)) {
            return redirect('/');
        }

        return $next($request);
    }
}
