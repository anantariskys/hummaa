<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function show(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('verified', true);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return redirect()->route('dashboard')
            ->with('status', 'Email berhasil diverifikasi!');
    }

    /**
     * Send a new email verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        // Simple rate limiting
        $key = 'email-verification:' . $request->user()->id;
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.'
            ]);
        }

        $request->user()->sendEmailVerificationNotification();
        RateLimiter::hit($key, 3600);

        return back()->with('status', 'Link verifikasi telah dikirim!');
    }
}