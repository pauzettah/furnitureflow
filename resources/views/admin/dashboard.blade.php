<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurnitureFlow — Warehouse Dashboard</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN (replace with compiled asset in production) --}}
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
                    boxShadow: {
                        'card':  '0 2px 16px 0 rgba(15,23,42,0.08)',
                        'card-hover': '0 8px 32px 0 rgba(15,23,42,0.14)',
                        'sidebar': '4px 0 24px 0 rgba(15,23,42,0.10)',
                    },
                    backdropBlur: { xs: '2px' },
                }
            }
        }
    </script>

    <style>
        :root {
            --navy:       #0f172a;
            --navy-800:   #1e293b;
            --navy-700:   #253447;
            --gold:       #c9a84c;
            --gold-light: #e8cc7e;
            --emerald:    #10b981;
            --rose:       #f43f5e;
            --amber:      #f59e0b;
            --slate-400:  #94a3b8;
            --slate-100:  #f1f5f9;
            --white:      #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ─── Sidebar ─────────────────────────────────────────── */
        #sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background: var(--navy);
            box-shadow: 4px 0 32px rgba(15,23,42,0.18);
            display: flex; flex-direction: column;
            z-index: 50;
            transition: transform 0.35s cubic-bezier(.77,0,.175,1);
        }
        #sidebar .logo-wrap {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        #sidebar .logo-mark {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #fff;
            line-height: 1;
        }
        #sidebar .logo-mark span { color: var(--gold); }
        #sidebar .logo-sub {
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--slate-400);
            margin-top: 3px;
        }

        /* Nav */
        #sidebar nav { padding: 20px 12px; flex: 1; overflow-y: auto; }
        #sidebar nav .nav-section-label {
            font-size: 0.6rem; letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--slate-400); padding: 14px 12px 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 10px;
            color: rgba(255,255,255,0.55);
            font-size: 0.875rem; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(201,168,76,0.22) 0%, rgba(201,168,76,0.08) 100%);
            color: var(--gold-light);
            border: 1px solid rgba(201,168,76,0.2);
        }
        .nav-item .nav-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; flex-shrink: 0;
            background: rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .nav-item.active .nav-icon { background: rgba(201,168,76,0.18); }
        .nav-item:hover .nav-icon { background: rgba(255,255,255,0.1); }
        .nav-badge {
            margin-left: auto; background: var(--rose);
            color: #fff; font-size: 0.6rem; font-weight: 700;
            padding: 1px 6px; border-radius: 20px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-footer .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700; color: var(--navy); flex-shrink: 0;
        }
        .sidebar-footer .user-name { font-size: 0.8rem; color: #fff; font-weight: 500; }
        .sidebar-footer .user-role { font-size: 0.65rem; color: var(--slate-400); }

        /* ─── Main Layout ─────────────────────────────────────── */
        #main-wrap { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }

        /* ─── Top Navbar ──────────────────────────────────────── */
        #topnav {
            position: sticky; top: 0; z-index: 40;
            background: rgba(241,245,249,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(15,23,42,0.07);
            padding: 0 32px;
            height: 68px;
            display: flex; align-items: center; gap: 16px;
        }
        .breadcrumb { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--navy); font-weight: 600; }
        .breadcrumb-sub { font-size: 0.78rem; color: var(--slate-400); font-weight: 400; font-family: 'DM Sans', sans-serif; }

        .search-wrap {
            flex: 1; max-width: 380px; margin-left: auto;
            position: relative;
        }
        .search-wrap input {
            width: 100%; padding: 9px 16px 9px 40px;
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 10px; font-size: 0.85rem;
            color: var(--navy); outline: none;
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .search-wrap input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.12); }
        .search-wrap .search-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: var(--slate-400); font-size: 0.8rem;
        }

        .topnav-actions { display: flex; align-items: center; gap: 10px; }
        .icon-btn {
            width: 40px; height: 40px; border-radius: 10px; background: #fff;
            border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.9rem; color: #64748b;
            transition: all 0.2s; position: relative;
        }
        .icon-btn:hover { border-color: var(--gold); color: var(--gold); }
        .notif-dot {
            position: absolute; top: 8px; right: 9px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--rose); border: 2px solid var(--slate-100);
        }

        .user-pill {
            display: flex; align-items: center; gap: 10px;
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 6px 14px 6px 8px;
            cursor: pointer; transition: all 0.2s;
        }
        .user-pill:hover { border-color: var(--gold); }
        .user-pill .avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; color: var(--navy);
        }
        .user-pill .name { font-size: 0.8rem; font-weight: 600; color: var(--navy); }
        .user-pill .role { font-size: 0.65rem; color: var(--slate-400); }
        .user-pill .chevron { font-size: 0.65rem; color: var(--slate-400); margin-left: 4px; }

        /* ─── Page Content ────────────────────────────────────── */
        #page-content { padding: 28px 32px 48px; flex: 1; }

        /* ─── Summary Cards ───────────────────────────────────── */
        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 2px 12px rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.05);
            position: relative; overflow: hidden;
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            cursor: default;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; right: 0;
            width: 90px; height: 90px; border-radius: 50%;
            opacity: 0.08; transform: translate(30px, -30px);
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 32px rgba(15,23,42,0.12); }

        .stat-card.navy-accent::before { background: var(--navy); }
        .stat-card.gold-accent::before  { background: var(--gold); }
        .stat-card.emerald-accent::before { background: var(--emerald); }
        .stat-card.rose-accent::before  { background: var(--rose); }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; margin-bottom: 16px;
        }
        .stat-icon.navy  { background: rgba(15,23,42,0.08); color: var(--navy); }
        .stat-icon.gold  { background: rgba(201,168,76,0.12); color: var(--gold-dark, #a07a2a); }
        .stat-icon.emerald { background: rgba(16,185,129,0.1); color: var(--emerald); }
        .stat-icon.rose  { background: rgba(244,63,94,0.1); color: var(--rose); }

        .stat-label { font-size: 0.72rem; font-weight: 500; color: #94a3b8; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 6px; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--navy); line-height: 1; margin-bottom: 10px; }
        .stat-trend {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 0.72rem; font-weight: 600; padding: 3px 8px; border-radius: 20px;
        }
        .stat-trend.up   { background: rgba(16,185,129,0.1); color: var(--emerald); }
        .stat-trend.down { background: rgba(244,63,94,0.1);  color: var(--rose); }
        .stat-period { font-size: 0.68rem; color: #94a3b8; margin-left: 6px; }

        /* ─── Section Headers ─────────────────────────────────── */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; color: var(--navy); }
        .section-sub { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }
        .section-action {
            font-size: 0.78rem; color: var(--gold); font-weight: 600;
            cursor: pointer; text-decoration: none;
            padding: 6px 14px; border: 1px solid rgba(201,168,76,0.3);
            border-radius: 8px; transition: all 0.2s;
        }
        .section-action:hover { background: rgba(201,168,76,0.08); }

        /* ─── Kanban Board ────────────────────────────────────── */
        .kanban-scroll { overflow-x: auto; padding-bottom: 12px; }
        .kanban-board { display: flex; gap: 16px; min-width: max-content; }

        .kanban-col {
            width: 220px; background: rgba(15,23,42,0.03);
            border: 1px solid rgba(15,23,42,0.06);
            border-radius: 14px; padding: 14px;
            flex-shrink: 0;
        }
        .kanban-col-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }
        .kanban-col-title { font-size: 0.78rem; font-weight: 700; color: var(--navy); letter-spacing: 0.04em; text-transform: uppercase; }
        .kanban-count {
            width: 20px; height: 20px; border-radius: 6px;
            background: var(--navy); color: #fff;
            font-size: 0.65rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }

        .kanban-card {
            background: #fff; border-radius: 10px; padding: 14px;
            box-shadow: 0 1px 8px rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.05);
            margin-bottom: 10px; cursor: pointer;
            transition: all 0.22s ease;
        }
        .kanban-card:last-child { margin-bottom: 0; }
        .kanban-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,23,42,0.12); }

        .kanban-card-id { font-size: 0.62rem; color: #94a3b8; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.06em; }
        .kanban-card-name { font-size: 0.82rem; font-weight: 700; color: var(--navy); margin-bottom: 3px; }
        .kanban-card-type { font-size: 0.72rem; color: #64748b; margin-bottom: 10px; }
        .kanban-card-footer { display: flex; align-items: center; justify-content: space-between; }
        .kanban-deadline { font-size: 0.65rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .dot-amber   { background: var(--amber); }
        .dot-blue    { background: #3b82f6; }
        .dot-indigo  { background: #6366f1; }
        .dot-orange  { background: #f97316; }
        .dot-emerald { background: var(--emerald); }
        .dot-teal    { background: #14b8a6; }

        /* ─── Charts ──────────────────────────────────────────── */
        .charts-grid { display: grid; grid-template-columns: 3fr 2fr; gap: 20px; margin-bottom: 28px; }
        .chart-card {
            background: #fff; border-radius: 16px; padding: 24px;
            box-shadow: 0 2px 12px rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.05);
        }
        .chart-legend { display: flex; gap: 16px; margin-top: 6px; }
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: 0.72rem; color: #64748b; }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; }

        /* ─── Table ───────────────────────────────────────────── */
        .data-table-wrap {
            background: #fff; border-radius: 16px;
            box-shadow: 0 2px 12px rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.05);
            overflow: hidden; margin-bottom: 28px;
        }
        .data-table-header { padding: 22px 24px 0; border-bottom: 1px solid #f1f5f9; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: #94a3b8;
            padding: 14px 16px; text-align: left;
            background: #fafbfc; border-bottom: 1px solid #f1f5f9;
        }
        .data-table tbody tr { transition: background 0.15s; }
        .data-table tbody tr:hover { background: #fafbfc; }
        .data-table tbody td { padding: 14px 16px; font-size: 0.83rem; color: #1e293b; border-bottom: 1px solid #f1f5f9; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        .order-id { font-weight: 700; color: var(--navy); font-size: 0.82rem; }
        .customer-cell { display: flex; align-items: center; gap: 10px; }
        .customer-avatar {
            width: 30px; height: 30px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; flex-shrink: 0;
        }
        .customer-name { font-size: 0.83rem; font-weight: 600; color: var(--navy); }
        .customer-email { font-size: 0.68rem; color: #94a3b8; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700;
        }
        .badge-pending    { background: rgba(245,158,11,0.1);  color: #b45309; }
        .badge-production { background: rgba(99,102,241,0.1);  color: #4338ca; }
        .badge-ready      { background: rgba(16,185,129,0.1);  color: #047857; }
        .badge-delivered  { background: rgba(15,23,42,0.07);   color: #475569; }
        .badge-quality    { background: rgba(249,115,22,0.1);  color: #c2410c; }
        .badge-materials  { background: rgba(59,130,246,0.1);  color: #1d4ed8; }

        .amount-cell { font-weight: 700; color: var(--navy); }
        .balance-positive { color: var(--emerald); font-weight: 600; }
        .balance-zero     { color: #94a3b8; font-weight: 500; }
        .deadline-cell { font-size: 0.78rem; color: #64748b; }
        .deadline-overdue { color: var(--rose); font-weight: 600; }

        .action-btns { display: flex; gap: 6px; }
        .btn-view, .btn-edit {
            padding: 5px 12px; border-radius: 7px; font-size: 0.72rem; font-weight: 600;
            cursor: pointer; border: none; transition: all 0.18s; font-family: 'DM Sans', sans-serif;
        }
        .btn-view { background: rgba(15,23,42,0.06); color: var(--navy); }
        .btn-view:hover { background: var(--navy); color: #fff; }
        .btn-edit { background: rgba(201,168,76,0.12); color: #92650a; }
        .btn-edit:hover { background: var(--gold); color: #fff; }

        /* ─── Alerts ──────────────────────────────────────────── */
        .alerts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .alert-card {
            background: #fff; border-radius: 14px; padding: 20px;
            box-shadow: 0 2px 12px rgba(15,23,42,0.06);
            border: 1px solid rgba(15,23,42,0.05);
            border-left: 4px solid;
        }
        .alert-card.warning  { border-left-color: var(--amber); }
        .alert-card.danger   { border-left-color: var(--rose); }
        .alert-header { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .alert-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0; }
        .alert-icon.warning { background: rgba(245,158,11,0.1); color: var(--amber); }
        .alert-icon.danger  { background: rgba(244,63,94,0.1); color: var(--rose); }
        .alert-title { font-size: 0.88rem; font-weight: 700; color: var(--navy); }
        .alert-sub   { font-size: 0.68rem; color: #94a3b8; margin-top: 1px; }
        .alert-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.78rem;
        }
        .alert-item:last-child { border-bottom: none; padding-bottom: 0; }
        .alert-item-label { color: #334155; font-weight: 500; }
        .alert-item-value { font-weight: 700; }
        .alert-item-value.danger  { color: var(--rose); }
        .alert-item-value.warning { color: var(--amber); }

        /* ─── Responsive ──────────────────────────────────────── */
        @media (max-width: 1280px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            .charts-grid  { grid-template-columns: 1fr; }
        }
        @media (max-width: 1024px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-wrap { margin-left: 0; }
            #topnav { padding: 0 20px; }
            #page-content { padding: 20px; }
        }
        @media (max-width: 768px) {
            .summary-grid { grid-template-columns: 1fr; }
            .alerts-grid  { grid-template-columns: 1fr; }
            .search-wrap  { display: none; }
            .stat-value   { font-size: 1.6rem; }
        }

        /* ─── Mobile overlay ──────────────────────────────────── */
        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.5); z-index: 45;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.open { display: block; }

        /* ─── Scrollbar ───────────────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ─── Animations ──────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.10s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.20s; }
        .delay-5 { animation-delay: 0.25s; }
        .delay-6 { animation-delay: 0.30s; }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  SIDEBAR OVERLAY (mobile)                                    --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  SIDEBAR                                                     --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<aside id="sidebar">
    {{-- Logo --}}
    <div class="logo-wrap">
        <div class="logo-mark">Furniture<span>Flow</span></div>
        <div class="logo-sub">Warehouse Management</div>
    </div>

    {{-- Navigation --}}
    <nav>
        <div class="nav-section-label">Main Menu</div>

        <a href="#" class="nav-item active">
            <div class="nav-icon"><i class="fa-solid fa-chart-pie"></i></div>
            Dashboard
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-box-open"></i></div>
            Orders
            <span class="nav-badge">12</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-users"></i></div>
            Customers
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-hammer"></i></div>
            Carpenters
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-warehouse"></i></div>
            Inventory
            <span class="nav-badge">3</span>
        </a>

        <div class="nav-section-label" style="margin-top:8px;">Finance</div>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-credit-card"></i></div>
            Payments
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-chart-bar"></i></div>
            Reports
        </a>

        <div class="nav-section-label" style="margin-top:8px;">System</div>
        <a href="#" class="nav-item">
            <div class="nav-icon"><i class="fa-solid fa-gear"></i></div>
            Settings
        </a>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <div class="avatar">JM</div>
        <div>
            <div class="user-name">James Mwangi</div>
            <div class="user-role">Super Admin</div>
        </div>
        <i class="fa-solid fa-ellipsis-vertical" style="color:#4b5563; margin-left:auto; cursor:pointer;"></i>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  MAIN WRAPPER                                                --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div id="main-wrap">

    {{-- ─────────────────────────────────────────────────────── --}}
    {{--  TOP NAVBAR                                              --}}
    {{-- ─────────────────────────────────────────────────────── --}}
    <header id="topnav">
        {{-- Hamburger (mobile) --}}
        <button onclick="toggleSidebar()" class="icon-btn lg:hidden mr-2" style="display:none; border:none;" id="hamburger-btn">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div>
            <div class="breadcrumb">Dashboard</div>
            <div class="breadcrumb-sub">Wednesday, 8 April 2026</div>
        </div>

        {{-- Search --}}
        <div class="search-wrap">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search orders, customers, inventory…">
        </div>

        {{-- Actions --}}
        <div class="topnav-actions">
            <button class="icon-btn">
                <i class="fa-solid fa-bell"></i>
                <span class="notif-dot"></span>
            </button>
            <button class="icon-btn">
                <i class="fa-solid fa-circle-question"></i>
            </button>
            <div class="user-pill">
                <div class="avatar">JM</div>
                <div>
                    <div class="name">James Mwangi</div>
                    <div class="role">Super Admin</div>
                </div>
                <i class="fa-solid fa-chevron-down chevron"></i>
            </div>
        </div>
    </header>

    {{-- ─────────────────────────────────────────────────────── --}}
    {{--  PAGE CONTENT                                            --}}
    {{-- ─────────────────────────────────────────────────────── --}}
    <main id="page-content">

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- A. SUMMARY CARDS                                   --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @php
            $stats = [
                [
                    'label'   => 'Total Orders',
                    'value'   => '348',
                    'trend'   => '+14%',
                    'dir'     => 'up',
                    'period'  => 'vs last month',
                    'icon'    => 'fa-box-open',
                    'color'   => 'navy',
                    'accent'  => 'navy-accent',
                ],
                [
                    'label'   => 'In Production',
                    'value'   => '47',
                    'trend'   => '+6%',
                    'dir'     => 'up',
                    'period'  => 'vs last week',
                    'icon'    => 'fa-hammer',
                    'color'   => 'gold',
                    'accent'  => 'gold-accent',
                ],
                [
                    'label'   => 'Pending Delivery',
                    'value'   => '29',
                    'trend'   => '-3%',
                    'dir'     => 'down',
                    'period'  => 'vs last week',
                    'icon'    => 'fa-truck',
                    'color'   => 'emerald',
                    'accent'  => 'emerald-accent',
                ],
                [
                    'label'   => 'Total Revenue',
                    'value'   => 'KES 4.2M',
                    'trend'   => '+22%',
                    'dir'     => 'up',
                    'period'  => 'vs last month',
                    'icon'    => 'fa-coins',
                    'color'   => 'rose',
                    'accent'  => 'rose-accent',
                ],
            ];
        @endphp

        <div class="summary-grid">
            @foreach($stats as $i => $s)
            <div class="stat-card {{ $s['accent'] }} fade-up delay-{{ $i + 1 }}">
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

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- B. KANBAN BOARD                                    --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @php
            $kanban = [
                'Pending' => [
                    'dot' => 'dot-amber',
                    'cards' => [
                        ['id'=>'#FF-1042','name'=>'Alice Kamau','type'=>'3-Seater Sofa','deadline'=>'Apr 15'],
                        ['id'=>'#FF-1043','name'=>'Brian Odhiambo','type'=>'Dining Table × 6','deadline'=>'Apr 18'],
                    ]
                ],
                'Materials Ordered' => [
                    'dot' => 'dot-blue',
                    'cards' => [
                        ['id'=>'#FF-1038','name'=>'Carol Njeri','type'=>'King Bed Frame','deadline'=>'Apr 12'],
                        ['id'=>'#FF-1039','name'=>'David Otieno','type'=>'Wardrobe (3-door)','deadline'=>'Apr 19'],
                    ]
                ],
                'In Production' => [
                    'dot' => 'dot-indigo',
                    'cards' => [
                        ['id'=>'#FF-1031','name'=>'Esther Wanjiku','type'=>'Office Desk Set','deadline'=>'Apr 10'],
                        ['id'=>'#FF-1033','name'=>'Felix Mutua','type'=>'Bookshelf × 2','deadline'=>'Apr 11'],
                        ['id'=>'#FF-1035','name'=>'Grace Achieng','type'=>'TV Cabinet','deadline'=>'Apr 14'],
                    ]
                ],
                'Quality Check' => [
                    'dot' => 'dot-orange',
                    'cards' => [
                        ['id'=>'#FF-1028','name'=>'Henry Kamau','type'=>'L-Shaped Sofa','deadline'=>'Apr 9'],
                    ]
                ],
                'Ready' => [
                    'dot' => 'dot-emerald',
                    'cards' => [
                        ['id'=>'#FF-1025','name'=>'Irene Chebet','type'=>'Dresser + Mirror','deadline'=>'Apr 9'],
                        ['id'=>'#FF-1026','name'=>'John Mwenda','type'=>'Coffee Table Set','deadline'=>'Apr 10'],
                    ]
                ],
                'Delivered' => [
                    'dot' => 'dot-teal',
                    'cards' => [
                        ['id'=>'#FF-1020','name'=>'Karen Omondi','type'=>'Bunk Beds × 2','deadline'=>'Apr 5'],
                        ['id'=>'#FF-1021','name'=>'Liam Waweru','type'=>'Study Chair Set','deadline'=>'Apr 6'],
                    ]
                ],
            ];
        @endphp

        <div class="fade-up delay-5" style="margin-bottom: 28px;">
            <div class="section-header">
                <div>
                    <div class="section-title">Orders Workflow</div>
                    <div class="section-sub">Drag cards across columns to update status</div>
                </div>
                <a href="#" class="section-action"><i class="fa-solid fa-plus" style="margin-right:5px;"></i>New Order</a>
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
                        @foreach($data['cards'] as $card)
                        <div class="kanban-card">
                            <div class="kanban-card-id">{{ $card['id'] }}</div>
                            <div class="kanban-card-name">{{ $card['name'] }}</div>
                            <div class="kanban-card-type">{{ $card['type'] }}</div>
                            <div class="kanban-card-footer">
                                <span class="kanban-deadline">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $card['deadline'] }}
                                </span>
                                <span class="status-dot {{ $data['dot'] }}"></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- C. CHARTS                                          --}}
        {{-- ══════════════════════════════════════════════════ --}}
        <div class="charts-grid fade-up delay-6" style="margin-bottom:28px;">
            {{-- Line Chart: Revenue --}}
            <div class="chart-card">
                <div class="section-header" style="margin-bottom:6px;">
                    <div>
                        <div class="section-title" style="font-size:1rem;">Revenue Over Time</div>
                        <div class="section-sub">Monthly revenue for FY 2025–26</div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item"><span class="legend-dot" style="background:#c9a84c;"></span>Revenue</div>
                        <div class="legend-item"><span class="legend-dot" style="background:#10b981;"></span>Target</div>
                    </div>
                </div>
                <canvas id="revenueChart" height="110"></canvas>
            </div>
            {{-- Bar Chart: Orders --}}
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

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- D. RECENT ORDERS TABLE                             --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @php
            $orders = [
                ['id'=>'#FF-1042','customer'=>'Alice Kamau','email'=>'alice@gmail.com','initials'=>'AK','color'=>'#6366f1','status'=>'Pending','badge'=>'badge-pending','amount'=>'KES 85,000','balance'=>'KES 42,500','deadline'=>'Apr 15, 2026','overdue'=>false],
                ['id'=>'#FF-1039','customer'=>'David Otieno','email'=>'david@ymail.com','initials'=>'DO','color'=>'#3b82f6','status'=>'Materials Ordered','badge'=>'badge-materials','amount'=>'KES 120,000','balance'=>'KES 0','deadline'=>'Apr 19, 2026','overdue'=>false],
                ['id'=>'#FF-1033','customer'=>'Felix Mutua','email'=>'felix@outlook.com','initials'=>'FM','color'=>'#10b981','status'=>'In Production','badge'=>'badge-production','amount'=>'KES 54,000','balance'=>'KES 27,000','deadline'=>'Apr 11, 2026','overdue'=>false],
                ['id'=>'#FF-1028','customer'=>'Henry Kamau','email'=>'henry@gmail.com','initials'=>'HK','color'=>'#f97316','status'=>'Quality Check','badge'=>'badge-quality','amount'=>'KES 210,000','balance'=>'KES 0','deadline'=>'Apr 9, 2026','overdue'=>true],
                ['id'=>'#FF-1026','customer'=>'John Mwenda','email'=>'john@gmail.com','initials'=>'JM','color'=>'#c9a84c','status'=>'Ready','badge'=>'badge-ready','amount'=>'KES 38,500','balance'=>'KES 38,500','deadline'=>'Apr 10, 2026','overdue'=>false],
                ['id'=>'#FF-1020','customer'=>'Karen Omondi','email'=>'karen@icloud.com','initials'=>'KO','color'=>'#64748b','status'=>'Delivered','badge'=>'badge-delivered','amount'=>'KES 95,000','balance'=>'KES 0','deadline'=>'Apr 5, 2026','overdue'=>false],
            ];
        @endphp

        <div class="data-table-wrap fade-up delay-6">
            <div class="data-table-header" style="padding-bottom: 20px;">
                <div class="section-header" style="margin-bottom:0;">
                    <div>
                        <div class="section-title" style="font-size:1rem;">Recent Orders</div>
                        <div class="section-sub">{{ count($orders) }} records shown</div>
                    </div>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <select style="padding:6px 12px;border-radius:8px;border:1px solid #e2e8f0;font-size:0.78rem;color:#64748b;font-family:'DM Sans',sans-serif;outline:none;">
                            <option>All Statuses</option>
                            <option>Pending</option>
                            <option>In Production</option>
                            <option>Ready</option>
                            <option>Delivered</option>
                        </select>
                        <a href="#" class="section-action"><i class="fa-solid fa-download" style="margin-right:5px;"></i>Export</a>
                    </div>
                </div>
            </div>
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                        <tr>
                            <td><span class="order-id">{{ $o['id'] }}</span></td>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar" style="background:{{ $o['color'] }}18;">
                                        <span style="color:{{ $o['color'] }};font-weight:700;">{{ $o['initials'] }}</span>
                                    </div>
                                    <div>
                                        <div class="customer-name">{{ $o['customer'] }}</div>
                                        <div class="customer-email">{{ $o['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $o['badge'] }}">
                                    <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                                    {{ $o['status'] }}
                                </span>
                            </td>
                            <td><span class="amount-cell">{{ $o['amount'] }}</span></td>
                            <td>
                                <span class="{{ $o['balance'] === 'KES 0' ? 'balance-zero' : 'balance-positive' }}">
                                    {{ $o['balance'] }}
                                </span>
                            </td>
                            <td>
                                <span class="deadline-cell {{ $o['overdue'] ? 'deadline-overdue' : '' }}">
                                    @if($o['overdue'])<i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>@endif
                                    {{ $o['deadline'] }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-view"><i class="fa-regular fa-eye" style="margin-right:4px;"></i>View</button>
                                    <button class="btn-edit"><i class="fa-regular fa-pen-to-square" style="margin-right:4px;"></i>Edit</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 24px;border-top:1px solid #f1f5f9;">
                <span style="font-size:0.75rem;color:#94a3b8;">Showing 1–6 of 348 orders</span>
                <div style="display:flex;gap:6px;">
                    <button style="padding:5px 11px;border-radius:7px;border:1px solid #e2e8f0;font-size:0.75rem;cursor:pointer;background:#fff;color:#64748b;font-family:'DM Sans',sans-serif;">← Prev</button>
                    <button style="padding:5px 11px;border-radius:7px;border:1px solid var(--gold);font-size:0.75rem;cursor:pointer;background:var(--gold);color:#fff;font-family:'DM Sans',sans-serif;">1</button>
                    <button style="padding:5px 11px;border-radius:7px;border:1px solid #e2e8f0;font-size:0.75rem;cursor:pointer;background:#fff;color:#64748b;font-family:'DM Sans',sans-serif;">2</button>
                    <button style="padding:5px 11px;border-radius:7px;border:1px solid #e2e8f0;font-size:0.75rem;cursor:pointer;background:#fff;color:#64748b;font-family:'DM Sans',sans-serif;">Next →</button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- E. ALERTS SECTION                                  --}}
        {{-- ══════════════════════════════════════════════════ --}}
        @php
            $lowStock = [
                ['item'=>'Mahogany Planks (4×8)',  'qty'=>'12 pcs',  'min'=>'50 pcs'],
                ['item'=>'Foam Padding (High Density)', 'qty'=>'8 rolls', 'min'=>'20 rolls'],
                ['item'=>'Teak Wood Stain (Brown)', 'qty'=>'5 liters','min'=>'15 liters'],
            ];
            $overdue = [
                ['id'=>'#FF-1028','customer'=>'Henry Kamau','days'=>'2 days overdue'],
                ['id'=>'#FF-1022','customer'=>'Paul Kariuki', 'days'=>'5 days overdue'],
                ['id'=>'#FF-1019','customer'=>'Sandra Atieno','days'=>'7 days overdue'],
            ];
        @endphp

        <div class="alerts-grid fade-up delay-6">
            {{-- Low Stock --}}
            <div class="alert-card warning">
                <div class="alert-header">
                    <div class="alert-icon warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div>
                        <div class="alert-title">Low Stock Warning</div>
                        <div class="alert-sub">{{ count($lowStock) }} materials below minimum threshold</div>
                    </div>
                </div>
                @foreach($lowStock as $item)
                <div class="alert-item">
                    <div>
                        <div class="alert-item-label">{{ $item['item'] }}</div>
                        <div style="font-size:0.65rem;color:#94a3b8;margin-top:2px;">Min: {{ $item['min'] }}</div>
                    </div>
                    <div class="alert-item-value warning">{{ $item['qty'] }}</div>
                </div>
                @endforeach
                <a href="#" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-size:0.75rem;font-weight:600;color:#b45309;text-decoration:none;">
                    <i class="fa-solid fa-arrow-right"></i> Order Materials
                </a>
            </div>

            {{-- Overdue Orders --}}
            <div class="alert-card danger">
                <div class="alert-header">
                    <div class="alert-icon danger"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="alert-title">Overdue Orders</div>
                        <div class="alert-sub">{{ count($overdue) }} orders past deadline</div>
                    </div>
                </div>
                @foreach($overdue as $od)
                <div class="alert-item">
                    <div>
                        <div class="alert-item-label">{{ $od['customer'] }}</div>
                        <div style="font-size:0.65rem;color:#94a3b8;margin-top:2px;">{{ $od['id'] }}</div>
                    </div>
                    <div class="alert-item-value danger">{{ $od['days'] }}</div>
                </div>
                @endforeach
                <a href="#" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;font-size:0.75rem;font-weight:600;color:#be123c;text-decoration:none;">
                    <i class="fa-solid fa-arrow-right"></i> View Overdue
                </a>
            </div>
        </div>

    </main>{{-- /page-content --}}
</div>{{-- /main-wrap --}}

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  SCRIPTS                                                     --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<script>
/* ── Mobile sidebar toggle ─────────────────────────────────── */
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('open');
}
/* Show hamburger on small screens */
(function() {
    const btn = document.getElementById('hamburger-btn');
    if (window.innerWidth <= 1024) btn.style.display = 'flex';
    window.addEventListener('resize', () => {
        btn.style.display = window.innerWidth <= 1024 ? 'flex' : 'none';
    });
})();

/* ── Chart.js defaults ─────────────────────────────────────── */
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.color = '#94a3b8';

/* ── Revenue Line Chart ────────────────────────────────────── */
const revCtx = document.getElementById('revenueChart').getContext('2d');
const revGradient = revCtx.createLinearGradient(0, 0, 0, 280);
revGradient.addColorStop(0,   'rgba(201,168,76,0.22)');
revGradient.addColorStop(1,   'rgba(201,168,76,0.00)');

const targetGrad = revCtx.createLinearGradient(0, 0, 0, 280);
targetGrad.addColorStop(0, 'rgba(16,185,129,0.10)');
targetGrad.addColorStop(1, 'rgba(16,185,129,0.00)');

new Chart(revCtx, {
    type: 'line',
    data: {
        labels: ['May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar','Apr'],
        datasets: [
            {
                label: 'Revenue (KES)',
                data: [1.8,2.1,1.9,2.4,2.8,3.0,3.2,2.9,3.5,3.8,4.0,4.2],
                borderColor: '#c9a84c',
                backgroundColor: revGradient,
                borderWidth: 2.5,
                pointRadius: 4, pointBackgroundColor: '#c9a84c', pointBorderColor: '#fff', pointBorderWidth: 2,
                tension: 0.45, fill: true,
            },
            {
                label: 'Target',
                data: [2.0,2.2,2.2,2.5,2.6,2.8,3.0,3.0,3.4,3.6,3.8,4.0],
                borderColor: '#10b981',
                backgroundColor: targetGrad,
                borderWidth: 2, borderDash: [5,4],
                pointRadius: 0, tension: 0.45, fill: true,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11 } } },
            y: {
                grid: { color: 'rgba(15,23,42,0.05)', drawBorder: false },
                border: { display: false },
                ticks: { callback: v => 'M' + v, font: { size: 11 } }
            }
        }
    }
});

/* ── Orders Bar Chart ──────────────────────────────────────── */
const ordCtx = document.getElementById('ordersChart').getContext('2d');
const barGrad = ordCtx.createLinearGradient(0, 0, 0, 260);
barGrad.addColorStop(0,   'rgba(201,168,76,0.90)');
barGrad.addColorStop(1,   'rgba(201,168,76,0.30)');

new Chart(ordCtx, {
    type: 'bar',
    data: {
        labels: ['May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar','Apr'],
        datasets: [{
            label: 'Orders',
            data: [22,28,25,32,38,41,44,36,47,51,54,48],
            backgroundColor: barGrad,
            borderRadius: 7, borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(15,23,42,0.05)' }, border: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>

</body>
</html>