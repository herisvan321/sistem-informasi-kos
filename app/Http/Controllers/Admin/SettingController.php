<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $categories = Category::all();
        $banners = \App\Models\Banner::all();
        return view('admin.settings.index', compact('settings', 'categories', 'banners'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $this->settingService->updateByKey($key, $value);
        }
        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        \App\Models\Banner::create($request->all());
        return back()->with('success', 'Banner berhasil ditambahkan!');
    }

    public function destroyBanner(\App\Models\Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
