<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\Contracts\PasswordServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    protected FileUploadServiceInterface $fileUploadService;
    protected PasswordServiceInterface $passwordService;

    public function __construct(
        FileUploadServiceInterface $fileUploadService,
        PasswordServiceInterface $passwordService
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->passwordService = $passwordService;
    }

    /**
     * Update user profile information
     */
    public function updateProfile(User $user, array $validatedData): User
    {
        return DB::transaction(function () use ($user, $validatedData) {
            // Handle photo upload if provided
            if (isset($validatedData['photo'])) {
                $photoPath = $this->fileUploadService->uploadProfilePhoto(
                    $validatedData['photo'], 
                    $user->avatar // Ubah dari foto_profil ke avatar
                );
                $validatedData['avatar'] = $photoPath; // Ubah dari foto_profil ke avatar
                unset($validatedData['photo']);
            }

            // Handle password update if provided
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = $this->passwordService->hashPassword($validatedData['password']);
                // Remove password_confirmation from data
                unset($validatedData['password_confirmation']);
            } else {
                // Remove password fields if empty
                unset($validatedData['password'], $validatedData['password_confirmation']);
            }

            // Map form fields to database fields
            $userData = $this->mapFormDataToUserData($validatedData, $user);

            // Update user
            $user->fill($userData);
            $user->save();

            return $user;
        });
    }

    /**
     * Delete user profile and associated data
     */
    public function deleteProfile(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Delete profile photo if exists
            if ($user->avatar) { // Ubah dari foto_profil ke avatar
                $this->fileUploadService->deleteProfilePhoto($user->avatar);
            }

            // Logout user
            Auth::logout();

            // Delete user record
            $user->delete();
        });
    }

    /**
     * Map form data to user model fields
     */
    protected function mapFormDataToUserData(array $validatedData, User $user): array
    {
        $userData = [];

        // Basic profile fields
        if (isset($validatedData['first_name'])) {
            $userData['nama_depan'] = $validatedData['first_name'];
        }

        if (isset($validatedData['last_name'])) {
            $userData['nama_belakang'] = $validatedData['last_name'];
        }

        if (isset($validatedData['whatsapp'])) {
            $userData['no_whatsapp'] = $validatedData['whatsapp'];
        }

        if (isset($validatedData['birth_date'])) {
            $userData['tanggal_lahir'] = $validatedData['birth_date'];
        }

        if (isset($validatedData['gender'])) {
            $userData['jenis_kelamin'] = $validatedData['gender'];
        }

        // Photo field - ubah dari foto_profil ke avatar
        if (isset($validatedData['avatar'])) {
            $userData['avatar'] = $validatedData['avatar'];
        }

        // Password field
        if (isset($validatedData['password'])) {
            $userData['password'] = $validatedData['password'];
        }

        return $userData;
    }
}