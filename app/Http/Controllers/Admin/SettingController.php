<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Setting;
use App\Services\SettingService;
use App\Services\CategoryService;
use App\Services\BannerService;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;

class SettingController extends Controller
{
    protected $settingService;
    protected $categoryService;
    protected $bannerService;

    public function __construct(
        SettingService $settingService,
        CategoryService $categoryService,
        BannerService $bannerService
    ) {
        $this->settingService = $settingService;
        $this->categoryService = $categoryService;
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $categories = Category::all();
        $banners = Banner::all();
        return view('admin.settings.index', compact('settings', 'categories', 'banners'));
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->validated() as $key => $value) {
            $this->settingService->updateByKey($key, $value);
        }
        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function storeCategory(StoreCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory(Category $category)
    {
        $this->categoryService->delete($category->id);
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function storeBanner(StoreBannerRequest $request)
    {
        $this->bannerService->storeBanner($request->validated(), $request->file('image'));
        return back()->with('success', 'Banner berhasil ditambahkan!');
    }

    public function updateBanner(UpdateBannerRequest $request, Banner $banner)
    {
        $this->bannerService->updateBanner($banner, $request->validated(), $request->file('image'));
        return back()->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroyBanner(Banner $banner)
    {
        $this->bannerService->delete($banner->id);
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
