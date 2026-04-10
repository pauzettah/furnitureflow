@extends('admin.dashboard')

@section('title', 'Reports & Analytics')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Reports & Analytics</div>
            <div class="section-sub">Comprehensive business insights and performance metrics</div>
        </div>
        <a href="{{ route('admin.reports.export') }}" class="section-action"><i class="fa-solid fa-download"></i> Export Report</a>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-grid" style="margin-bottom: 28px;">
        <div class="stat-card fade-up delay-1">
            <div class="stat-icon navy"><i class="fa-solid fa-chart-line"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">KES {{ number_format($totalRevenue / 1000, 1) }}K</div>
        </div>
        <div class="stat-card fade-up delay-2">
            <div class="stat-icon gold"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-label">Outstanding Balance</div>
            <div class="stat-value">KES {{ number_format($outstandingBalance / 1000, 1) }}K</div>
        </div>
        <div class="stat-card fade-up delay-3">
            <div class="stat-icon emerald"><i class="fa-solid fa-check-circle"></i></div>
            <div class="stat-label">Completed Orders</div>
            <div class="stat-value">{{ $deliveredOrders }}</div>
        </div>
        <div class="stat-card fade-up delay-4">
            <div class="stat-icon rose"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-label">Pending Orders</div>
            <div class="stat-value">{{ $pendingOrders + $inProduction + $qualityCheck }}</div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="charts-grid fade-up delay-5" style="margin-bottom: 28px;">
        <div class="chart-card">
            <div class="section-header" style="margin-bottom: 16px;">
                <div>
                    <div class="section-title" style="font-size: 1rem;">Monthly Revenue</div>
                    <div class="section-sub">Revenue trend for {{ date('Y') }} (KES '000)</div>
                </div>
            </div>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
        <div class="chart-card">
            <div class="section-header" style="margin-bottom: 16px;">
                <div>
                    <div class="section-title" style="font-size: 1rem;">Monthly Orders</div>
                    <div class="section-sub">Orders trend for {{ date('Y') }}</div>
                </div>
            </div>
            <canvas id="ordersChart" height="120"></canvas>
        </div>
    </div>

    {{-- Payment Methods Breakdown --}}
    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Payment Methods</div>
                <div class="section-sub">Breakdown by payment method</div>
            </div>
            <div style="padding: 20px 24px;">
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>M-Pesa</span>
                        <span class="balance-positive">KES {{ number_format($mpesaPayments / 1000, 1) }}K</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $totalRevenue > 0 ? ($mpesaPayments / $totalRevenue) * 100 : 0 }}%; height: 100%; background: #10b981; border-radius: 4px;"></div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Bank Transfer</span>
                        <span class="balance-positive">KES {{ number_format($bankTransfers / 1000, 1) }}K</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $totalRevenue > 0 ? ($bankTransfers / $totalRevenue) * 100 : 0 }}%; height: 100%; background: #3b82f6; border-radius: 4px;"></div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Cash</span>
                        <span class="balance-positive">KES {{ number_format($cashPayments / 1000, 1) }}K</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $totalRevenue > 0 ? ($cashPayments / $totalRevenue) * 100 : 0 }}%; height: 100%; background: #f59e0b; border-radius: 4px;"></div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Card</span>
                        <span class="balance-positive">KES {{ number_format($cardPayments / 1000, 1) }}K</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $totalRevenue > 0 ? ($cardPayments / $totalRevenue) * 100 : 0 }}%; height: 100%; background: #8b5cf6; border-radius: 4px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Delivery Performance</div>
                <div class="section-sub">Delivery statistics</div>
            </div>
            <div style="padding: 20px 24px; text-align: center;">
                <div style="font-size: 48px; font-weight: 700; color: #10b981;">{{ $deliveryCompletionRate }}%</div>
                <div style="margin-top: 10px; color: #64748b;">Completion Rate</div>
                <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                    <div><strong>{{ $completedDeliveries }}</strong><br><span style="font-size: 12px;">Delivered</span></div>
                    <div><strong>{{ $pendingDeliveries }}</strong><br><span style="font-size: 12px;">Pending</span></div>
                    <div><strong>{{ $totalDeliveries }}</strong><br><span style="font-size: 12px;">Total</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products & Top Customers --}}
    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Top Selling Products</div>
                <div class="section-sub">Most ordered items</div>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr><th>Product</th><th>SKU</th><th>Qty Sold</th><th>Revenue</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->total_quantity }}</td>
                            <td>KES {{ number_format($product->total_revenue / 1000, 1) }}K</td>
                        </tr>
                        @empty
                        <tr><td colspan="4">No data available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Top Customers</div>
                <div class="section-sub">Highest spending customers</div>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr><th>Customer</th><th>Orders</th><th>Total Spent</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topCustomers as $customer)
                        <tr>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->total_orders }}</td>
                            <td>KES {{ number_format($customer->total_spent / 1000, 1) }}K</td>
                        </tr>
                        @empty
                        <tr><td colspan="3">No data available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Carpenter Performance --}}
    <div class="data-table-wrap" style="margin-bottom: 28px;">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">Carpenter Performance</div>
            <div class="section-sub">Task completion rates</div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr><th>Carpenter</th><th>Total Tasks</th><th>Completed</th><th>Completion Rate</th><th>Performance</th></tr>
                </thead>
                <tbody>
                    @forelse($carpenterPerformance as $carpenter)
                    <tr>
                        <td>{{ $carpenter->name }}</td>
                        <td>{{ $carpenter->total_tasks }}</td>
                        <td>{{ $carpenter->completed_tasks }}</td>
                        <td>{{ $carpenter->completion_rate }}%</td>
                        <td>
                            <div style="width: 100px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                <div style="width: {{ $carpenter->completion_rate }}%; height: 100%; background: #10b981; border-radius: 3px;"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">No data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Recent Orders</div>
                <div class="section-sub">Latest 10 orders</div>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>KES {{ number_format($order->total_amount / 1000, 1) }}K</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5">No orders found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Recent Payments</div>
                <div class="section-sub">Latest 10 transactions</div>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr><th>Payment #</th><th>Order</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->payment_number }}</td>
                            <td>{{ $payment->order->order_number ?? 'N/A' }}</td>
                            <td>KES {{ number_format($payment->amount / 1000, 1) }}K</td>
                            <td>{{ ucfirst($payment->method) }}</td>
                            <td><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></td>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6">No payments found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.color = '#94a3b8';

// Revenue Chart
const revCtx = document.getElementById('revenueChart').getContext('2d');
const revGradient = revCtx.createLinearGradient(0, 0, 0, 280);
revGradient.addColorStop(0, 'rgba(201,168,76,0.22)');
revGradient.addColorStop(1, 'rgba(201,168,76,0.00)');

new Chart(revCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Revenue (KES \'000)',
            data: @json($monthlyRevenue),
            borderColor: '#c9a84c',
            backgroundColor: revGradient,
            borderWidth: 2.5,
            pointRadius: 4,
            pointBackgroundColor: '#c9a84c',
            pointBorderColor: '#fff',
            tension: 0.45,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { ticks: { callback: v => 'K' + v } } }
    }
});

// Orders Chart
const ordCtx = document.getElementById('ordersChart').getContext('2d');
const barGrad = ordCtx.createLinearGradient(0, 0, 0, 260);
barGrad.addColorStop(0, 'rgba(201,168,76,0.90)');
barGrad.addColorStop(1, 'rgba(201,168,76,0.30)');

new Chart(ordCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Orders',
            data: @json($monthlyOrdersCount),
            backgroundColor: barGrad,
            borderRadius: 7,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush