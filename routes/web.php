<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CustomDomainController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/business/{slug}', [BusinessController::class, 'show'])->name('business.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('business', BusinessController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subscription routes
    Route::prefix('business/{business}/subscription')->name('subscription.')->group(function () {
        Route::get('/plans', [SubscriptionController::class, 'plans'])->name('plans');
        Route::get('/manage', [SubscriptionController::class, 'manage'])->name('manage');
        Route::get('/upgrade/{plan}', [SubscriptionController::class, 'showUpgrade'])->name('showUpgrade');
        Route::post('/upgrade/{plan}', [SubscriptionController::class, 'upgrade'])->name('upgrade');
        Route::post('/downgrade/{plan}', [SubscriptionController::class, 'downgrade'])->name('downgrade');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/auto-renew/enable', [SubscriptionController::class, 'enableAutoRenew'])->name('autoRenew.enable');
        Route::post('/auto-renew/disable', [SubscriptionController::class, 'disableAutoRenew'])->name('autoRenew.disable');
    });

    // Payment routes
    Route::prefix('business/{business}/payment')->name('payment.')->group(function () {
        Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('checkout');
        Route::post('/process/{plan}', [PaymentController::class, 'process'])->name('process');
        Route::get('/success', [PaymentController::class, 'success'])->name('success');
        Route::get('/pending', [PaymentController::class, 'pending'])->name('pending');
    });

    // Photo management routes
    Route::prefix('business/{business}/photos')->name('business.photos.')->group(function () {
        Route::get('/', [PhotoController::class, 'index'])->name('index');
        Route::post('/upload', [PhotoController::class, 'upload'])->name('upload');
        Route::delete('/delete', [PhotoController::class, 'destroy'])->name('destroy');
        Route::post('/set-logo', [PhotoController::class, 'setAsLogo'])->name('setLogo');
    });

    // Analytics routes (premium feature)
    Route::get('/business/{business}/analytics', [AnalyticsController::class, 'index'])->name('business.analytics');

    // Custom domain routes (premium feature)
    Route::prefix('business/{business}/custom-domain')->name('custom-domain.')->group(function () {
        Route::get('/', [CustomDomainController::class, 'index'])->name('index');
        Route::post('/store', [CustomDomainController::class, 'store'])->name('store');
        Route::get('/{customDomain}', [CustomDomainController::class, 'show'])->name('show');
        Route::post('/{customDomain}/verify', [CustomDomainController::class, 'verifyDomain'])->name('verify');
        Route::delete('/{customDomain}', [CustomDomainController::class, 'destroy'])->name('destroy');
    });
});

// Payment webhook (must be outside auth middleware)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

require __DIR__.'/auth.php';
