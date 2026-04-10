@extends('admin.dashboard')

@section('title', 'Dashboard')

@section('content')
{{-- A. SUMMARY CARDS --}}
<div class="summary-grid">
    @foreach($stats as $i => $s)
    <div class="stat-card fade-up delay-{{ $i + 1 }}">
        <div class="stat-icon {{ $s['color'] }}">
            <i class="fa-solid {{ $s['icon'] }}"></i>
        </div>
        <div class="stat-label">{{ $s['label'] }}</div>
        <div class="stat-value">{{ $s['value'] }}</div>
        <div>
            <span class="stat-trend {{ $s['dir'] }}">
                <i class="fa-solid fa-arrow-{{ $s['dir'] === 'up' ? 'up' : 'down' }}"></i>
                {{ $s['trend'] }}
            </span>
            <span class="stat-period">{{ $s['period'] }}</span>
        </div>
    </div>
    @endforeach
</div>

{{-- B. KANBAN BOARD --}}
<div class="fade-up delay-5" style="margin-bottom: 28px;">
    <div class="section-header">
        <div>
            <div class="section-title">Orders Workflow</div>
            <div class="section-sub">Track orders across production stages</div>
        </div>
        <a href="#" class="section-action"><i class="fa-solid fa-plus"></i> New Order</a>
    </div>
    <div class="kanban-scroll">
        <div class="kanban-board">
            @foreach($kanban as $col => $data)
            <div class="kanban-col">
                <div class="kanban-col-header">
                    <div style="display:flex;align-items:center;gap:7px;">
                        <span class="status-dot {{ $data['dot'] }}"></span>
                        <span class="kanban-col-title">{{ $col }}</span>
                    </div>
                    <span class="kanban-count">{{ count($data['cards']) }}</span>
                </div>
                @forelse($data['cards'] as $card)
                <div class="kanban-card">
                    <div class="kanban-card-id">{{ $card['id'] }}</div>
                    <div class="kanban-card-name">{{ $card['name'] }}</div>
                    <div class="kanban-card-type">{{ $card['type'] }}</div>
                    <div class="kanban-card-footer">
                        <span class="kanban-deadline"><i class="fa-regular fa-calendar"></i> {{ $card['deadline'] }}</span>
                        <span class="status-dot {{ $data['dot'] }}"></span>
                    </div>
                </div>
                @empty
                <div class="kanban-card">
                    <div class="kanban-card-name" style="color:#94a3b8;">No orders</div>
                </div>
                @endforelse
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- C. CHARTS --}}
<div class="charts-grid fade-up delay-6" style="margin-bottom:28px;">
    <div class="chart-card">
        <div class="section-header" style="margin-bottom:6px;">
            <div>
                <div class="section-title" style="font-size:1rem;">Revenue Over Time</div>
                <div class="section-sub">Monthly revenue for {{ date('Y') }}</div>
            </div>
        </div>
        <canvas id="revenueChart" height="110"></canvas>
    </div>
    <div class="chart-card">
        <div class="section-header" style="margin-bottom:6px;">
            <div>
                <div class="section-title" style="font-size:1rem;">Orders Per Month</div>
                <div class="section-sub">Total orders placed each month</div>
            </div>
        </div>
        <canvas id="ordersChart" height="110"></canvas>
    </div>
</div>

{{-- D. RECENT ORDERS TABLE --}}
<div class="data-table-wrap">
    <div class="data-table-header" style="padding: 22px 24px 0;">
        <div class="section-header" style="margin-bottom:0;">
            <div>
                <div class="section-title">Recent Orders</div>
                <div class="section-sub">{{ count($recentOrders) }} records shown</div>
            </div>
            <a href="#" class="section-action"><i class="fa-solid fa-download"></i> Export</a>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Amount</th><th>Deadline</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $o)
                <tr>
                    <td><span class="order-id">{{ $o['id'] }}</span></td>
                    <td>{{ $o['customer'] }}</td>
                    <td><span class="badge {{ $o['badge'] }}">{{ $o['status'] }}</span></td>
                    <td>{{ $o['amount'] }}</td>
                    <td class="{{ $o['overdue'] ? 'deadline-overdue' : '' }}">{{ $o['deadline'] }}</td>
                    <td><button class="btn-view">View</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- E. ALERTS SECTION --}}
<div class="alerts-grid fade-up delay-6">
    <div class="alert-card warning">
        <div class="alert-header">
            <div class="alert-icon warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div>
                <div class="alert-title">Low Stock Warning</div>
                <div class="alert-sub">{{ count($lowStock) }} materials below threshold</div>
            </div>
        </div>
        @foreach($lowStock as $item)
        <div class="alert-item">
            <div><div class="alert-item-label">{{ $item['item'] }}</div></div>
            <div class="alert-item-value warning">{{ $item['qty'] }}</div>
        </div>
        @endforeach
    </div>
    <div class="alert-card danger">
        <div class="alert-header">
            <div class="alert-icon danger"><i class="fa-solid fa-clock"></i></div>
            <div>
                <div class="alert-title">Overdue Orders</div>
                <div class="alert-sub">{{ count($overdueOrdersList) }} orders past deadline</div>
            </div>
        </div>
        @foreach($overdueOrdersList as $od)
        <div class="alert-item">
            <div><div class="alert-item-label">{{ $od['customer'] }}</div></div>
            <div class="alert-item-value danger">{{ $od['days'] }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.color = '#94a3b8';

const revCtx = document.getElementById('revenueChart').getContext('2d');
const revGradient = revCtx.createLinearGradient(0, 0, 0, 280);
revGradient.addColorStop(0, 'rgba(201,168,76,0.22)');
revGradient.addColorStop(1, 'rgba(201,168,76,0.00)');

new Chart(revCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Revenue (KES M)',
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
        scales: { y: { ticks: { callback: v => 'M' + v } } }
    }
});

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
            data: @json($monthlyOrders),
            backgroundColor: barGrad,
            borderRadius: 7,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endpush