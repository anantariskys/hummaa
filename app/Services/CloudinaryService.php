<?php

namespace App\Services;

use App\Services\Contracts\CloudinaryServiceInterface;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Quality;
use Cloudinary\Transformation\Format;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class CloudinaryService implements CloudinaryServiceInterface
{
    protected Cloudinary $cloudinary;
    
    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }
    
    /**
     * Upload file to Cloudinary
     */
    public function upload(UploadedFile $file, array $options = []): array
    {
        try {
            $defaultOptions = [
                'folder' => 'PPKin_ProfilePhotos',
                'use_filename' => false,
                'unique_filename' => true,
                'overwrite' => false,
                'resource_type' => 'image',
            ];
            
            $uploadOptions = array_merge($defaultOptions, $options);
            
            $response = $this->cloudinary->uploadApi()->upload(
                $file->getPathname(),
                $uploadOptions
            );
            
            // Convert Cloudinary response to array
            $result = $response->getArrayCopy();
            
            Log::info('Cloudinary upload successful', [
                'public_id' => $result['public_id'] ?? 'unknown',
                'secure_url' => $result['secure_url'] ?? 'unknown'
            ]);
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            
            throw new Exception('Failed to upload image to Cloudinary: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete file from Cloudinary
     */
    public function delete(string $publicId): array
    {
        try {
            $response = $this->cloudinary->uploadApi()->destroy($publicId);
            
            // Convert Cloudinary response to array
            $result = $response->getArrayCopy();
            
            Log::info('Cloudinary delete successful', [
                'public_id' => $publicId,
                'result' => $result['result'] ?? 'unknown'
            ]);
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Cloudinary delete failed', [
                'error' => $e->getMessage(),
                'public_id' => $publicId
            ]);
            
            throw new Exception('Failed to delete image from Cloudinary: ' . $e->getMessage());
        }
    }
    
    /**
     * Get optimized URL from Cloudinary
     */
    public function getOptimizedUrl(string $publicId, array $transformations = []): string
    {
        try {
            $transformation = $this->cloudinary->image($publicId);
            
            // Apply default optimizations
            $transformation = $transformation
                ->resize(Resize::fill()->width(200)->height(200))
                ->quality(Quality::auto())
                ->format(Format::auto());
            
            // Apply custom transformations if provided
            foreach ($transformations as $key => $value) {
                switch ($key) {
                    case 'width':
                    case 'height':
                        $transformation = $transformation->resize(
                            Resize::fill()
                                ->width($transformations['width'] ?? 200)
                                ->height($transformations['height'] ?? 200)
                        );
                        break;
                    case 'quality':
                        $transformation = $transformation->quality($value);
                        break;
                    case 'format':
                        $transformation = $transformation->format($value);
                        break;
                }
            }
            
            return $transformation->toUrl();
            
        } catch (Exception $e) {
            Log::error('Failed to generate Cloudinary URL', [
                'error' => $e->getMessage(),
                'public_id' => $publicId
            ]);
            
            // Return fallback URL
            return asset('images/default-profile.jpeg');
        }
    }
    
    /**
     * Upload profile image with specific configurations
     */
    public function uploadProfileImage(UploadedFile $file, ?string $oldPublicId = null): array
    {
        // Delete old image if exists
        if ($oldPublicId) {
            try {
                $this->delete($oldPublicId);
            } catch (Exception $e) {
                Log::warning('Failed to delete old profile image', [
                    'public_id' => $oldPublicId,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Upload new image with profile-specific options
        $options = [
            'folder' => 'PPKin_ProfilePhotos',
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill',
                'gravity' => 'face',
                'quality' => 'auto:good',
                'format' => 'webp'
            ],
            'tags' => ['profile_photo', 'avatar']
        ];
        
        return $this->upload($file, $options);
    }
}