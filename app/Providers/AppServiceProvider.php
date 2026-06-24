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
        // Share a helper closure to all views to access settings dynamically
        view()->share('siteSettings', new class {
            public function get(string $key, $default = null): ?string
            {
                try {
                    return \App\Models\Setting::getValue($key, $default);
                } catch (\Exception $e) {
                    return $default;
                }
            }
        });
    }
}
