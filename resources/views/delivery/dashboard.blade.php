@extends('layouts.delivery')

@section('title', 'Today\'s Deliveries')

@php
$agent = [
    'name'   => auth()->user()->name ?? 'Marcus Oduya',
    'initials' => strtoupper(substr(auth()->user()->name ?? 'MO', 0, 2)),
    'badge'  => 'AGT-' . str_pad(auth()->id() ?? 1, 3, '0', STR_PAD_LEFT),
    'vehicle'=> 'KDA 712G',
];

$deliveries = $deliveries ?? [
    [
        'id'        => 'DEL-001',
        'customer'  => 'Amina Njoroge',
        'phone'     => '+254 712 345 678',
        'address'   => '14 Kiambu Road, Westlands, Nairobi',
        'lat'       => -1.2676,
        'lng'       => 36.8119,
        'items'     => ['L-Shaped Sofa Set', 'Coffee Table', 'TV Stand'],
        'status'    => 'pending',
        'time_slot' => '09:00 – 11:00 AM',
        'notes'     => 'Gate code: #4421. Ask for guard at entrance.',
        'otp'       => '8823',
    ],
    [
        'id'        => 'DEL-002',
        'customer'  => 'Brian Kamau',
        'phone'     => '+254 733 987 654',
        'address'   => '77 Ngong Road, Karen, Nairobi',
        'lat'       => -1.3192,
        'lng'       => 36.7073,
        'items'     => ['King Bed Frame', 'Mattress (Queen)', 'Bedside Tables x2'],
        'status'    => 'delivered',
        'time_slot' => '08:00 – 09:30 AM',
        'notes'     => '',
        'otp'       => '4491',
    ],
    [
        'id'        => 'DEL-003',
        'customer'  => 'Grace Wanjiku',
        'phone'     => '+254 722 111 222',
        'address'   => 'Apartment 5B, Mombasa Road, South B',
        'lat'       => -1.3244,
        'lng'       => 36.8344,
        'items'     => ['Dining Table 6-Seater', 'Dining Chairs x6'],
        'status'    => 'pending',
        'time_slot' => '12:00 – 02:00 PM',
        'notes'     => 'Call before arriving.',
        'otp'       => '7710',
    ],
    [
        'id'        => 'DEL-004',
        'customer'  => 'David Mutua',
        'phone'     => '+254 700 555 333',
        'address'   => '3 Lavington Close, Lavington, Nairobi',
        'lat'       => -1.2826,
        'lng'       => 36.7676,
        'items'     => ['Bookshelf (Tall)', 'Study Desk', 'Ergonomic Chair'],
        'status'    => 'pending',
        'time_slot' => '02:30 – 04:30 PM',
        'notes'     => 'Second floor, no elevator.',
        'otp'       => '3356',
    ],
];

$total     = count($deliveries);
$delivered = count(array_filter($deliveries, fn($d) => $d['status'] === 'delivered'));
$pending   = $total - $delivered;
$completionRate = $total > 0 ? round(($delivered / $total) * 100) : 0;
@endphp

{{-- DESKTOP CONTENT --}}
@section('desktop-content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Today's Deliveries</h1>
        <p class="text-slate-500 mt-1">{{ date('l, d F Y') }} · Vehicle: {{ $agent['vehicle'] }}</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-slate-800">{{ $total }}</p>
                    <p class="text-sm text-slate-500 mt-1">Total Deliveries</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-lucide="truck" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-emerald-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-emerald">{{ $delivered }}</p>
                    <p class="text-sm text-slate-500 mt-1">Completed</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-emerald"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-amber-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-amber-600">{{ $pending }}</p>
                    <p class="text-sm text-slate-500 mt-1">Pending</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-slate-800">{{ $completionRate }}%</p>
                    <p class="text-sm text-slate-500 mt-1">Completion Rate</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Delivery Cards Grid --}}
    @if(count($deliveries) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($deliveries as $index => $delivery)
        <div class="bg-white rounded-2xl shadow-sm border {{ $delivery['status'] === 'delivered' ? 'border-emerald-200' : 'border-slate-200' }} overflow-hidden hover:shadow-md transition-all duration-200" id="card-{{ $delivery['id'] }}">
            {{-- Status Bar --}}
            <div class="h-1 {{ $delivery['status'] === 'delivered' ? 'bg-emerald' : 'bg-amber-500' }}"></div>
            
            <div class="p-5">
                {{-- Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="font-mono text-xs text-slate-400 mb-1">{{ $delivery['id'] }}</p>
                        <h3 class="font-bold text-navy text-xl">{{ $delivery['customer'] }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span class="text-xs text-slate-500">{{ $delivery['time_slot'] }}</span>
                        </div>
                    </div>
                    @if($delivery['status'] === 'delivered')
                        <span class="inline-flex items-center gap-1.5 bg-emerald/10 text-emerald text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 bg-emerald rounded-full"></span>
                            Delivered
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-amber/10 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                            Pending
                        </span>
                    @endif
                </div>

                {{-- Contact Info --}}
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-slate-600">{{ $delivery['phone'] }}</span>
                        <a href="tel:{{ preg_replace('/\s+/', '', $delivery['phone']) }}" class="ml-auto text-emerald text-xs font-semibold hover:underline">
                            Call Now
                        </a>
                    </div>
                    <div class="flex items-start gap-2 text-sm">
                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"></i>
                        <span class="text-slate-600">{{ $delivery['address'] }}</span>
                    </div>
                </div>

                {{-- Items List --}}
                <div class="bg-slate-50 rounded-xl p-3 mb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i data-lucide="package" class="w-3.5 h-3.5"></i>
                        Items ({{ count($delivery['items']) }})
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($delivery['items'] as $item)
                        <span class="text-xs bg-white px-2 py-1 rounded-lg text-slate-600 shadow-sm">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Notes if any --}}
                @if($delivery['notes'])
                <div class="flex items-start gap-2 mb-4 bg-amber-50 rounded-xl px-3 py-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0"></i>
                    <p class="text-xs text-amber-700 leading-relaxed">{{ $delivery['notes'] }}</p>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <button onclick="openDetails({{ $index }})" class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">
                        <i data-lucide="eye" class="w-4 h-4"></i> Details
                    </button>
                    <a href="https://www.google.com/maps?q={{ $delivery['lat'] }},{{ $delivery['lng'] }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold hover:bg-navy-800 transition">
                        <i data-lucide="navigation" class="w-4 h-4"></i> Navigate
                    </a>
                </div>

                {{-- Mark Delivered Button --}}
                @if($delivery['status'] === 'pending')
                <button onclick="openMarkDelivered({{ $index }})" class="mt-3 w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-emerald text-white font-bold text-sm hover:bg-emerald-600 transition shadow-md">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Mark as Delivered
                </button>
                @else
                <div class="mt-3 w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-emerald/10 text-emerald font-semibold text-sm">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    Delivery Confirmed
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl p-12 text-center">
        <i data-lucide="truck" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
        <h3 class="text-xl font-semibold text-slate-600 mb-2">No Deliveries Today</h3>
        <p class="text-slate-400">You have no deliveries scheduled for today. Enjoy your day off!</p>
    </div>
    @endif
</div>
@endsection

{{-- MOBILE CONTENT --}}
@section('mobile-content')
<header class="bg-navy text-white sticky top-0 z-40 shadow-lg">
    <div class="px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald flex items-center justify-center font-bold text-white text-sm shadow-md">
                {{ $agent['initials'] }}
            </div>
            <div>
                <p class="text-xs text-slate-400 font-mono leading-none mb-0.5">{{ $agent['badge'] }}</p>
                <p class="font-semibold text-sm leading-none">{{ $agent['name'] }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openSOS()" class="w-9 h-9 rounded-full bg-red-500/20 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-red-400"></i>
            </button>
        </div>
    </div>
    <div class="px-4 pb-4 pt-1">
        <h1 class="text-xl font-bold tracking-tight">Today's Deliveries</h1>
        <p class="text-xs text-slate-400 mt-0.5">{{ date('l, d F Y') }} · {{ $agent['vehicle'] }}</p>
    </div>
    <div class="px-4 pb-4">
        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="bg-navy-800 rounded-xl py-2 px-1">
                <p class="text-lg font-bold font-mono">{{ $total }}</p>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider">Total</p>
            </div>
            <div class="bg-emerald/20 border border-emerald/30 rounded-xl py-2 px-1">
                <p class="text-lg font-bold font-mono text-emerald">{{ $delivered }}</p>
                <p class="text-[10px] text-emerald/70 uppercase tracking-wider">Done</p>
            </div>
            <div class="bg-amber/20 border border-amber/30 rounded-xl py-2 px-1">
                <p class="text-lg font-bold font-mono text-amber-500">{{ $pending }}</p>
                <p class="text-[10px] text-amber-500/70 uppercase tracking-wider">Pending</p>
            </div>
        </div>
    </div>
</header>

<main class="px-4 pt-4 pb-32 space-y-4">
    @foreach($deliveries as $index => $delivery)
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border {{ $delivery['status'] === 'delivered' ? 'border-emerald/30' : 'border-slate-100' }}" id="card-{{ $delivery['id'] }}">
        <div class="h-1 {{ $delivery['status'] === 'delivered' ? 'bg-emerald' : 'bg-amber-500' }}"></div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="font-mono text-xs text-slate-400">{{ $delivery['id'] }}</p>
                    <h2 class="font-bold text-navy text-lg">{{ $delivery['customer'] }}</h2>
                    <div class="flex items-center gap-1 mt-0.5">
                        <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                        <span class="text-xs text-slate-500">{{ $delivery['time_slot'] }}</span>
                    </div>
                </div>
                @if($delivery['status'] === 'delivered')
                    <span class="inline-flex items-center gap-1.5 bg-emerald/10 text-emerald text-xs font-semibold px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-emerald rounded-full"></span> Delivered
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 bg-amber/10 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Pending
                    </span>
                @endif
            </div>

            <div class="space-y-2 mb-3">
                <div class="flex items-center gap-2 text-sm">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span class="text-slate-600 text-sm">{{ $delivery['phone'] }}</span>
                    <a href="tel:{{ preg_replace('/\s+/', '', $delivery['phone']) }}" class="ml-auto text-emerald text-xs font-semibold">Call</a>
                </div>
                <div class="flex items-start gap-2 text-sm">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 mt-0.5"></i>
                    <span class="text-slate-600 text-sm">{{ $delivery['address'] }}</span>
                </div>
            </div>

            <div class="bg-slate-50 rounded-xl p-3 mb-3">
                <p class="text-xs font-semibold text-slate-500 mb-2">Items ({{ count($delivery['items']) }})</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($delivery['items'] as $item)
                    <span class="text-xs bg-white px-2 py-1 rounded-lg text-slate-600">{{ $item }}</span>
                    @endforeach
                </div>
            </div>

            @if($delivery['notes'])
            <div class="flex items-start gap-2 mb-3 bg-amber-50 rounded-xl px-3 py-2">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-600 mt-0.5"></i>
                <p class="text-xs text-amber-700">{{ $delivery['notes'] }}</p>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-2">
                <button onclick="openDetails({{ $index }})" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium">
                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> Details
                </button>
                <a href="https://www.google.com/maps?q={{ $delivery['lat'] }},{{ $delivery['lng'] }}" target="_blank" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-navy text-white text-sm font-medium">
                    <i data-lucide="navigation" class="w-3.5 h-3.5"></i> Navigate
                </a>
            </div>

            @if($delivery['status'] === 'pending')
            <button onclick="openMarkDelivered({{ $index }})" class="mt-2 w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-emerald text-white font-semibold text-sm">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Mark Delivered
            </button>
            @else
            <div class="mt-2 w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-emerald/10 text-emerald font-semibold text-sm">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i> Confirmed
            </div>
            @endif
        </div>
    </div>
    @endforeach
</main>

{{-- Bottom Bar --}}
<div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-slate-200 shadow-lg safe-area-inset-bottom">
    <div class="px-4 py-3 flex items-center justify-between gap-3">
        <div class="text-sm">
            <span class="font-bold text-navy">{{ $pending }}</span>
            <span class="text-slate-500"> remaining</span>
        </div>
        <button onclick="openSOS()" class="flex items-center gap-2 text-xs text-red-500 font-semibold py-2 px-3 rounded-lg border border-red-200">
            <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i> Report Issue
        </button>
        <button onclick="scrollToNext()" class="flex items-center gap-2 bg-navy text-white font-semibold text-sm py-2 px-4 rounded-xl">
            <i data-lucide="chevron-down" class="w-4 h-4"></i> Next
        </button>
    </div>
</div>
@endsection