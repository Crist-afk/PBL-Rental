<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

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
        // Pseudo-cron: Automatically trigger cancel command after response is sent to user
        app()->terminating(function () {
            // Use cache to ensure it only runs at most once every 5 minutes
            if (Cache::add('schedule_cancel_unpaid_lock', true, now()->addMinutes(5))) {
                Artisan::call('app:cancel-unpaid-bookings');
            }
        });
    }
}
