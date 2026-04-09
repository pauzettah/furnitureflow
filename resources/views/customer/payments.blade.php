@extends('layouts.app')

@section('title', 'My Payments')

@section('content')
<div class="fade-up">
    <h1 class="text-2xl font-semibold text-gray-900">Payments</h1>
    <p class="text-sm text-gray-500 mt-1">Track your payment history and manage pending balances</p>
</div>

{{-- Pending Payments Summary --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 fade-up fade-up-1">
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                <i class="fa-solid fa-clock text-yellow-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Pending Balance</p>
                <p class="text-2xl font-bold text-gray-900">KES {{ number_format($pendingBalance ?? 0) }}</p>
            </div>
        </div>
    </div>
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Paid</p>
                <p class="text-2xl font-bold text-gray-900">KES {{ number_format($totalPaid ?? 0) }}</p>
            </div>
        </div>
    </div>
    <div class="card p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fa-solid fa-receipt text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Orders Value</p>
                <p class="text-2xl font-bold text-gray-900">KES {{ number_format($totalOrdersValue ?? 0) }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Pending Payments List --}}
@if(!empty($pendingOrders) && count($pendingOrders) > 0)
<div class="card p-6 mb-8 fade-up fade-up-2">
    <h2 class="font-semibold text-lg text-gray-900 mb-4">Pending Payments</h2>
    <div class="space-y-4">
        @foreach($pendingOrders as $order)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
            <div>
                <p class="font-medium text-gray-800">Order #{{ $order['id'] }}</p>
                <p class="text-sm text-gray-500">{{ $order['item'] }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-red-500">KES {{ number_format($order['balance']) }}</p>
                <a href="{{ route('customer.order.detail', $order['id']) }}" class="text-xs text-blue-600 hover:text-blue-800">
                    Pay Now →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Payment History --}}
<div class="card p-6 fade-up fade-up-3">
    <h2 class="font-semibold text-lg text-gray-900 mb-4">Payment History</h2>
    
    @if(!empty($paymentHistory) && count($paymentHistory) > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-3 text-xs font-medium text-gray-400">Date</th>
                    <th class="text-left py-3 text-xs font-medium text-gray-400">Order #</th>
                    <th class="text-left py-3 text-xs font-medium text-gray-400">Amount</th>
                    <th class="text-left py-3 text-xs font-medium text-gray-400">Method</th>
                    <th class="text-left py-3 text-xs font-medium text-gray-400">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentHistory as $payment)
                <tr class="border-b border-gray-50">
                    <td class="py-3 text-sm text-gray-600">{{ $payment['date'] }}</td>
                    <td class="py-3 text-sm text-gray-600">#{{ $payment['order_id'] }}</td>
                    <td class="py-3 text-sm font-medium text-gray-800">KES {{ number_format($payment['amount']) }}</td>
                    <td class="py-3 text-sm text-gray-600">{{ $payment['method'] }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                            {{ $payment['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-8">
        <i class="fa-regular fa-credit-card text-4xl text-gray-300 mb-3"></i>
        <p class="text-gray-400">No payment history yet.</p>
    </div>
    @endif
</div>
@endsection