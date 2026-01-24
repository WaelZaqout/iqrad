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
        // ✅ تفعيل اللغة حسب الجلسة
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // تحديد العمود المناسب للترتيب حسب اللغة
        $locale = App::getLocale(); // 'en' أو 'ar'
        $categories = Category::orderBy('name_' . $locale, 'asc')->get();

        // مشاركة المتغير مع كل الفيوهات
        View::share('categories', $categories);
    }
}
