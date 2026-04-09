@extends('layouts.app')

@section('title', 'Delivery Requests')

@section('content')
<div class="fade-up">
    <h1 class="text-2xl font-semibold text-gray-900">Delivery Management</h1>
    <p class="text-sm text-gray-500 mt-1">Track and manage your furniture deliveries</p>
</div>

{{-- Delivery Summary --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 fade-up fade-up-1">
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fa-solid fa-truck-fast text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Pending Delivery</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingDelivery ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Completed</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedDelivery ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                <i class="fa-solid fa-calendar-week text-yellow-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Est. This Week</p>
                <p class="text-2xl font-bold text-gray-900">{{ $deliveryThisWeek ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Pending Deliveries --}}
@if(!empty($pendingDeliveries) && count($pendingDeliveries) > 0)
<div class="card p-6 mb-8 fade-up fade-up-2">
    <h2 class="font-semibold text-lg text-gray-900 mb-4">Pending Deliveries</h2>
    <div class="space-y-4">
        @foreach($pendingDeliveries as $delivery)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
            <div>
                <p class="font-medium text-gray-800">Order #{{ $delivery['order_id'] }}</p>
                <p class="text-sm text-gray-500">{{ $delivery['item'] }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    <i class="fa-regular fa-calendar"></i> {{ $delivery['scheduled_date'] }} &nbsp;|&nbsp;
                    <i class="fa-regular fa-clock"></i> {{ $delivery['scheduled_time'] }}
                </p>
            </div>
            <div class="text-right">
                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">
                    {{ $delivery['status'] }}
                </span>
                <div class="mt-2">
                    <a href="{{ route('customer.order.detail', $delivery['order_id']) }}" class="text-xs text-blue-600 hover:text-blue-800">
                        Track Order →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Completed Deliveries --}}
@if(!empty($completedDeliveries) && count($completedDeliveries) > 0)
<div class="card p-6 mb-8 fade-up fade-up-3">
    <h2 class="font-semibold text-lg text-gray-900 mb-4">Delivery History</h2>
    <div class="space-y-4">
        @foreach($completedDeliveries as $delivery)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
            <div>
                <p class="font-medium text-gray-800">Order #{{ $delivery['order_id'] }}</p>
                <p class="text-sm text-gray-500">{{ $delivery['item'] }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    <i class="fa-regular fa-calendar-check"></i> Delivered on {{ $delivery['delivered_date'] }}
                </p>
            </div>
            <div class="text-right">
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                    {{ $delivery['status'] }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Request Delivery Section --}}
<div class="card p-6 fade-up fade-up-4">
    <h2 class="font-semibold text-lg text-gray-900 mb-4">Request New Delivery</h2>
    <p class="text-sm text-gray-500 mb-4">Schedule delivery for orders that are ready.</p>
    
    @if(!empty($readyOrders) && count($readyOrders) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($readyOrders as $order)
            <div class="border border-gray-100 rounded-xl p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-medium text-gray-800">Order #{{ $order['id'] }}</p>
                        <p class="text-sm text-gray-500">{{ $order['item'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">Ready</span>
                </div>
                <a href="{{ route('customer.order.detail', $order['id']) }}#delivery" 
                   class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                    Schedule Delivery
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fa-solid fa-truck text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-400">No orders ready for delivery yet.</p>
            <p class="text-xs text-gray-400 mt-1">Orders will appear here when they are marked as "Ready"</p>
        </div>
    @endif
</div>
@endsection