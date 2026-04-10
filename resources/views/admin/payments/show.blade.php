@extends('admin.dashboard')

@section('title', 'Payment Details')

@section('content')
<div class="fade-up">
    <div class="section-header"><div><div class="section-title">Payment Details</div><div class="section-sub">{{ $payment->payment_number }}</div></div><a href="{{ route('admin.payments') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back</a></div>

    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap"><div class="data-table-header" style="padding: 20px 24px 0;"><div class="section-title" style="font-size: 1rem;">Payment Information</div></div><div style="padding: 20px 24px;"><p><strong>Payment Number:</strong> {{ $payment->payment_number }}</p><p><strong>Order:</strong> <a href="{{ route('admin.orders.show', $payment->order_id) }}">{{ $payment->order->order_number ?? 'N/A' }}</a></p><p><strong>Amount:</strong> KES {{ number_format($payment->amount) }}</p><p><strong>Type:</strong> {{ ucfirst($payment->type) }}</p><p><strong>Method:</strong> {{ ucfirst($payment->method) }}</p><p><strong>Status:</strong> <span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></p><p><strong>Date:</strong> {{ $payment->created_at->format('d M Y, h:i A') }}</p></div></div>

        <div class="data-table-wrap"><div class="data-table-header" style="padding: 20px 24px 0;"><div class="section-title" style="font-size: 1rem;">Transaction Details</div></div><div style="padding: 20px 24px;"><p><strong>M-Pesa Code:</strong> {{ $payment->mpesa_code ?? 'N/A' }}</p><p><strong>Phone:</strong> {{ $payment->phone ?? 'N/A' }}</p><p><strong>Notes:</strong></p><p>{{ $payment->notes ?? 'No notes' }}</p></div></div>
    </div>
</div>
@endsection