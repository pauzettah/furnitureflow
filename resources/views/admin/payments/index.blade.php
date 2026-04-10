@extends('admin.dashboard')

@section('title', 'Payments Management')

@section('content')
<div class="fade-up">
    <div class="section-header"><div><div class="section-title">Payments Management</div><div class="section-sub">View and manage all payment transactions</div></div></div>

    <div class="data-table-wrap"><div class="overflow-x-auto"><table class="data-table"><thead><tr><th>Payment #</th><th>Order ID</th><th>Amount</th><th>Type</th><th>Method</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead><tbody>@forelse($payments as $payment)<tr><td>{{ $payment->payment_number }}</td><td>{{ $payment->order->order_number ?? 'N/A' }}</td><td>KES {{ number_format($payment->amount) }}</td><td>{{ ucfirst($payment->type) }}</td><td>{{ ucfirst($payment->method) }}</td><td><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></td><td>{{ $payment->created_at->format('d M Y') }}</td><td><div class="action-btns"><a href="{{ route('admin.payments.show', $payment->id) }}" class="btn-view">View</a></div></td></tr>@empty<tr><td colspan="8">No payments found</td></tr>@endforelse</tbody></table></div><div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">{{ $payments->links() }}</div></div>
</div>
@endsection