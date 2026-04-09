<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FurnitureFlow') – Customer Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }

        .font-display {
            font-family: 'DM Serif Display', serif;
        }

        body {
            background: #F7F8FC;
            color: #1a1a2e;
        }

        /* Navbar glass effect */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        /* Cards */
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Progress bar */
        .progress-step {
            transition: all 0.3s ease;
        }

        .progress-fill {
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Timeline */
        .timeline-connector {
            width: 2px;
            background: #E2E8F0;
        }

        .timeline-connector.done {
            background: linear-gradient(180deg, #34D399, #059669);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #1E40AF, #3B82F6);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-mpesa {
            background: linear-gradient(135deg, #00A651, #00C766);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(0, 166, 81, 0.35);
        }

        .btn-mpesa:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 166, 81, 0.45);
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
        }

        .btn-whatsapp:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
        }

        /* Status badges */
        .badge {
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            padding: 3px 10px;
        }

        .badge-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-production {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .badge-ready {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-delivered {
            background: #F3F4F6;
            color: #374151;
        }

        /* Sidebar nav active */
        .nav-link {
            border-radius: 10px;
            transition: all 0.15s;
        }

        .nav-link:hover {
            background: #EFF6FF;
            color: #2563EB;
        }

        .nav-link.active {
            background: #EFF6FF;
            color: #2563EB;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.4s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.1s;
        }

        .fade-up-3 {
            animation-delay: 0.15s;
        }

        .fade-up-4 {
            animation-delay: 0.2s;
        }

        /* Form inputs */
        .form-input {
            width: 100%;
            border-radius: 10px;
            border: 1.5px solid #E5E7EB;
            padding: 10px 14px;
            font-size: 14px;
            transition: border-color 0.2s;
            background: #fff;
            color: #1a1a2e;
        }

        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Notification dot */
        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #EF4444;
            position: absolute;
            top: -1px;
            right: -1px;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen">

    {{-- TOP NAVBAR --}}
    <nav class="navbar-glass sticky top-0 z-50 px-6 py-3">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('customer.orders') }}" class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center">
                    <i class="fa-solid fa-couch text-white text-sm"></i>
                </div>
                <span class="font-display text-xl text-gray-900">FurnitureFlow</span>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('customer.orders') }}"
                    class="nav-link px-4 py-2 text-sm text-gray-600 flex items-center gap-2 {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open text-xs"></i> My Orders
                </a>
                <a href="#contact" class="nav-link px-4 py-2 text-sm text-gray-600 flex items-center gap-2">
                    <i class="fa-solid fa-headset text-xs"></i> Support
                </a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                {{-- Notifications --}}
                <button class="relative p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="notif-dot"></span>
                </button>

                {{-- Profile Dropdown --}}
                <div class="dropdown relative">
                    <button class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'John Doe', 0, 2)) }}
                        </div>
                        <span
                            class="text-sm text-gray-700 hidden md:inline">{{ auth()->user()->name ?? 'John Doe' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-2 w-48 card p-1 z-50">
                        <a href="#"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                            <i class="fa-regular fa-user w-4"></i> My Profile
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                            <i class="fa-solid fa-gear w-4"></i> Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN LAYOUT --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
        <div class="flex gap-6">

            {{-- SIDEBAR --}}
            <aside class="hidden lg:flex flex-col w-56 flex-shrink-0">
                <div class="card p-3 sticky top-24">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider px-3 mb-2">Menu</p>
                    <nav class="space-y-1">
                        <a href="{{ route('customer.orders') }}"
                            class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-600 {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                            <i class="fa-solid fa-list-ul w-4 text-center text-blue-500"></i> My Orders
                        </a>
                        <a href="{{ route('customer.payments') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-600">
                            <i class="fa-solid fa-credit-card w-4 text-center text-blue-500"></i> Payments
                        </a>
                        <a href="{{ route('customer.delivery') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-600">
                            <i class="fa-solid fa-truck w-4 text-center text-blue-500"></i> Delivery
                        </a>
                        <a href="#contact" class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-600">
                            <i class="fa-brands fa-whatsapp w-4 text-center text-green-500"></i> Contact Us
                        </a>
                    </nav>

                    {{-- Quick stats --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-3 px-3">
                        <div>
                            <p class="text-xs text-gray-400">Active Orders</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_orders'] ?? 2 }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Balance Due</p>
                            <p class="text-xl font-semibold text-red-500">KES
                                {{ number_format($stats['balance_due'] ?? 45000) }}
                            </p>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 min-w-0">
                @if(session('success'))
                    <div
                        class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2 fade-up">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div
                        class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm flex items-center gap-2 fade-up">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>