<?php

namespace App\Services\Contracts;

interface FileUploadServiceInterface
{
    /**
     * Get profile photo URL with fallback to default
     *
     * @param string|null $photoPath
     * @return string
     */
    public function getProfilePhotoUrl(?string $photoPath): string;
    
    /**
     * Upload profile photo
     *
     * @param mixed $file
     * @param string|null $oldPhotoPath
     * @return string
     */
    public function uploadProfilePhoto($file, ?string $oldPhotoPath = null): string;
    
    /**
     * Delete profile photo
     *
     * @param string $photoPath
     * @return bool
     */
    public function deleteProfilePhoto(string $photoPath): bool;
}