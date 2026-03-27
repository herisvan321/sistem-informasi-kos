<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Buglinjo\LaravelWebp\Facades\Webp;

class BannerService extends BaseService
{
    public function __construct(Banner $banner)
    {
        parent::__construct($banner);
    }

    public function storeBanner(array $data, $imageFile): Banner
    {
        if ($imageFile) {
            $data['image_path'] = $this->uploadAndConvert($imageFile);
        }

        return Banner::create($data);
    }

    public function updateBanner(Banner $banner, array $data, $imageFile): bool
    {
        if ($imageFile) {
            $data['image_path'] = $this->uploadAndConvert($imageFile);
        }

        return $banner->update($data);
    }

    protected function uploadAndConvert($imageFile): string
    {
        $filename = time() . '.webp';
        $directory = 'banners';
        $path = storage_path('app/public/' . $directory);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $webp = Webp::make($imageFile);
        if ($webp->save($path . '/' . $filename)) {
            return $directory . '/' . $filename;
        }

        throw new \Exception('Failed to convert image to WebP');
    }
}
