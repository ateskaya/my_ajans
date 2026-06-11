<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        // Load Vite CSS asynchronously so it does not block first paint / LCP.
        Vite::useStyleTagAttributes([
            'media' => 'print',
            'onload' => "this.media='all'",
        ]);
    }
}
