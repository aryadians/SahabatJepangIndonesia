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
        } catch (\Throwable $e) {
            // Ignore during setup/migrations
        }
    }
}
