<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(15);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.customers.index', compact('customers', 'userInitials', 'userRole', 'currentDate'));
    }

    public function show($id)
    {
        $customer = User::with('orders')->findOrFail($id);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.customers.show', compact('customer', 'userInitials', 'userRole', 'currentDate'));
    }
}