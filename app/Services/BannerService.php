<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Buglinjo\LaravelWebp\Facades\Webp;

class BannerService extends BaseService
{
    protected $imageService;

    public function __construct(Banner $banner, ImageService $imageService)
    {
        parent::__construct($banner);
        $this->imageService = $imageService;
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
        $path = $this->imageService->convertToWebp($imageFile, 'banners');

        if (!$path) {
            throw new \Exception('Failed to convert banner image to WebP');
        }

        return $path;
    }
}
