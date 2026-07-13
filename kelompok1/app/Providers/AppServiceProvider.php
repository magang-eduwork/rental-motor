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
            $heroImage = \App\Models\Setting::where('key', 'hero_image_url')->value('value') 
                ?? 'https://i.ibb.co.com/Lh9d84PX/a44f9055b40db9210198bda81452bbb436eb019d.jpg';
            \Illuminate\Support\Facades\View::share('heroImage', $heroImage);

            $favicon = \App\Models\Setting::where('key', 'favicon_url')->value('value') 
                ?? 'https://i.ibb.co.com/qF5ByfcT/favicon-rental.png';
            \Illuminate\Support\Facades\View::share('favicon', $favicon);
        } catch (\Exception $e) {
            // Ignore during migrations or when table doesn't exist
            \Illuminate\Support\Facades\View::share('heroImage', '');
            \Illuminate\Support\Facades\View::share('favicon', '');
        }
    }
}
