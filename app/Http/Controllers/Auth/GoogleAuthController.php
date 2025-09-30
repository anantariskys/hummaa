<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\GoogleAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleAuthController extends Controller
{
    protected GoogleAuthService $googleAuthService;

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle(): RedirectResponse
    {
        try {
            return $this->googleAuthService->redirectToGoogle();
        } catch (Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Gagal menghubungkan ke Google. Silakan coba lagi.');
        }
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $user = $this->googleAuthService->handleGoogleCallback();

            Auth::login($user, true);

            return redirect()->intended(route('materi'))
                ->with('success', 'Berhasil masuk dengan akun Google!');

        } catch (Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Autentikasi Google gagal: ' . $e->getMessage());
        }
    }

}
