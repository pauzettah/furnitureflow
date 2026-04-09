<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Sample data for now (you'll replace with database later)
        $orders = [
            [
                'id' => 'FF-2401',
                'item' => 'L-Shaped Sofa Set (7-Seater)',
                'total' => 120000,
                'deposit' => 60000,
                'balance' => 60000,
                'status' => 'production',
                'date' => 'Jan 15, 2025',
            ],
            [
                'id' => 'FF-2389',
                'item' => 'King Size Bed Frame + Headboard',
                'total' => 75000,
                'deposit' => 40000,
                'balance' => 35000,
                'status' => 'ready',
                'date' => 'Jan 8, 2025',
            ],
            [
                'id' => 'FF-2301',
                'item' => 'Dining Table Set (6 Chairs)',
                'total' => 55000,
                'deposit' => 55000,
                'balance' => 0,
                'status' => 'delivered',
                'date' => 'Dec 20, 2024',
            ],
        ];

        $stats = [
            'active_orders' => collect($orders)->whereNotIn('status', ['delivered'])->count(),
            'balance_due' => collect($orders)->sum('balance'),
        ];

        return view('customer.orders', compact('orders', 'stats'));
    }

    public function show($id)
    {
        // Sample data for order detail
        $order = [
            'id' => $id,
            'item' => 'L-Shaped Sofa Set (7-Seater)',
            'description' => 'Premium fabric L-shaped sofa in dark grey. Frame: hardwood. Cushions: high-density foam. Legs: brushed chrome. Dimensions: 320cm × 220cm.',
            'total' => 120000,
            'deposit' => 60000,
            'balance' => 60000,
            'status' => 'production',
            'date' => 'Jan 15, 2025',
            'timeline' => [
                ['step' => 'Order Placed', 'date' => 'Jan 15, 2025, 10:32 AM', 'done' => true],
                ['step' => 'Production Started', 'date' => 'Jan 17, 2025, 9:00 AM', 'done' => true],
                ['step' => 'Ready for Delivery', 'date' => 'Expected Feb 5, 2025', 'done' => false],
                ['step' => 'Delivered', 'date' => 'TBD', 'done' => false],
            ],
        ];

        return view('customer.order-detail', compact('order'));
    }
}