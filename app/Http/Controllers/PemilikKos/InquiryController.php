<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Services\InquiryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    protected $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }

    public function index()
    {
        $groups = $this->inquiryService->getAllGroupedForOwner(Auth::user());
        return view('pemilik_kos.inquiries.index', compact('groups'));
    }

    public function show(Request $request, Inquiry $inquiry)
    {
        $this->authorizeParticipant($inquiry);
        // ...
        $client = $inquiry->sender_id === Auth::id() ? $inquiry->receiver : $inquiry->sender;
        $listing = $inquiry->listing;

        $this->inquiryService->markThreadAsRead(Auth::user(), $client, $listing->id);
        $messages = $this->inquiryService->getChatThread(Auth::user(), $client, $listing->id);

        return view('pemilik_kos.inquiries.show', compact('messages', 'client', 'listing'));
    }

    public function respond(Request $request, Inquiry $inquiry)
    {
        $this->authorizeParticipant($inquiry);
        $request->validate(['message' => 'required|string']);
        
        $client = $inquiry->sender_id === Auth::id() ? $inquiry->receiver : $inquiry->sender;
        
        $this->inquiryService->respond(Auth::user(), $client, $inquiry->listing_id, $request->message);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    protected function authorizeParticipant(Inquiry $inquiry)
    {
        if ($inquiry->receiver_id !== Auth::id() && $inquiry->sender_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
