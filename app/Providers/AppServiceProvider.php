<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Listing::observe(\App\Observers\ListingObserver::class);
        \App\Models\Setting::observe(\App\Observers\SettingObserver::class);
        \App\Models\Banner::observe(\App\Observers\BannerObserver::class);

        \Illuminate\Support\Facades\View::composer(
            ['layouts.admin', 'admin.notifications.index'], 
            \App\Http\View\Composers\NotificationComposer::class
        );
    }
}
