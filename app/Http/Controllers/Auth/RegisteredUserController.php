<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

               // ✅ Langsung tandai email user sebagai terverifikasi
            $user->markEmailAsVerified();

            event(new Registered($user));
            Auth::login($user);

            // Simple logging
            Log::info('User registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            return redirect()->route('verification.notice')
                ->with('status', 'Akun berhasil dibuat! Silakan cek email untuk verifikasi.');

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['registration' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.']);
        }
    }
}