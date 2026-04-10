<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurnitureFlow — @yield('title', 'Admin Dashboard')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:   { DEFAULT: '#0f172a', 50: '#f0f4ff', 100: '#e0e9ff', 200: '#c7d7fe', 800: '#1e293b', 900: '#0f172a' },
                        gold:   { DEFAULT: '#c9a84c', light: '#e8cc7e', dark: '#a07a2a' },
                        slate:  { DEFAULT: '#64748b' },
                    },
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body:    ['"DM Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --navy: #0f172a; --navy-800: #1e293b; --gold: #c9a84c;
            --emerald: #10b981; --rose: #f43f5e; --amber: #f59e0b;
            --slate-400: #94a3b8; --slate-100: #f1f5f9;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #f1f5f9; color: #1e293b; overflow-x: hidden; }

        /* Sidebar */
        #sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background: var(--navy); box-shadow: 4px 0 32px rgba(15,23,42,0.18);
            display: flex; flex-direction: column; z-index: 50;
            transition: transform 0.35s cubic-bezier(.77,0,.175,1);
        }
        #sidebar .logo-wrap { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        #sidebar .logo-mark { font-family: 'Playfair Display', serif; font-size: 1.45rem; font-weight: 700; color: #fff; }
        #sidebar .logo-mark span { color: var(--gold); }
        #sidebar .logo-sub { font-size: 0.65rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--slate-400); margin-top: 3px; }

        #sidebar nav { padding: 20px 12px; flex: 1; overflow-y: auto; }
        #sidebar nav .nav-section-label { font-size: 0.6rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--slate-400); padding: 14px 12px 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 10px;
            color: rgba(255,255,255,0.55); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; transition: all 0.2s ease; margin-bottom: 2px;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-item.active { background: linear-gradient(135deg, rgba(201,168,76,0.22) 0%, rgba(201,168,76,0.08) 100%); color: #e8cc7e; }
        .nav-item .nav-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); }
        .nav-badge { margin-left: auto; background: var(--rose); color: #fff; font-size: 0.6rem; font-weight: 700; padding: 1px 6px; border-radius: 20px; }

        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; gap: 12px; }
        .sidebar-footer .avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), #e8cc7e); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--navy); }
        .sidebar-footer .user-name { font-size: 0.8rem; color: #fff; font-weight: 500; }
        .sidebar-footer .user-role { font-size: 0.65rem; color: var(--slate-400); }

        /* Main Layout */
        #main-wrap { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }

        /* Top Navbar */
        #topnav {
            position: sticky; top: 0; z-index: 40; background: rgba(241,245,249,0.85);
            backdrop-filter: blur(12px); border-bottom: 1px solid rgba(15,23,42,0.07);
            padding: 0 32px; height: 68px; display: flex; align-items: center; gap: 16px;
        }
        .breadcrumb { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--navy); font-weight: 600; }
        .breadcrumb-sub { font-size: 0.78rem; color: var(--slate-400); }
        .search-wrap { flex: 1; max-width: 380px; margin-left: auto; position: relative; }
        .search-wrap input { width: 100%; padding: 9px 16px 9px 40px; background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; }
        .search-wrap .search-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--slate-400); }
        .topnav-actions { display: flex; align-items: center; gap: 10px; }
        .icon-btn { width: 40px; height: 40px; border-radius: 10px; background: #fff; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .user-pill { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 6px 14px 6px 8px; cursor: pointer; }
        .user-pill .avatar { width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg, var(--gold), #e8cc7e); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--navy); }
        .user-pill .name { font-size: 0.8rem; font-weight: 600; color: var(--navy); }
        .user-pill .role { font-size: 0.65rem; color: var(--slate-400); }

        #page-content { padding: 28px 32px 48px; flex: 1; }

        /* Cards & Tables */
        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: #fff; border-radius: 16px; padding: 22px 24px; box-shadow: 0 2px 12px rgba(15,23,42,0.06); }
        .stat-card.navy-accent::before { background: var(--navy); }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .stat-icon.navy { background: rgba(15,23,42,0.08); color: var(--navy); }
        .stat-icon.gold { background: rgba(201,168,76,0.12); color: #a07a2a; }
        .stat-icon.emerald { background: rgba(16,185,129,0.1); color: var(--emerald); }
        .stat-icon.rose { background: rgba(244,63,94,0.1); color: var(--rose); }
        .stat-label { font-size: 0.72rem; font-weight: 500; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--navy); }
        .stat-trend { display: inline-flex; align-items: center; gap: 4px; font-size: 0.72rem; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
        .stat-trend.up { background: rgba(16,185,129,0.1); color: var(--emerald); }
        .stat-trend.down { background: rgba(244,63,94,0.1); color: var(--rose); }

        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; color: var(--navy); }
        .section-action { font-size: 0.78rem; color: var(--gold); font-weight: 600; padding: 6px 14px; border: 1px solid rgba(201,168,76,0.3); border-radius: 8px; text-decoration: none; }

        .kanban-scroll { overflow-x: auto; padding-bottom: 12px; }
        .kanban-board { display: flex; gap: 16px; min-width: max-content; }
        .kanban-col { width: 220px; background: rgba(15,23,42,0.03); border-radius: 14px; padding: 14px; flex-shrink: 0; }
        .kanban-card { background: #fff; border-radius: 10px; padding: 14px; margin-bottom: 10px; box-shadow: 0 1px 8px rgba(15,23,42,0.06); }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .dot-amber { background: var(--amber); } .dot-blue { background: #3b82f6; }
        .dot-indigo { background: #6366f1; } .dot-orange { background: #f97316; }
        .dot-emerald { background: var(--emerald); } .dot-teal { background: #14b8a6; }

        .charts-grid { display: grid; grid-template-columns: 3fr 2fr; gap: 20px; margin-bottom: 28px; }
        .chart-card { background: #fff; border-radius: 16px; padding: 24px; }

        .data-table-wrap { background: #fff; border-radius: 16px; overflow: hidden; margin-bottom: 28px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; padding: 14px 16px; background: #fafbfc; }
        .data-table tbody td { padding: 14px 16px; font-size: 0.83rem; border-bottom: 1px solid #f1f5f9; }
        .badge { display: inline-flex; padding: 4px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; }
        .badge-pending { background: rgba(245,158,11,0.1); color: #b45309; }
        .badge-production { background: rgba(99,102,241,0.1); color: #4338ca; }
        .badge-ready { background: rgba(16,185,129,0.1); color: #047857; }
        .badge-delivered { background: rgba(15,23,42,0.07); color: #475569; }
        .btn-view, .btn-edit { padding: 5px 12px; border-radius: 7px; font-size: 0.72rem; font-weight: 600; cursor: pointer; border: none; }
        .btn-view { background: rgba(15,23,42,0.06); }
        .btn-edit { background: rgba(201,168,76,0.12); color: #92650a; }

        .alerts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .alert-card { background: #fff; border-radius: 14px; padding: 20px; border-left: 4px solid; }
        .alert-card.warning { border-left-color: var(--amber); }
        .alert-card.danger { border-left-color: var(--rose); }

        @media (max-width: 1024px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-wrap { margin-left: 0; }
        }
        @media (max-width: 768px) {
            .summary-grid { grid-template-columns: 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
            .alerts-grid { grid-template-columns: 1fr; }
        }
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.5); z-index: 45; }
        #sidebar-overlay.open { display: block; }
        .fade-up { animation: fadeUp 0.5s ease both; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.05s; } .delay-2 { animation-delay: 0.10s; }
        .delay-3 { animation-delay: 0.15s; } .delay-4 { animation-delay: 0.20s; }
        .delay-5 { animation-delay: 0.25s; } .delay-6 { animation-delay: 0.30s; }
    </style>
    @stack('styles')
</head>
<body>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- SIDEBAR --}}
<aside id="sidebar">
    <div class="logo-wrap">
        <div class="logo-mark">Furniture<span>Flow</span></div>
        <div class="logo-sub">Warehouse Management</div>
    </div>
    <nav>
        <div class="nav-section-label">Main Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-chart-pie"></i></div> Dashboard
        </a>
        <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-box-open"></i></div> Orders
            <span class="nav-badge">{{ \App\Models\Order::count() }}</span>
        </a>
        <a href="{{ route('admin.customers') }}" class="nav-item {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-users"></i></div> Customers
        </a>
        <a href="{{ route('admin.carpenters') }}" class="nav-item {{ request()->routeIs('admin.carpenters') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-hammer"></i></div> Carpenters
        </a>
        <a href="{{ route('admin.inventory') }}" class="nav-item {{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-warehouse"></i></div> Inventory
        </a>
        <div class="nav-section-label" style="margin-top:8px;">Finance</div>
        <a href="{{ route('admin.payments') }}" class="nav-item {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fa-solid fa-credit-card"></i></div> Payments
        </a>
     <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
    <div class="nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
          Reports
    </a>
        <div class="nav-section-label" style="margin-top:8px;">System</div>
        <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
    <div class="nav-icon"><i class="fa-solid fa-gear"></i></div>
    Settings
</a>
    </nav>
    <div class="sidebar-footer">
        <div class="avatar">{{ $userInitials ?? 'AD' }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="user-role">{{ $userRole ?? 'Admin' }}</div>
        </div>
    </div>
</aside>

{{-- MAIN WRAPPER --}}
<div id="main-wrap">
    <header id="topnav">
        <button onclick="toggleSidebar()" class="icon-btn lg:hidden mr-2" style="display:none;" id="hamburger-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div>
            <div class="breadcrumb">@yield('title', 'Dashboard')</div>
            <div class="breadcrumb-sub">{{ $currentDate ?? date('l, j F Y') }}</div>
        </div>
        <div class="search-wrap">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search orders, customers, inventory…">
        </div>
        <div class="topnav-actions">
            <button class="icon-btn"><i class="fa-solid fa-bell"></i></button>
            <button class="icon-btn"><i class="fa-solid fa-circle-question"></i></button>
            <div class="user-pill">
                <div class="avatar">{{ $userInitials ?? 'AD' }}</div>
                <div>
                    <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="role">{{ $userRole ?? 'Admin' }}</div>
                </div>
                <i class="fa-solid fa-chevron-down chevron"></i>
            </div>
        </div>
    </header>

    <main id="page-content">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('open');
}
(function() {
    const btn = document.getElementById('hamburger-btn');
    if (window.innerWidth <= 1024) btn.style.display = 'flex';
    window.addEventListener('resize', () => {
        btn.style.display = window.innerWidth <= 1024 ? 'flex' : 'none';
    });
})();
</script>
@stack('scripts')
</body>
</html>