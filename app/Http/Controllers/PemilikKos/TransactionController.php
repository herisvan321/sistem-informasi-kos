<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();
        $transactions = Transaction::whereHas('listing', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->with(['user', 'listing'])->latest()->get();

        return view('pemilik_kos.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pemilik_kos.transactions.show', compact('transaction'));
    }
}
