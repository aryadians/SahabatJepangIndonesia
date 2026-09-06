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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                \Illuminate\Support\Facades\View::composer('*', function ($view) {
                    $view->with('settings', \App\Models\SiteSetting::allCached());
                });
            }

            // Ensure MySQL allows large packets for archive files / images (64MB)
            if (\Illuminate\Support\Facades\DB::connection()->getDriverName() === 'mysql') {
                try {
                    \Illuminate\Support\Facades\DB::statement('SET GLOBAL max_allowed_packet = 67108864');
                } catch (\Throwable $e) {
                    // Ignore if restricted by database host privileges
                }
            }
        } catch (\Throwable $e) {
            // Ignore during setup/migrations
        }
    }
}
