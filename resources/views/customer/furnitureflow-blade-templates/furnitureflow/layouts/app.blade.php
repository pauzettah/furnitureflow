<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FurnitureFlow') – Customer Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'DM Serif Display', serif; }

        body { background: #F7F8FC; color: #1a1a2e; }

        /* Navbar glass effect */
        .navbar-glass {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        /* Cards */
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.1); transform: translateY(-2px); }

        /* Progress bar */
        .progress-step { transition: all 0.3s ease; }
        .progress-fill { transition: width 0.6s cubic-bezier(0.4,0,0.2,1); }

        /* Timeline */
        .timeline-connector { width: 2px; background: #E2E8F0; }
        .timeline-connector.done { background: linear-gradient(180deg, #34D399, #059669); }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #1E40AF, #3B82F6);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(59,130,246,0.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,130,246,0.45); }
        .btn-primary:active { transform: translateY(0); }

        .btn-mpesa {
            background: linear-gradient(135deg, #00A651, #00C766);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(0,166,81,0.35);
        }
        .btn-mpesa:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,166,81,0.45); }

        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(37,211,102,0.35);
        }
        .btn-whatsapp:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,211,102,0.45); }

        /* Status badges */
        .badge { border-radius: 999px; font-size: 12px; font-weight: 500; padding: 3px 10px; }
        .badge-pending   { background:#FEF3C7; color:#92400E; }
        .badge-production{ background:#DBEAFE; color:#1E40AF; }
        .badge-ready     { background:#D1FAE5; color:#065F46; }
        .badge-delivered { background:#F3F4F6; color:#374151; }

        /* Sidebar nav active */
        .sidebar-link { 
            border-radius: 10px; 
            transition: all 0.15s; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 10px 16px;
            color: #4B5563;
            font-size: 14px;
            font-weight: 500;
        }
        .sidebar-link:hover { 
            background: #EFF6FF; 
            color: #2563EB; 
        }
        .sidebar-link.active { 
            background: #EFF6FF; 
            color: #2563EB; 
            font-weight: 600;
        }
        .sidebar-link i { 
            width: 20px; 
            text-align: center; 
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp 0.4s ease both; }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.1s; }
        .fade-up-3 { animation-delay: 0.15s; }
        .fade-up-4 { animation-delay: 0.2s; }

        /* Form inputs */
        .form-input {
            width: 100%; border-radius: 10px; border: 1.5px solid #E5E7EB;
            padding: 10px 14px; font-size: 14px; transition: border-color 0.2s;
            background: #fff; color: #1a1a2e;
        }
        .form-input:focus { outline: none; border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

        /* Dropdown */
        .dropdown-menu { display: none; }
        .dropdown:hover .dropdown-menu { display: block; }

        /* Notification dot */
        .notif-dot { width:8px;height:8px;border-radius:50%;background:#EF4444;position:absolute;top:-1px;right:-1px; }

        /* Sidebar full height */
        .sidebar-full {
            position: fixed;
            left: 0;
            top: 57px;
            bottom: 0;
            width: 260px;
            background: #fff;
            border-right: 1px solid #E5E7EB;
            overflow-y: auto;
            z-index: 40;
        }
        .main-content {
            margin-left: 260px;
        }
        @media (max-width: 1024px) {
            .sidebar-full {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-full.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">

{{-- TOP NAVBAR --}}
<nav class="navbar-glass sticky top-0 z-50 px-6 py-3">
    <div class="flex items-center justify-between">

        {{-- Mobile Menu Button --}}
        <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
            <i class="fa-solid fa-bars text-gray-600 text-xl"></i>
        </button>

        {{-- Logo --}}
        <a href="{{ route('customer.orders') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center">
                <i class="fa-solid fa-couch text-white text-sm"></i>
            </div>
            <span class="font-display text-xl text-gray-900">FurnitureFlow</span>
        </a>

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
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-semibold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'JD', 0, 2)) }}
                    </div>
                    <span class="text-sm text-gray-700 hidden md:inline">{{ auth()->user()->name ?? 'John Doe' }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </button>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 card p-1 z-50">
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fa-regular fa-user w-4"></i> My Profile
                    </a>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fa-solid fa-gear w-4"></i> Settings
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-red-50">
                            <i class="fa-solid fa-right-from-bracket w-4"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- SIDEBAR - Fixed to left edge --}}
<aside id="sidebar" class="sidebar-full">
    <div class="p-4">
        <div class="mb-6 px-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center mb-3">
                <i class="fa-solid fa-couch text-white text-xl"></i>
            </div>
            <p class="text-xs text-gray-400">Welcome back,</p>
            <p class="font-semibold text-gray-800">{{ auth()->user()->name ?? 'Customer' }}</p>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('customer.orders') }}" class="sidebar-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                <i class="fa-solid fa-list-ul text-blue-500"></i> My Orders
            </a>
            <a href="#" onclick="scrollToPayments(); return false;" class="sidebar-link">
                <i class="fa-solid fa-credit-card text-green-500"></i> Payments
            </a>
            <a href="#" onclick="scrollToDelivery(); return false;" class="sidebar-link">
                <i class="fa-solid fa-truck text-purple-500"></i> Delivery
            </a>
            <a href="#" onclick="scrollToContact(); return false;" class="sidebar-link">
                <i class="fa-brands fa-whatsapp text-green-500"></i> Contact Us
            </a>
        </nav>

        <div class="border-t border-gray-100 my-4"></div>

        <nav class="space-y-1">
            <p class="text-xs text-gray-400 uppercase tracking-wider px-3 mb-2">Account</p>
            <a href="#" class="sidebar-link">
                <i class="fa-regular fa-user text-gray-400"></i> Profile
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-location-dot text-gray-400"></i> Addresses
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-regular fa-bell text-gray-400"></i> Notifications
            </a>
        </nav>

        <div class="border-t border-gray-100 my-4"></div>

        <nav class="space-y-1">
            <p class="text-xs text-gray-400 uppercase tracking-wider px-3 mb-2">Support</p>
            <a href="#" class="sidebar-link">
                <i class="fa-regular fa-circle-question text-gray-400"></i> Help Center
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-regular fa-file-lines text-gray-400"></i> FAQs
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-shield-alt text-gray-400"></i> Privacy Policy
            </a>
        </nav>

        {{-- Quick Stats --}}
        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
            <p class="text-xs text-gray-400 mb-2">Quick Stats</p>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Active Orders</span>
                    <span class="text-lg font-bold text-gray-800">{{ $stats['active_orders'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Balance Due</span>
                    <span class="text-lg font-bold text-red-500">KES {{ number_format($stats['balance_due'] ?? 0) }}</span>
                </div>
            </div>
        </div>

        {{-- Logout Button --}}
        <div class="mt-4 pt-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-500 hover:bg-red-50 hover:text-red-600">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<main class="main-content min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2 fade-up">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm flex items-center gap-2 fade-up">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script>
    // Mobile sidebar toggle (single version)
    const menuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }

    // Function to get the first order ID from the orders page
    function getFirstOrderId() {
        // Look for any "View Details" button or order link
        const viewDetailsLinks = document.querySelectorAll('a[href*="/customer/orders/"]');
        for (let link of viewDetailsLinks) {
            const match = link.getAttribute('href').match(/\/customer\/orders\/(.+)/);
            if (match) {
                return match[1];
            }
        }
        return null;
    }

    // Scroll to Payments section
    function scrollToPayments() {
        const paymentsSection = document.getElementById('payments');
        if (paymentsSection) {
            paymentsSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            // Try to redirect to first order's detail page with #payments hash
            const orderId = getFirstOrderId();
            if (orderId) {
                window.location.href = '/customer/orders/' + orderId + '#payments';
            } else {
                alert('You have no orders yet. Please place an order first.');
            }
        }
    }
    
    // Scroll to Delivery section
    function scrollToDelivery() {
        const deliverySection = document.getElementById('delivery');
        if (deliverySection) {
            deliverySection.scrollIntoView({ behavior: 'smooth' });
        } else {
            const orderId = getFirstOrderId();
            if (orderId) {
                window.location.href = '/customer/orders/' + orderId + '#delivery';
            } else {
                alert('You have no orders yet. Please place an order first.');
            }
        }
    }
    
    // Scroll to Contact section
    function scrollToContact() {
        const contactSection = document.getElementById('contact');
        if (contactSection) {
            contactSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            const orderId = getFirstOrderId();
            if (orderId) {
                window.location.href = '/customer/orders/' + orderId + '#contact';
            } else {
                alert('You have no orders yet. Please place an order first.');
            }
        }
    }

    // Check if we have a hash in the URL and scroll to that element on page load
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const element = document.querySelector(window.location.hash);
            if (element) {
                setTimeout(function() {
                    element.scrollIntoView({ behavior: 'smooth' });
                }, 500);
            }
        }
    });
</script>

@stack('scripts')
</body>
</html>