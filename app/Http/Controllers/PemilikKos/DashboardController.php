<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();
        
        $totalListings = Listing::where('owner_id', $ownerId)->count();
        $totalRooms = Room::whereHas('listing', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->count();
        
        $activeTenants = Transaction::whereHas('listing', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->where('status', 'Success')->distinct('user_id')->count();
        
        $totalRevenue = Transaction::whereHas('listing', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->where('status', 'Success')->sum('amount');
        
        $occupancyRate = $totalRooms > 0 ? round(($activeTenants / $totalRooms) * 100, 1) : 0;
        
        $recentListings = Listing::where('owner_id', $ownerId)->latest()->take(5)->get();
        $recentInquiries = Inquiry::where('receiver_id', $ownerId)->with(['sender', 'listing'])->latest()->take(5)->get();

        // Premium Stats for UI Sync
        $listing_change = 100; // Default if new
        $revenue_perc = 0;
        if($totalListings > 0) {
            $prevMonthListings = Listing::where('owner_id', $ownerId)
                ->where('created_at', '<', now()->startOfMonth())
                ->count();
            if($prevMonthListings > 0) {
                $listing_change = round((($totalListings - $prevMonthListings) / $prevMonthListings) * 100);
            }
        }

        // Mock data for charts to match Admin UI structure
        $registration_trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Listing::where('owner_id', $ownerId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $registration_trends[] = [
                'month' => $month->format('M'),
                'count' => $count
            ];
        }

        $distribution = [
            'total' => $totalRooms,
            'occupied' => $activeTenants,
            'available' => $totalRooms - $activeTenants,
        ];

        return view('pemilik_kos.dashboard', compact(
            'totalListings', 
            'activeTenants', 
            'totalRevenue', 
            'occupancyRate', 
            'recentListings',
            'recentInquiries',
            'listing_change',
            'registration_trends',
            'distribution'
        ));
    }
}
