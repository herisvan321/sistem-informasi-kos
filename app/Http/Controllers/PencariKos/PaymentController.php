<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PencariKosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $pencariService;

    public function __construct(PencariKosService $pencariService)
    {
        $this->pencariService = $pencariService;
    }

    /**
     * Show payment page.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pencari_kos.payment.upload', compact('transaction'));
    }

    /**
     * Upload payment proof.
     */
    public function upload(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $this->pencariService->uploadPaymentProof($transaction->id, $request->file('payment_proof'));

        return redirect()->route('pencari-kos.history.index')
            ->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu konfirmasi.');
    }
}
