<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(15);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.payments.index', compact('payments', 'userInitials', 'userRole', 'currentDate'));
    }

    public function show($id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.payments.show', compact('payment', 'userInitials', 'userRole', 'currentDate'));
    }
}