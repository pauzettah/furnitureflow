@extends('admin.dashboard')

@section('title', 'Order Details')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Order Details</div>
            <div class="section-sub">Order #{{ $order->order_number }}</div>
        </div>
        <a href="{{ route('admin.orders') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Orders</a>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        {{-- Left Column --}}
        <div>
            <div class="data-table-wrap" style="margin-bottom: 20px;">
                <div class="data-table-header" style="padding: 20px 24px 0;">
                    <div class="section-title" style="font-size: 1rem;">Customer Information</div>
                </div>
                <div style="padding: 20px 24px;">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $order->customer_address ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="data-table-wrap" style="margin-bottom: 20px;">
                <div class="data-table-header" style="padding: 20px 24px 0;">
                    <div class="section-title" style="font-size: 1rem;">Order Items</div>
                </div>
                <div style="padding: 20px 24px;">
                    <p><strong>Description:</strong></p>
                    <p style="margin-top: 8px;">{{ $order->description ?? 'No description' }}</p>
                    @if($order->special_instructions)
                    <p style="margin-top: 12px;"><strong>Special Instructions:</strong></p>
                    <p style="margin-top: 4px; color: #b45309;">{{ $order->special_instructions }}</p>
                    @endif
                </div>
            </div>

            <div class="data-table-wrap">
                <div class="data-table-header" style="padding: 20px 24px 0;">
                    <div class="section-title" style="font-size: 1rem;">Payment History</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($order->payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                <td>KES {{ number_format($payment->amount) }}</td>
                                <td>{{ ucfirst($payment->method) }}</td>
                                <td><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4">No payments recorded</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div>
            <div class="data-table-wrap" style="margin-bottom: 20px;">
                <div class="data-table-header" style="padding: 20px 24px 0;">
                    <div class="section-title" style="font-size: 1rem;">Order Summary</div>
                </div>
                <div style="padding: 20px 24px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Total Amount:</span>
                        <strong>KES {{ number_format($order->total_amount) }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Deposit Paid:</span>
                        <strong class="balance-positive">KES {{ number_format($order->deposit_amount) }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px solid #e2e8f0;">
                        <span>Balance Due:</span>
                        <strong class="balance-positive">KES {{ number_format($order->balance_amount) }}</strong>
                    </div>
                </div>
            </div>

            <div class="data-table-wrap">
                <div class="data-table-header" style="padding: 20px 24px 0;">
                    <div class="section-title" style="font-size: 1rem;">Production Tasks</div>
                </div>
                <div style="padding: 20px 24px;">
                    @forelse($order->tasks as $task)
                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;">
                        <p><strong>{{ $task->task_name }}</strong></p>
                        <p style="font-size: 0.8rem; color: #64748b;">Status: {{ ucfirst($task->status) }}</p>
                        @if($task->due_date)
                        <p style="font-size: 0.75rem; color: #94a3b8;">Due: {{ $task->due_date->format('d M Y') }}</p>
                        @endif
                    </div>
                    @empty
                    <p>No tasks assigned</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection