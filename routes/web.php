<?php

use Illuminate\Support\Facades\Route;
use Stonedleaf\PaymayaLaravel\Http\Controllers\WebhookController;

Route::prefix('webhook')->name('webhook.')->group(function() {
    Route::prefix('checkout')->name('checkout.')->group(function() {
        Route::post('success', [WebhookController::class, 'handleCheckoutSuccess'])->name('success');
        Route::post('failure', [WebhookController::class, 'handleCheckoutFailure'])->name('failure');
        Route::post('expiry', [WebhookController::class, 'handleCheckoutExpiry'])->name('expiry');
    });
});
