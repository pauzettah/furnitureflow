@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

    @php
        $orders = $orders ?? [
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
    @endphp

    {{-- Page Header --}}
    <div class="mb-6 fade-up">
        <h1 class="text-2xl font-semibold text-gray-900">My Orders</h1>
        <p class="text-sm text-gray-500 mt-1">Track and manage all your furniture orders</p>
    </div>

    {{-- Summary Banner --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8 fade-up fade-up-1">
        @php
            $totalOrders = count($orders);
            $activeOrders = count(array_filter($orders, fn($o) => $o['status'] !== 'delivered'));
            $totalSpent = array_sum(array_column($orders, 'total'));
            $totalBalance = array_sum(array_column($orders, 'balance'));
        @endphp
        <div class="card p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Total Orders</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
        </div>
        <div class="card p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Active</p>
            <p class="text-2xl font-semibold text-blue-600">{{ $activeOrders }}</p>
        </div>
        <div class="card p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Total Value</p>
            <p class="text-xl font-semibold text-gray-900">KES {{ number_format($totalSpent) }}</p>
        </div>
        <div class="card p-4 text-center">
            <p class="text-xs text-gray-400 mb-1">Balance Due</p>
            <p class="text-xl font-semibold text-red-500">KES {{ number_format($totalBalance) }}</p>
        </div>
    </div>

    {{-- Orders Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($orders as $order)
            @include('components.order-card', ['order' => $order])
        @empty
            <div class="col-span-full card p-12 text-center">
                <i class="fa-regular fa-box-open text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-400">No orders yet. Your first order will appear here.</p>
            </div>
        @endforelse
    </div>

@endsection