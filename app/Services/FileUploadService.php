<?php

namespace App\Services;

use App\Services\Contracts\FileUploadServiceInterface;
use App\Services\Contracts\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class FileUploadService implements FileUploadServiceInterface
{
    private const DEFAULT_PROFILE_IMAGE = 'images/default-profile.jpeg';
    
    protected CloudinaryServiceInterface $cloudinaryService;
    
    public function __construct(CloudinaryServiceInterface $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
    
    /**
     * Get profile photo URL with fallback to default
     */
    public function getProfilePhotoUrl(?string $photoPath): string
    {
        Log::info('getProfilePhotoUrl called with: ' . ($photoPath ?? 'null'));
        
        // If no photo path provided, return default
        if (empty($photoPath)) {
            Log::info('No photo path, returning default: ' . asset(self::DEFAULT_PROFILE_IMAGE));
            return asset(self::DEFAULT_PROFILE_IMAGE);
        }
        
        // Check if it's a full URL (for social login avatars)
        if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
            Log::info('Valid URL detected: ' . $photoPath);
            return $photoPath;
        }
        
        // Try to get Cloudinary URL (assuming photoPath is public_id)
        try {
            $url = $this->cloudinaryService->getOptimizedUrl($photoPath, [
                'width' => 200,
                'height' => 200,
                'quality' => 'auto:good'
            ]);
            
            Log::info('Cloudinary URL generated: ' . $url);
            return $url;
            
        } catch (Exception $e) {
            Log::error('Failed to generate Cloudinary URL', [
                'public_id' => $photoPath,
                'error' => $e->getMessage()
            ]);
            
            // Fallback to default if Cloudinary fails
            Log::info('Cloudinary failed, returning default: ' . asset(self::DEFAULT_PROFILE_IMAGE));
            return asset(self::DEFAULT_PROFILE_IMAGE);
        }
    }
    
    /**
     * Upload profile photo to Cloudinary
     */
    public function uploadProfilePhoto($file, ?string $oldPhotoPath = null): string
    {
        try {
            // Extract public_id from old photo path if it's not a URL
            $oldPublicId = null;
            if ($oldPhotoPath && !filter_var($oldPhotoPath, FILTER_VALIDATE_URL)) {
                $oldPublicId = $oldPhotoPath;
            }
            
            // Upload to Cloudinary
            $result = $this->cloudinaryService->uploadProfileImage($file, $oldPublicId);
            
            // Return the public_id to store in database
            return $result['public_id'];
            
        } catch (Exception $e) {
            Log::error('Profile photo upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            
            throw new Exception('Failed to upload profile photo: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete profile photo from Cloudinary
     */
    public function deleteProfilePhoto(string $photoPath): bool
    {
        // Don't delete if it's a URL (social login avatar)
        if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
            return true;
        }
        
        try {
            $result = $this->cloudinaryService->delete($photoPath);
            return $result['result'] === 'ok';
            
        } catch (Exception $e) {
            Log::error('Profile photo deletion failed', [
                'error' => $e->getMessage(),
                'public_id' => $photoPath
            ]);
            
            return false;
        }
    }
}