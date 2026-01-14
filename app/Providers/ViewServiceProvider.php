<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('notifications', auth()->user()->notifications()->latest()->take(5)->get());
                $view->with('unreadNotifications', auth()->user()->unreadNotifications);
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
