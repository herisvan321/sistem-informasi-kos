<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PencariKosService;
use Illuminate\Support\Facades\Auth;

class MyBookingController extends Controller
{
    protected $pencariService;

    public function __construct(PencariKosService $pencariService)
    {
        $this->pencariService = $pencariService;
    }

    /**
     * Display a list of bookings history.
     */
    public function index()
    {
        $bookings = $this->pencariService->getHistory(Auth::id());
        return view('pencari_kos.history.index', compact('bookings'));
    }

    /**
     * Display the details of a booking.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load(['listing', 'room']);
        
        return view('pencari_kos.history.show', compact('transaction'));
    }
}
