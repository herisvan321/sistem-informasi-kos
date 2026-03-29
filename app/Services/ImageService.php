<?php

namespace App\Services;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Convert an uploaded image to WebP format.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string|null
     */
    public function convertToWebp(UploadedFile $file, string $directory): ?string
    {
        $filename = Str::uuid() . '.webp';
        $path = $directory . '/' . $filename;

        // Convert and save
        $fullPath = Storage::disk('public')->path($path);
        
        // Ensure parent directory exists physically for the Webp package
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $success = Webp::make($file)->save($fullPath);

        return $success ? $path : null;
    }
}
