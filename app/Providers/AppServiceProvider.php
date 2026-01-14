<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
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
        $categories = Category::orderBy('name')->get();
        View::share('categories', $categories);
        // ✅ تفعيل اللغة حسب الجلسة
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    }
}
