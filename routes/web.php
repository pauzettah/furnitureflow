<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\DeliveryController;
use App\Http\Controllers\Customer\ContactController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Role-specific dashboards
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware('admin');

    Route::get('/carpenter/dashboard', function () {
        return view('carpenter.dashboard');
    })->name('carpenter.dashboard')->middleware('carpenter');

    Route::get('/delivery/dashboard', function () {
        return view('delivery.dashboard');
    })->name('delivery.dashboard')->middleware('delivery');

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard')->middleware('customer');
});
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.detail');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');  // ← ADD THIS LINE
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment');
    Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
