<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
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
        // Share data with all Inertia responses
        Inertia::share([
            // Always share the authenticated user
            'auth.user' => function () {
                /** @var User $user */
                $user = Auth::user();
                return $user ? $user->only('id', 'name', 'email', 'roles') : null;
            },
            // You can also share flash messages or errors
            'flash' => function () {
                return [
                    'success' => session('success'),
                    'error' => session('error'),
                ];
            },
        ]);        
    }
}
