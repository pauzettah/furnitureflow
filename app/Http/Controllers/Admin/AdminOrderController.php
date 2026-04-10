<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(15);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.orders.index', compact('orders', 'userInitials', 'userRole', 'currentDate'));
    }

    public function show($id)
    {
        $order = Order::with('customer', 'payments', 'tasks')->findOrFail($id);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.orders.show', compact('order', 'userInitials', 'userRole', 'currentDate'));
    }
}