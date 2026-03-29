<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();
        
        // Use Transactions to show active tenants as requested by the user
        $tenants = Transaction::whereHas('listing', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->where('status', 'Success')
            ->with(['user', 'listing', 'room'])
            ->latest()
            ->paginate(10);

        return view('pemilik_kos.tenants.index', compact('tenants'));
    }
}
