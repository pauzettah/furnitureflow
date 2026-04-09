<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Sample data - replace with database queries later
        $pendingOrders = [
            [
                'id' => 'FF-2401',
                'item' => 'L-Shaped Sofa Set (7-Seater)',
                'balance' => 60000,
            ],
            [
                'id' => 'FF-2389',
                'item' => 'King Size Bed Frame + Headboard',
                'balance' => 35000,
            ],
        ];

        $paymentHistory = [
            [
                'date' => 'Jan 15, 2025',
                'order_id' => 'FF-2401',
                'amount' => 60000,
                'method' => 'M-Pesa',
                'status' => 'Completed',
            ],
            [
                'date' => 'Jan 8, 2025',
                'order_id' => 'FF-2389',
                'amount' => 40000,
                'method' => 'M-Pesa',
                'status' => 'Completed',
            ],
            [
                'date' => 'Dec 20, 2024',
                'order_id' => 'FF-2301',
                'amount' => 55000,
                'method' => 'Bank Transfer',
                'status' => 'Completed',
            ],
        ];

        $pendingBalance = collect($pendingOrders)->sum('balance');
        $totalPaid = collect($paymentHistory)->sum('amount');
        $totalOrdersValue = $pendingBalance + $totalPaid;

        return view('customer.payments', compact('pendingOrders', 'paymentHistory', 'pendingBalance', 'totalPaid', 'totalOrdersValue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'phone' => 'required|string',
        ]);

        // This is where you'll integrate M-Pesa API
        return back()->with('success', 'M-Pesa prompt sent to ' . $request->phone . '. Enter your PIN to complete payment.');
    }
}