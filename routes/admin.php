<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoryController;

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('investors', InvestorController::class);
    Route::resource('reviews',  ReviewController::class);
    Route::resource('favorites', FavoriteController::class);
    // صفحة لوحة التحكم لعرض الرسائل
    Route::get('support', [AdminSupportController::class, 'index'])->name('support.index');
    Route::get('support/show/{id}', [AdminSupportController::class, 'show'])
        ->name('support.show');

    // إرسال رد على رسالة معينة
    Route::post('support/reply', [AdminSupportController::class, 'reply'])->name('support.reply');


    // routes/web.php
    Route::patch('/admin/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('admin.projects.updateStatus');
    Route::patch('/admin/investors/{user}/status', [InvestorController::class, 'updateStatus'])->name('admin.investors.updateStatus');
});
