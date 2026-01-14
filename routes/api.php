<?php

use App\Http\Controllers\FrontController;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\StripeWebhookController;

Route::post('/investments/store', [InvestorController::class, 'store']);
Route::prefix('')->group(function () {
    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
    Route::post('/chat', [FrontController::class, 'handle']);
});
