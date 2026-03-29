<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Services\PencariKosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected $pencariService;

    public function __construct(PencariKosService $pencariService)
    {
        $this->pencariService = $pencariService;
    }

    /**
     * Display the wishlist.
     */
    public function index()
    {
        $favorites = $this->pencariService->getFavorites(Auth::id());
        return view('pencari_kos.favorites.index', compact('favorites'));
    }

    /**
     * Toggle a listing in favorites.
     */
    public function toggle(Listing $listing)
    {
        $result = $this->pencariService->toggleFavorite($listing->id, Auth::id());

        return back()->with('success', $result['message']);
    }
}
