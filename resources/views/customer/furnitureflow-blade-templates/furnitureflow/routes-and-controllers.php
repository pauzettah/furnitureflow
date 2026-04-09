<?php

// ============================================================
// routes/web.php  — Customer Portal Routes
// Add these inside your auth middleware group
// ============================================================

use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\DeliveryController;
use App\Http\Controllers\Customer\ContactController;

Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {

    // Orders
    Route::get('/orders',           [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}',      [OrderController::class, 'show'])->name('order.detail');

    // Payments
    Route::post('/payment',         [PaymentController::class, 'store'])->name('payment');

    // Delivery
    Route::post('/delivery',        [DeliveryController::class, 'store'])->name('delivery');

    // Contact
    Route::post('/contact',         [ContactController::class, 'send'])->name('contact');
});


// ============================================================
// app/Http/Controllers/Customer/OrderController.php
// ============================================================
/*
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
                       ->latest()
                       ->get()
                       ->map(fn($o) => [
                           'id'      => $o->reference,
                           'item'    => $o->furniture_type,
                           'total'   => $o->total_amount,
                           'deposit' => $o->deposit_paid,
                           'balance' => $o->total_amount - $o->deposit_paid,
                           'status'  => $o->status,         // pending|production|ready|delivered
                           'date'    => $o->created_at->format('M j, Y'),
                       ]);

        $stats = [
            'active_orders' => $orders->whereNotIn('status', ['delivered'])->count(),
            'balance_due'   => $orders->sum('balance'),
        ];

        return view('pages.orders', compact('orders', 'stats'));
    }

    public function show($id)
    {
        $raw   = Order::where('customer_id', Auth::id())->where('reference', $id)->firstOrFail();
        $order = [
            'id'          => $raw->reference,
            'item'        => $raw->furniture_type,
            'description' => $raw->description,
            'total'       => $raw->total_amount,
            'deposit'     => $raw->deposit_paid,
            'balance'     => $raw->total_amount - $raw->deposit_paid,
            'status'      => $raw->status,
            'date'        => $raw->created_at->format('M j, Y'),
            'timeline'    => [
                ['step' => 'Order Placed',       'date' => $raw->created_at->format('M j, Y, g:i A'),       'done' => true],
                ['step' => 'Production Started', 'date' => $raw->production_started_at?->format('M j, Y, g:i A') ?? 'Pending', 'done' => !is_null($raw->production_started_at)],
                ['step' => 'Ready for Delivery', 'date' => $raw->ready_at?->format('M j, Y, g:i A') ?? 'Expected soon', 'done' => !is_null($raw->ready_at)],
                ['step' => 'Delivered',          'date' => $raw->delivered_at?->format('M j, Y, g:i A') ?? 'TBD', 'done' => !is_null($raw->delivered_at)],
            ],
        ];

        return view('pages.order-detail', compact('order'));
    }
}
*/


// ============================================================
// app/Http/Controllers/Customer/PaymentController.php
// ============================================================
/*
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\MpesaService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, MpesaService $mpesa)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount'   => 'required|numeric|min:1',
            'phone'    => 'required|string',
        ]);

        // Trigger STK Push via M-Pesa Daraja API
        $result = $mpesa->stkPush(
            phone:    $request->phone,
            amount:   $request->amount,
            orderId:  $request->order_id,
        );

        if ($result['success']) {
            return back()->with('success', 'M-Pesa prompt sent to ' . $request->phone . '. Enter your PIN to complete payment.');
        }

        return back()->with('error', 'Payment initiation failed. Please try again.');
    }
}
*/


// ============================================================
// app/Http/Controllers/Customer/DeliveryController.php
// ============================================================
/*
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DeliveryRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id'      => 'required',
            'delivery_date' => 'required|date|after:today',
            'delivery_time' => 'required|string',
            'address'       => 'required|string|max:255',
        ]);

        $order = Order::where('reference', $request->order_id)
                      ->where('customer_id', Auth::id())
                      ->firstOrFail();

        DeliveryRequest::create([
            'order_id'      => $order->id,
            'customer_id'   => Auth::id(),
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'address'       => $request->address,
        ]);

        return back()->with('success', 'Delivery request submitted! We will confirm shortly.');
    }
}
*/
