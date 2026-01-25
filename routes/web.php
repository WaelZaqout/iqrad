<?php

use Termwind\Components\Raw;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ProjectController;

// Route::get('/', function () {
//     return view('');
// });
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/project', [FrontController::class, 'project'])->name('project');
Route::get('/favorites', [FrontController::class, 'favorites'])->name('favorites');
Route::post('/favorites/toggle', [FavoriteController::class, 'store'])
    ->name('favorites.toggle')
    ->middleware('auth');
Route::get('/notification', [FrontController::class, 'notification'])->name('notification');

// routes/web.php
Route::post('/notifications/mark-read', [FrontController::class, 'markRead'])
    ->name('notifications.markRead');
Route::get('/support', [SupportChatController::class, 'index'])->name('support.index');
Route::post('/support/sendMessage', [SupportChatController::class, 'sendMessage'])->name('support.sendMessage');

Route::get('/details/{id}', [FrontController::class, 'details'])->name('details');
Route::get('/projects/filter', [FrontController::class, 'filter'])
    ->name('projects.filter');

Route::get('/dashboard', [FrontController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
});
Route::post('/investments/store', [InvestorController::class, 'store']);
Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');
Route::get('/checkout-stripe/{investment}', [StripeController::class, 'checkout']);
Route::get('/stripe-success', [StripeController::class, 'success']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
});
require __DIR__ . '/auth.php';
