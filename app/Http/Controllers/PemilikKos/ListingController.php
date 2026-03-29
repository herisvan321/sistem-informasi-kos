<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Http\Requests\PemilikKos\ListingRequest;
use App\Services\ListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    protected $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    public function index()
    {
        $listings = $this->listingService->getAllForOwner(Auth::id());
        return view('pemilik_kos.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('pemilik_kos.listings.create');
    }

    public function store(ListingRequest $request)
    {
        $data = $request->validated();
        $data['owner_id'] = Auth::id();
        $data['status'] = 'Pending'; // New listings start as pending

        $this->listingService->create($data);

        return redirect()->route('pemilik-kos.listings.index')->with('success', 'Listing berhasil ditambahkan dan sedang menunggu verifikasi.');
    }

    public function edit(Listing $listing)
    {
        $this->authorizeOwner($listing);
        return view('pemilik_kos.listings.edit', compact('listing'));
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $this->authorizeOwner($listing);
        $data = $request->validated();
        
        $this->listingService->update($listing, $data);

        return redirect()->route('pemilik-kos.listings.index')->with('success', 'Listing berhasil diperbarui.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorizeOwner($listing);
        $this->listingService->delete($listing);

        return redirect()->route('pemilik-kos.listings.index')->with('success', 'Listing berhasil dihapus.');
    }

    public function requestPremium(Listing $listing)
    {
        $this->authorizeOwner($listing);
        return redirect()->route('pemilik-kos.listings.premium-payment', $listing->id);
    }

    public function premiumPayment(Listing $listing)
    {
        $this->authorizeOwner($listing);
        $price = get_setting('premium_price', 150000);
        return view('pemilik_kos.listings.premium_payment', compact('listing', 'price'));
    }

    public function submitPremium(Request $request, Listing $listing)
    {
        $this->authorizeOwner($listing);
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $this->listingService->submitPremiumProof($listing, $request->file('payment_proof'));

        return redirect()->route('pemilik-kos.listings.index')->with('success', 'Bukti pembayaran telah dikirim. Admin akan segera memverifikasi permintaan Anda.');
    }

    public function deleteGalleryImage(\App\Models\ListingImage $image)
    {
        $listing = $image->listing;
        $this->authorizeOwner($listing);

        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->photo_path);
        $image->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function reorderImages(Request $request)
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*' => 'required|string|exists:listing_images,id',
            ]);

            // Optional security: ensure images belong to the user
            $imageIds = $request->order;
            $count = \App\Models\ListingImage::whereIn('id', $imageIds)
                ->whereHas('listing', function($q) {
                    $q->where('owner_id', Auth::id());
                })->count();

            if ($count !== count($imageIds)) {
                return response()->json(['success' => false, 'message' => 'Unauthorized or invalid image IDs.'], 403);
            }

            foreach ($request->order as $index => $id) {
                \App\Models\ListingImage::where('id', $id)->update(['sort_order' => $index]);
            }

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    protected function authorizeOwner(Listing $listing)
    {
        if ($listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
