<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreListingRequest;
use App\Http\Requests\Admin\UpdateListingRequest;
use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    protected $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $listings = Listing::with('user')
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
        return view('admin.listings.index', compact('listings'));
    }

    public function show(Listing $listing)
    {
        return view('admin.listings.show', compact('listing'));
    }

    public function edit(Listing $listing)
    {
        return view('admin.listings.edit', compact('listing'));
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->listingService->update($listing->id, $request->validated());
        return redirect()->route('admin.listings.index')->with('success', 'Listing berhasil diperbarui!');
    }

    public function approve(Listing $listing)
    {
        $this->listingService->approve($listing->id);
        return back()->with('success', 'Listing disetujui!');
    }

    public function reject(Request $request, Listing $listing)
    {
        $this->listingService->reject($listing->id, [
            'rejection_reason' => $request->reason,
            'rejection_notes' => $request->notes,
        ]);
        return back()->with('success', 'Listing ditolak!');
    }

    public function togglePremium(Listing $listing)
    {
        $this->listingService->togglePremium($listing->id);
        return back()->with('success', 'Status premium berhasil diperbarui!');
    }

    public function destroy(Listing $listing)
    {
        $this->listingService->delete($listing->id);
        return redirect()->route('admin.listings.index')->with('success', 'Listing berhasil dihapus!');
    }
}
