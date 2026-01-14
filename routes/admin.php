<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('investors', InvestorController::class);
    Route::resource('reviews', controller: ReviewController::class);
    Route::resource('favorites', FavoriteController::class);

    // routes/web.php
    Route::patch('/admin/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('admin.projects.updateStatus');
    Route::patch('/admin/investors/{user}/status', [InvestorController::class, 'updateStatus'])->name('admin.investors.updateStatus');
});
