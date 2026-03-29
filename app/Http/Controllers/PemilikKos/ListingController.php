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

    protected function authorizeOwner(Listing $listing)
    {
        if ($listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
