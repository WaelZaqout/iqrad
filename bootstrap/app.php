<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Application;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',

        health: '/up',
        then: function (Application $app) {
            $app->make(\Illuminate\Routing\Router::class)
                ->middleware('web') // ✅ المهم
                ->prefix('admin')   // ✅ وضع المسارات تحت /admin
                ->group(base_path('routes/admin.php')); // ✅ تحميل ملف المسارات
        }
    )


    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,

        ]);
        
        // إضافة SetLocale middleware إلى web group
        $middleware->web(append: [
            SetLocale::class,
        ]);

    })


    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

