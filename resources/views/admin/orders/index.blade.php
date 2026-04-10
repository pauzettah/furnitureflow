@extends('admin.dashboard')

@section('title', 'Orders Management')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Orders Management</div>
            <div class="section-sub">View and manage all customer orders</div>
        </div>
        <a href="#" class="section-action"><i class="fa-solid fa-plus"></i> New Order</a>
    </div>

    <div class="data-table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><span class="order-id">{{ $order->order_number }}</span></td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td>KES {{ number_format($order->total_amount) }}</td>
                        <td class="{{ $order->balance_amount > 0 ? 'balance-positive' : 'balance-zero' }}">
                            KES {{ number_format($order->balance_amount) }}
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">View</a>
                                <button class="btn-edit">Edit</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection