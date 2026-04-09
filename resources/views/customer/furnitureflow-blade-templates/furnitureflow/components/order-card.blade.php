{{--
    Order Card Component
    Usage: @include('components.order-card', ['order' => $order])
--}}

@php
    $statusMap = [
        'pending'    => ['label' => 'Pending',        'class' => 'badge-pending',    'icon' => 'fa-clock',      'step' => 1],
        'production' => ['label' => 'In Production',  'class' => 'badge-production', 'icon' => 'fa-hammer',     'step' => 2],
        'ready'      => ['label' => 'Ready',           'class' => 'badge-ready',      'icon' => 'fa-box-open',   'step' => 3],
        'delivered'  => ['label' => 'Delivered',       'class' => 'badge-delivered',  'icon' => 'fa-check',      'step' => 4],
    ];
    $s = $statusMap[$order['status']] ?? $statusMap['pending'];
    $pct = ($s['step'] / 4) * 100;
    $steps = ['Pending', 'Production', 'Ready', 'Delivered'];
@endphp

<div class="card p-5 fade-up">
    {{-- Header --}}
    <div class="flex items-start justify-between mb-4">
        <div>
            <p class="text-xs text-gray-400 mb-1">Order ID</p>
            <p class="font-semibold text-gray-900">#{{ $order['id'] }}</p>
        </div>
        <span class="badge {{ $s['class'] }}">
            <i class="fa-solid {{ $s['icon'] }} mr-1 text-xs"></i>{{ $s['label'] }}
        </span>
    </div>

    {{-- Item Info --}}
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 flex-shrink-0">
            <i class="fa-solid fa-couch"></i>
        </div>
        <div>
            <p class="font-medium text-gray-800 text-sm">{{ $order['item'] }}</p>
            <p class="text-xs text-gray-400">Ordered {{ $order['date'] }}</p>
        </div>
    </div>

    {{-- Financials --}}
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="text-center p-2 rounded-xl bg-gray-50">
            <p class="text-xs text-gray-400 mb-0.5">Total</p>
            <p class="font-semibold text-gray-800 text-sm">KES {{ number_format($order['total']) }}</p>
        </div>
        <div class="text-center p-2 rounded-xl bg-green-50">
            <p class="text-xs text-gray-400 mb-0.5">Paid</p>
            <p class="font-semibold text-green-600 text-sm">KES {{ number_format($order['deposit']) }}</p>
        </div>
        <div class="text-center p-2 rounded-xl bg-red-50">
            <p class="text-xs text-gray-400 mb-0.5">Balance</p>
            <p class="font-semibold text-red-500 text-sm">KES {{ number_format($order['balance']) }}</p>
        </div>
    </div>

    {{-- Progress Steps --}}
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            @foreach($steps as $i => $step)
                <span class="text-xs {{ ($i + 1) <= $s['step'] ? 'text-blue-600 font-medium' : 'text-gray-400' }}">
                    {{ $step }}
                </span>
            @endforeach
        </div>
        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full progress-fill"
                 style="width: {{ $pct }}%"></div>
        </div>
        <div class="flex justify-between mt-1.5">
            @foreach($steps as $i => $step)
                <div class="w-3 h-3 rounded-full {{ ($i + 1) <= $s['step'] ? 'bg-blue-500' : 'bg-gray-200' }} -mt-3.5 relative z-10"></div>
            @endforeach
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-2 pt-2 border-t border-gray-100">
        <a href="{{ route('customer.order.detail', $order['id']) }}"
           class="flex-1 text-center py-2 text-sm text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition">
            View Details
        </a>
        @if($order['balance'] > 0)
            <a href="#payments"
               class="flex-1 text-center btn-primary py-2 text-sm">
                Pay Balance
            </a>
        @else
            <span class="flex-1 text-center py-2 text-sm text-green-600 font-medium rounded-lg bg-green-50">
                <i class="fa-solid fa-check mr-1"></i> Paid
            </span>
        @endif
    </div>
</div>
