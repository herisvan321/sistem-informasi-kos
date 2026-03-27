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
            $view->with([
                'unreadNotificationsCount' => $user->unreadNotifications()->count(),
                'recentNotifications' => $user->notifications()->take(5)->get(),
                'totalUsersCount' => \App\Models\User::count(),
                'totalListingsCount' => \App\Models\Listing::count(),
            ]);
        }
    }
}
