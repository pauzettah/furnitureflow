<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $agent = [
            'name' => auth()->user()->name ?? 'Marcus Oduya',
            'initials' => strtoupper(substr(auth()->user()->name ?? 'MO', 0, 2)),
            'badge' => 'AGT-' . str_pad(auth()->id() ?? 1, 3, '0', STR_PAD_LEFT),
            'vehicle' => 'KDA 712G',
        ];

        // Sample delivery data - replace with database
        $deliveries = [
            // ... your delivery data
        ];

        return view('delivery.dashboard', compact('deliveries', 'agent'));
    }
}