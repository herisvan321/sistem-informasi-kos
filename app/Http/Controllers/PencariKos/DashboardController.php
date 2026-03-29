<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a dashboard summary for the tenant.
     */
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'active_bookings' => Transaction::where('user_id', $user->id)
                                            ->whereIn('status', ['Paid', 'Active'])
                                            ->count(),
            'favorites_count' => Favorite::where('user_id', $user->id)->count(),
            'pending_payments' => Transaction::where('user_id', $user->id)
                                             ->where('status', 'Pending')
                                             ->count(),
        ];

        $recent_bookings = Transaction::with('listing')
                                      ->where('user_id', $user->id)
                                      ->latest()
                                      ->take(5)
                                      ->get();

        return view('pencari_kos.dashboard.index', compact('stats', 'recent_bookings'));
    }
}
