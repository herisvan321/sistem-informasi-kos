<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow review if booking is active/completed
        if (!in_array($transaction->status, ['Paid', 'Active', 'Completed'])) {
            return back()->with('error', 'Review hanya dapat diberikan untuk booking yang sudah dibayar.');
        }

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'listing_id' => $transaction->listing_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Ulasan berhasil disimpan. Terima kasih bos!');
    }
}
