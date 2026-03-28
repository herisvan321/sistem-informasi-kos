<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
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
            ->orderBy('is_premium', 'desc')
            ->latest()
            ->take(6)
            ->get();

        $latest_listings = Listing::with('user')
            ->where('status', 'Approved')
            ->latest()
            ->take(8)
            ->get();

        return view('welcome', compact('banners', 'categories', 'featured_listings', 'latest_listings'));
    }
}
