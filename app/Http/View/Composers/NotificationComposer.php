<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // System Notifications
            $unreadSystemNotifications = $user->unreadNotifications()->count();
            $recentSystemNotifications = $user->notifications()->take(5)->get();
            
            // Inquiries (Messages)
            $unreadInquiriesCount = \App\Models\Inquiry::where('receiver_id', $user->id)
                                                    ->where('status', 'Unread')
                                                    ->count();
            
            // Sum both for the badge
            $totalUnreadCount = $unreadSystemNotifications + $unreadInquiriesCount;
            
            $view->with([
                'unreadNotificationsCount' => $totalUnreadCount,
                'recentNotifications' => $recentSystemNotifications,
                'unreadInquiriesCount' => $unreadInquiriesCount,
                'totalUsersCount' => \App\Models\User::count(),
                'totalListingsCount' => \App\Models\Listing::count(),
            ]);
        }
    }
}
