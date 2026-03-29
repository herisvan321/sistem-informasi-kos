<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Services\PencariKosService;
use Illuminate\Http\Request;
use App\Models\Category;

class DiscoveryController extends Controller
{
    protected $pencariService;

    public function __construct(PencariKosService $pencariService)
    {
        $this->pencariService = $pencariService;
    }

    /**
     * Display a listing of approved kos.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category_id', 'min_price', 'max_price']);
        $listings = $this->pencariService->searchListings($filters);
        $categories = Category::all();

        return view('pencari_kos.discovery.index', compact('listings', 'categories'));
    }

    /**
     * Display the specified listing.
     */
    public function show(Listing $listing)
    {
        if ($listing->status !== 'Approved') {
            abort(404);
        }

        $listing->load([
            'user',
            'rooms' => function ($query) {
                $query->where('status', 'Available');
            }
        ]);

        return view('pencari_kos.discovery.show', compact('listing'));
    }
}
