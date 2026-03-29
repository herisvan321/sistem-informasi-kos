<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Http\Requests\PencariKos\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\Listing;
use App\Services\PencariKosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    protected $pencariKosService;

    public function __construct(PencariKosService $pencariKosService)
    {
        $this->pencariKosService = $pencariKosService;
    }

    /**
     * Display a list of inquiry threads for the tenant.
     */
    public function index(Request $request)
    {
        $threads = $this->pencariKosService->getInquiryThreads(Auth::id());
        $activeThread = null;
        $messages = collect();

        if ($request->has('thread')) {
            $listingId = $request->thread;
            $activeThread = Listing::findOrFail($listingId);
            $messages = $this->pencariKosService->getThreadMessages(Auth::id(), $listingId);
            $this->pencariKosService->markThreadAsRead(Auth::id(), $listingId);
        } elseif ($threads->isNotEmpty()) {
            $listingId = $threads->first()->listing_id;
            $activeThread = $threads->first()->listing;
            $messages = $this->pencariKosService->getThreadMessages(Auth::id(), $listingId);
            $this->pencariKosService->markThreadAsRead(Auth::id(), $listingId);
        }

        return view('pencari_kos.inquiries.index', compact('threads', 'activeThread', 'messages'));
    }

    /**
     * Store an initial inquiry for a listing.
     */
    public function store(StoreInquiryRequest $request, Listing $listing)
    {
        $this->pencariKosService->sendInquiry(array_merge($request->validated(), ['listing_id' => $listing->id]), Auth::id());

        return redirect()->route('pencari-kos.inquiries.index', ['thread' => $listing->id])
            ->with('success', 'Pesan Anda telah terdaftar dalam sistem audit komunikasi kami dan diteruskan ke pemilik properti.');
    }

    /**
     * Respond to an existing thread.
     */
    public function respond(Request $request, Listing $listing)
    {
        $request->validate(['message' => 'required|string']);

        $this->pencariKosService->sendInquiry([
            'listing_id' => $listing->id,
            'message' => $request->message,
        ], Auth::id());

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}
