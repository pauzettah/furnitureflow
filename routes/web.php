<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\DeliveryController;
use App\Http\Controllers\Customer\ContactController;
use App\Http\Controllers\Carpenter\TaskController;
use App\Http\Controllers\Delivery\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CarpenterController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
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
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/carpenters', [CarpenterController::class, 'index'])->name('carpenters');
    Route::get('/carpenters/{id}', [CarpenterController::class, 'show'])->name('carpenters.show');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
     Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingController::class, 'index'])->name('index');
        Route::get('/profile', [AdminSettingController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminSettingController::class, 'updateProfile'])->name('profile.update');
        Route::get('/security', [AdminSettingController::class, 'security'])->name('security');
        Route::put('/password', [AdminSettingController::class, 'updatePassword'])->name('password.update');
        Route::get('/users', [AdminSettingController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminSettingController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminSettingController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminSettingController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminSettingController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminSettingController::class, 'deleteUser'])->name('users.delete');
        Route::get('/system', [AdminSettingController::class, 'system'])->name('system');
    });

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

Route::middleware(['auth', 'carpenter'])->prefix('carpenter')->name('carpenter.')->group(function () {
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::post('/task/ready', [TaskController::class, 'markReady'])->name('task.ready');
    Route::post('/task/report', [TaskController::class, 'reportIssue'])->name('task.report');
});
Route::middleware(['auth', 'delivery'])->prefix('delivery')->name('delivery.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
