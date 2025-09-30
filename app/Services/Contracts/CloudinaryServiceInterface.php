<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface CloudinaryServiceInterface
{
    /**
     * Upload file to Cloudinary
     *
     * @param UploadedFile $file
     * @param array $options
     * @return array
     */
    public function upload(UploadedFile $file, array $options = []): array;
    
    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @return array
     */
    public function delete(string $publicId): array;
    
    /**
     * Get optimized URL from Cloudinary
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    public function getOptimizedUrl(string $publicId, array $transformations = []): string;
    
    /**
     * Upload profile image with specific configurations
     *
     * @param UploadedFile $file
     * @param string|null $oldPublicId
     * @return array
     */
    public function uploadProfileImage(UploadedFile $file, ?string $oldPublicId = null): array;
}