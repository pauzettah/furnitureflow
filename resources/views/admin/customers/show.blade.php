@extends('admin.dashboard')

@section('title', 'Customer Details')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Customer Details</div>
            <div class="section-sub">{{ $customer->name }}</div>
        </div>
        <a href="{{ route('admin.customers') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Customers</a>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Personal Information</div>
            </div>
            <div style="padding: 20px 24px;">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Phone:</strong> {{ $customer->phone ?? 'Not provided' }}</p>
                <p><strong>Address:</strong> {{ $customer->address ?? 'Not provided' }}</p>
                <p><strong>Registered:</strong> {{ $customer->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Statistics</div>
            </div>
            <div style="padding: 20px 24px;">
                <p><strong>Total Orders:</strong> {{ $customer->orders->count() }}</p>
                <p><strong>Total Spent:</strong> KES {{ number_format($customer->orders->sum('total_amount')) }}</p>
                <p><strong>Pending Balance:</strong> KES {{ number_format($customer->orders->sum('balance_amount')) }}</p>
            </div>
        </div>
    </div>

    <div class="data-table-wrap" style="margin-top: 20px;">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">Order History</div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr><th>Order ID</th><th>Date</th><th>Status</th><th>Amount</th><th>Balance</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($customer->orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ $order->status }}</span></td>
                        <td>KES {{ number_format($order->total_amount) }}</td>
                        <td>KES {{ number_format($order->balance_amount) }}</td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6">No orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection