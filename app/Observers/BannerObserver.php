<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerObserver
{
    public function updating(Banner $banner): void
    {
        if ($banner->isDirty('image_path')) {
            $oldImage = $banner->getOriginal('image_path');
            $this->deleteFile($oldImage);
        }
    }

    public function deleted(Banner $banner): void
    {
        $this->deleteFile($banner->image_path);
    }

    protected function deleteFile($path): void
    {
        if ($path && file_exists(storage_path('app/public/' . $path))) {
            @unlink(storage_path('app/public/' . $path));
        }
    }
}
