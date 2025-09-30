<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;
class GoogleAuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback and authenticate user
     */
    public function handleGoogleCallback(): User
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            return $this->findOrCreateUser($googleUser);
        } catch (Exception $e) {
            throw new Exception('Google authentication failed:  ' . $e->getMessage());
        }
    }

    /**
     * Find existing user or create new one
     */
    protected function findOrCreateUser(SocialiteUser $googleUser): User
    {
        // First, check if user exists by provider ID
        $existingUser = $this->userRepository->findByProvider('google', $googleUser->getId());
        
        if ($existingUser) {
            return $this->updateUserInfo($existingUser, $googleUser);
        }

        // Check if user exists by email (from regular registration)
        $userByEmail = $this->userRepository->findByEmail($googleUser->getEmail());
        
        if ($userByEmail) {
            return $this->linkGoogleAccount($userByEmail, $googleUser);
        }

        // Create new user
        return $this->createNewUser($googleUser);
    }

    /**
     * Update existing Google user info
     */
    protected function updateUserInfo(User $user, SocialiteUser $googleUser): User
    {
        return $this->userRepository->update($user, [
            'name' => $googleUser->getName(),
            'avatar' => $googleUser->getAvatar(),
        ]);
    }

    /**
     * Link Google account to existing user
     */
    protected function linkGoogleAccount(User $user, SocialiteUser $googleUser): User
    {
        return $this->userRepository->update($user, [
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);
    }

    /**
     * Create new user from Google data
     */
    protected function createNewUser(SocialiteUser $googleUser): User
    {
        return $this->userRepository->create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(), // Google emails are pre-verified
            'password' => Hash::make(Str::random(32)), // Random password for security
        ]);
    }
}