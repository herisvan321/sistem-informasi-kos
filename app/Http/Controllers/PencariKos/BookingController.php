<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Room;
use App\Services\PencariKosService;
use App\Http\Requests\PencariKos\BookingStoreRequest;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $pencariService;

    public function __construct(PencariKosService $pencariService)
    {
        $this->pencariService = $pencariService;
    }

    /**
     * Show form to book a room.
     */
    public function create(Listing $listing)
    {
        if ($listing->status !== 'Approved') {
            abort(404);
        }

        $availableRooms = $listing->rooms()->where('status', 'Available')->get();

        return view('pencari_kos.booking.create', compact('listing', 'availableRooms'));
    }

    /**
     * Store the booking details and redirect to payment.
     */
    public function store(BookingStoreRequest $request, Listing $listing)
    {
        $data = $request->validated();
        $data['listing_id'] = $listing->id;

        $transaction = $this->pencariService->createBooking($data, Auth::id());

        return redirect()->route('pencari-kos.payments.show', $transaction->id)
            ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }
}
