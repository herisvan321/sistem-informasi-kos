<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->get();

        $categories = Category::all();

        $featured_listings = Listing::with('user')
            ->where('status', 'Approved')
            ->when($request->location, function($query, $location) {
                $query->where(function($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                      ->orWhere('district', 'like', "%{$location}%")
                      ->orWhere('address', 'like', "%{$location}%");
                });
            })
            ->when($request->category_id, function($query, $category_id) {
                $query->where('category_id', $category_id);
            })
            ->orderBy('is_premium', 'desc')
            ->latest()
            ->take(6)
            ->get();

        $latest_listings = Listing::with('user')
            ->where('status', 'Approved')
            ->when($request->location, function($query, $location) {
                $query->where(function($q) use ($location) {
                    $q->where('city', 'like', "%{$location}%")
                      ->orWhere('district', 'like', "%{$location}%")
                      ->orWhere('address', 'like', "%{$location}%");
                });
            })
            ->when($request->category_id, function($query, $category_id) {
                $query->where('category_id', $category_id);
            })
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('banners', 'categories', 'featured_listings', 'latest_listings'));
    }
}
