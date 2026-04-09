<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Sample data - replace with database queries
        $pendingDeliveries = [
            [
                'order_id' => 'FF-2401',
                'item' => 'L-Shaped Sofa Set (7-Seater)',
                'scheduled_date' => 'Feb 5, 2025',
                'scheduled_time' => '11:00 AM - 2:00 PM',
                'status' => 'Scheduled',
            ],
        ];

        $completedDeliveries = [
            [
                'order_id' => 'FF-2301',
                'item' => 'Dining Table Set (6 Chairs)',
                'delivered_date' => 'Dec 22, 2024',
                'status' => 'Delivered',
            ],
        ];

        $readyOrders = [
            [
                'id' => 'FF-2389',
                'item' => 'King Size Bed Frame + Headboard',
            ],
        ];

        $pendingDelivery = count($pendingDeliveries);
        $completedDelivery = count($completedDeliveries);
        $deliveryThisWeek = 1;

        return view('customer.delivery', compact(
            'pendingDeliveries',
            'completedDeliveries',
            'readyOrders',
            'pendingDelivery',
            'completedDelivery',
            'deliveryThisWeek'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'delivery_date' => 'required|date|after:today',
            'delivery_time' => 'required|string',
            'address' => 'required|string|max:255',
        ]);

        // This is where you'll save delivery request to database
        return back()->with('success', 'Delivery request submitted! We will confirm shortly.');
    }
}