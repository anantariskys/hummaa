<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $this->profileService->updateProfile($request->user(), $request->validated());
            
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil.']);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        try {
            $this->profileService->deleteProfile($request->user());
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return Redirect::to('/');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus akun.']);
        }
    }
}