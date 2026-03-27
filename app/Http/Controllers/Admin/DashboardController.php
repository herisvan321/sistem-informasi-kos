<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Report;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index() {
        // 1. Core Metrics
        $total_users = User::count();
        $total_listings = Listing::count();
        $money = Transaction::where('status', 'Success')->sum('amount');
        $pending_reports = Report::where('status', 'Pending')->count();

        // 2. Trend Calculations
        $last_month_users = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $user_change = $last_month_users > 0 
            ? round((($total_users - $last_month_users) / $last_month_users) * 100) 
            : 0;

        $recent_listings_count = Listing::where('created_at', '>=', now()->subDays(7))->count();
        
        $revenue_target = 100000000; // 100 Million Target
        $revenue_perc = $revenue_target > 0 ? round(($money / $revenue_target) * 100) : 0;

        // 2. Registration Trends (Last 6 Months) - Database Agnostic way
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months->push([
                'month' => $month->format('M'),
                'count' => User::whereMonth('created_at', $month->month)
                               ->whereYear('created_at', $month->year)
                               ->count()
            ]);
        }
        $registration_trends = $months;

        // 3. User Distribution
        $seekers = User::role('pencari-kos')->count();
        $owners = User::role('pemilik-kos')->count();
        $admins = User::role('super-admin')->count();
        $distribution = [
            'seekers' => $seekers,
            'owners' => $owners,
            'admins' => $admins,
            'total' => $total_users ?: 1
        ];

        // 4. Unified Activity Stream
        $recent_users = User::latest()->limit(5)->get()->map(fn($u) => [
            'name' => $u->name,
            'type' => $u->type_user == 'pemilik-kos' ? 'Pemilik' : 'Pencari',
            'action' => 'Baru saja bergabung',
            'time' => $u->created_at->diffForHumans(),
            'status' => $u->status == 'active' ? 'Sukses' : 'Pending',
            'badge' => $u->status == 'active' ? 'green' : 'amber',
            'initials' => strtoupper(substr($u->name, 0, 2))
        ]);

        $recent_listings = Listing::with('user')->latest()->limit(5)->get()->map(fn($l) => [
            'name' => $l->user->name ?? 'System',
            'type' => 'Pemilik',
            'action' => 'Menambahkan listing "' . $l->name . '"',
            'time' => $l->created_at->diffForHumans(),
            'status' => $l->status,
            'badge' => $l->status == 'Approved' ? 'green' : ($l->status == 'Pending' ? 'amber' : 'red'),
            'initials' => strtoupper(substr($l->user->name ?? 'SY', 0, 2))
        ]);

        $recent_reports = Report::latest()->limit(5)->get()->map(fn($r) => [
            'name' => 'Report System',
            'type' => 'Laporan',
            'action' => 'Laporan baru: ' . $r->title,
            'time' => $r->created_at->diffForHumans(),
            'status' => $r->status,
            'badge' => $r->status == 'Resolved' ? 'green' : 'amber',
            'initials' => 'RP'
        ]);

        $activities = collect($recent_users)->concat($recent_listings)->concat($recent_reports)
            ->sortByDesc('time')
            ->take(6);

        return view("admin.dashboard", [
            'total_users' => $total_users,
            'total_listings' => $total_listings,
            'monthly_revenue' => $money,
            'pending_reports' => $pending_reports,
            'user_change' => $user_change,
            'recent_listings_count' => $recent_listings_count,
            'revenue_perc' => $revenue_perc,
            'registration_trends' => $registration_trends,
            'distribution' => $distribution,
            'activities' => $activities
        ]);
    }

    public function analytics()
    {
        $total_transactions = Transaction::count();
        $monthly_revenue = Transaction::where('status', 'Success')->sum('amount');
        
        // Revenue Trends (Last 12 Months)
        $revenue_trends = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue_trends->push([
                'month' => $month->format('M'),
                'amount' => Transaction::where('status', 'Success')
                            ->whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year)
                            ->sum('amount')
            ]);
        }

        $data = [
            'total_users' => User::count(),
            'total_transactions' => $total_transactions,
            'monthly_revenue' => $monthly_revenue,
            'uptime' => '99.9%',
            'revenue_trends' => $revenue_trends,
            'pending_reports' => Report::where('status', 'Pending')->count(),
        ];
        return view('admin.analytics', $data);
    }
}
