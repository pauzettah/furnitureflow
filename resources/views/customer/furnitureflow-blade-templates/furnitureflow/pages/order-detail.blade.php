@extends('layouts.app')

@section('title', 'Order #' . ($order['id'] ?? 'FF-2401'))

@section('content')

@php
$order = $order ?? [
    'id'          => 'FF-2401',
    'item'        => 'L-Shaped Sofa Set (7-Seater)',
    'description' => 'Premium fabric L-shaped sofa in dark grey. Frame: hardwood. Cushions: high-density foam. Legs: brushed chrome. Dimensions: 320cm × 220cm.',
    'total'       => 120000,
    'deposit'     => 60000,
    'balance'     => 60000,
    'status'      => 'production',
    'date'        => 'Jan 15, 2025',
    'timeline'    => [
        ['step' => 'Order Placed',         'date' => 'Jan 15, 2025, 10:32 AM', 'done' => true],
        ['step' => 'Production Started',   'date' => 'Jan 17, 2025, 9:00 AM',  'done' => true],
        ['step' => 'Ready for Delivery',   'date' => 'Expected Feb 5, 2025',   'done' => false],
        ['step' => 'Delivered',            'date' => 'TBD',                    'done' => false],
    ],
];

$statusMap = [
    'pending'    => ['label' => 'Pending',       'class' => 'badge-pending',    'step' => 1],
    'production' => ['label' => 'In Production', 'class' => 'badge-production', 'step' => 2],
    'ready'      => ['label' => 'Ready',          'class' => 'badge-ready',      'step' => 3],
    'delivered'  => ['label' => 'Delivered',      'class' => 'badge-delivered',  'step' => 4],
];
$s = $statusMap[$order['status']] ?? $statusMap['pending'];
@endphp

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6 fade-up">
    <a href="{{ route('customer.orders') }}" class="hover:text-blue-600 transition">My Orders</a>
    <i class="fa-solid fa-chevron-right text-xs"></i>
    <span class="text-gray-700 font-medium">Order #{{ $order['id'] }}</span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ====== LEFT COLUMN (2/3) ====== --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- A. ORDER DETAILS CARD --}}
        <div class="card p-6 fade-up fade-up-1">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-lg text-gray-900">Order Details</h2>
                <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>

            <div class="flex gap-4 mb-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-400 text-2xl flex-shrink-0">
                    <i class="fa-solid fa-couch"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 mb-1">{{ $order['item'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $order['description'] }}</p>
                </div>
            </div>

            {{-- Payment Summary --}}
            <div class="bg-gray-50 rounded-2xl p-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Amount</span>
                    <span class="font-medium text-gray-900">KES {{ number_format($order['total']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Deposit Paid</span>
                    <span class="font-medium text-green-600">– KES {{ number_format($order['deposit']) }}</span>
                </div>
                <div class="border-t border-gray-200 pt-3 flex justify-between">
                    <span class="font-semibold text-gray-700">Balance Due</span>
                    <span class="font-bold text-lg {{ $order['balance'] > 0 ? 'text-red-500' : 'text-green-600' }}">
                        KES {{ number_format($order['balance']) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- C. STATUS TIMELINE --}}
        <div class="card p-6 fade-up fade-up-2">
            <h2 class="font-semibold text-lg text-gray-900 mb-6">Order Timeline</h2>
            <div class="space-y-0">
                @foreach($order['timeline'] as $i => $step)
                <div class="flex gap-4">
                    {{-- Icon + connector --}}
                    <div class="flex flex-col items-center">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $step['done'] ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-300' }}">
                            @if($step['done'])
                                <i class="fa-solid fa-check text-sm"></i>
                            @else
                                <i class="fa-regular fa-clock text-sm"></i>
                            @endif
                        </div>
                        @if(!$loop->last)
                            <div class="w-0.5 flex-1 my-1 {{ $step['done'] ? 'bg-green-300' : 'bg-gray-100' }}"></div>
                        @endif
                    </div>
                    {{-- Content --}}
                    <div class="pb-6">
                        <p class="font-medium text-sm {{ $step['done'] ? 'text-gray-900' : 'text-gray-400' }}">
                            {{ $step['step'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $step['date'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- F. CONTACT WAREHOUSE --}}
        <div class="card p-6 fade-up fade-up-3" id="contact">
            <h2 class="font-semibold text-lg text-gray-900 mb-1">Contact Warehouse</h2>
            <p class="text-sm text-gray-400 mb-5">Have a question about your order? Reach us instantly.</p>

            <a href="https://wa.me/254700000000?text=Hi!%20I%20have%20a%20question%20about%20Order%20%23{{ $order['id'] }}"
               target="_blank"
               class="btn-whatsapp flex items-center justify-center gap-2 py-3 px-6 w-full mb-5 text-sm">
                <i class="fa-brands fa-whatsapp text-lg"></i>
                Chat on WhatsApp
            </a>

            <form action="{{ route('customer.contact') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                <input type="text" name="name" placeholder="Your Name"
                       class="form-input" value="{{ auth()->user()->name ?? '' }}">
                <textarea name="message" rows="3" placeholder="Type your message here..."
                          class="form-input resize-none"></textarea>
                <button type="submit" class="btn-primary w-full py-2.5 text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

    </div>

    {{-- ====== RIGHT COLUMN (1/3) ====== --}}
    <div class="space-y-6">

        {{-- D. MAKE PAYMENT --}}
        <div class="card p-6 fade-up fade-up-1" id="payments">
            <h2 class="font-semibold text-lg text-gray-900 mb-1">Make Payment</h2>
            @if($order['balance'] > 0)
                <p class="text-xs text-amber-600 bg-amber-50 rounded-lg px-3 py-2 mb-4">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Balance due before delivery is scheduled.
                </p>
                <div class="bg-blue-50 rounded-2xl p-4 mb-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Amount Due</p>
                    <p class="text-3xl font-bold text-gray-900">KES {{ number_format($order['balance']) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Order #{{ $order['id'] }}</p>
                </div>
                <form action="{{ route('customer.payment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 mb-1.5 block">Payment Amount (KES)</label>
                        <input type="number" name="amount" class="form-input"
                               value="{{ $order['balance'] }}" min="1" max="{{ $order['balance'] }}">
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 mb-1.5 block">M-Pesa Phone Number</label>
                        <input type="text" name="phone" class="form-input" placeholder="0700 000 000">
                    </div>
                    <button type="submit" class="btn-mpesa w-full py-3 text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-mobile-screen"></i>
                        Pay with M-Pesa
                    </button>
                </form>
            @else
                <div class="text-center py-6">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-check text-green-500 text-xl"></i>
                    </div>
                    <p class="font-medium text-gray-800">Fully Paid</p>
                    <p class="text-xs text-gray-400 mt-1">No outstanding balance</p>
                </div>
            @endif
        </div>

        {{-- E. REQUEST DELIVERY --}}
        <div class="card p-6 fade-up fade-up-2" id="delivery">
            <h2 class="font-semibold text-lg text-gray-900 mb-1">Request Delivery</h2>
            <p class="text-xs text-gray-400 mb-4">Schedule your preferred delivery window.</p>

            @if($order['status'] === 'ready')
                <form action="{{ route('customer.delivery') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                    <div>
                        <label class="text-xs text-gray-500 mb-1.5 block">Preferred Date</label>
                        <input type="date" name="delivery_date" class="form-input"
                               min="{{ now()->addDays(1)->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1.5 block">Preferred Time</label>
                        <select name="delivery_time" class="form-input">
                            <option value="08:00-11:00">8:00 AM – 11:00 AM</option>
                            <option value="11:00-14:00">11:00 AM – 2:00 PM</option>
                            <option value="14:00-17:00">2:00 PM – 5:00 PM</option>
                            <option value="17:00-20:00">5:00 PM – 8:00 PM</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1.5 block">Delivery Address</label>
                        <input type="text" name="address" class="form-input" placeholder="Enter delivery address">
                    </div>
                    <button type="submit" class="btn-primary w-full py-2.5 text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-truck"></i> Schedule Delivery
                    </button>
                </form>
            @else
                <div class="text-center py-6 text-gray-400">
                    <i class="fa-solid fa-truck text-3xl mb-3 text-gray-200"></i>
                    <p class="text-sm">Delivery scheduling is available once your order is <span class="font-medium text-blue-500">Ready</span>.</p>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
