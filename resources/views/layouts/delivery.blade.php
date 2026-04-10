<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'Delivery Dashboard') – FurnitureFlow</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:   { DEFAULT: '#0f172a', 800: '#1e293b', 700: '#334155', 600: '#475569' },
                        emerald: { DEFAULT: '#10b981', light: '#d1fae5', dark: '#065f46' },
                        gold:   { DEFAULT: '#f59e0b', light: '#fef3c7', dark: '#92400e' },
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        mono: ['Space Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { font-family: 'DM Sans', sans-serif; background: #f1f5f9; min-height: 100vh; overscroll-behavior: none; }
        .pulse-dot { animation: pulse-ring 1.8s ease-in-out infinite; }
        @keyframes pulse-ring { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        .card-enter { animation: slideUp 0.35s ease forwards; opacity: 0; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-backdrop { backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
        .otp-input { font-family: 'Space Mono', monospace; letter-spacing: 0.4em; text-align: center; }
        .upload-zone { border: 2px dashed #cbd5e1; transition: border-color 0.2s, background 0.2s; }
        .upload-zone.dragover, .upload-zone:hover { border-color: #10b981; background: #f0fdf4; }
        .btn-ripple { position: relative; overflow: hidden; }
        .btn-ripple::after { content: ''; position: absolute; inset: 0; background: rgba(255,255,255,0.2); opacity: 0; transition: opacity 0.3s; }
        .btn-ripple:active::after { opacity: 1; }
        .modal-panel { animation: modalIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes modalIn { from { transform: translateY(60px) scale(0.97); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }
        .card-enter:nth-child(1) { animation-delay: 0.05s; }
        .card-enter:nth-child(2) { animation-delay: 0.12s; }
        .card-enter:nth-child(3) { animation-delay: 0.19s; }
        .card-enter:nth-child(4) { animation-delay: 0.26s; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
        /* Desktop layout */
        .desktop-container { display: flex; min-height: 100vh; }
        .desktop-sidebar { width: 280px; background: #0f172a; position: fixed; left: 0; top: 0; bottom: 0; overflow-y: auto; }
        .desktop-main { margin-left: 280px; flex: 1; }
        .delivery-card { transition: transform 0.2s, box-shadow 0.2s; }
        .delivery-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        
        @media (max-width: 768px) {
            .desktop-sidebar { display: none; }
            .desktop-main { margin-left: 0; }
            .mobile-only { display: block; }
            .desktop-only { display: none; }
        }
        @media (min-width: 769px) {
            .mobile-only { display: none; }
            .desktop-only { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- DESKTOP LAYOUT -->
<div class="desktop-container desktop-only">
    <!-- Sidebar -->
    <aside class="desktop-sidebar">
        <div class="p-6 border-b border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald flex items-center justify-center">
                    <i data-lucide="truck" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest">FurnitureFlow</p>
                    <h2 class="text-white font-bold text-lg">Delivery Portal</h2>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-slate-800/50 rounded-xl">
                <div class="w-10 h-10 rounded-full bg-emerald flex items-center justify-center font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'JD', 0, 2)) }}
                </div>
                <div>
                    <p class="text-white text-sm font-semibold">{{ auth()->user()->name ?? 'Delivery Agent' }}</p>
                    <p class="text-slate-400 text-xs">{{ $agent['badge'] ?? 'AGT-001' }}</p>
                </div>
            </div>
        </div>
        <nav class="px-4 py-4 space-y-1">
            <a href="{{ route('delivery.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 rounded-lg transition {{ request()->routeIs('delivery.dashboard') ? 'bg-emerald text-white' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 rounded-lg transition">
                <i data-lucide="history" class="w-5 h-5"></i> Delivery History
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 rounded-lg transition">
                <i data-lucide="settings" class="w-5 h-5"></i> Settings
            </a>
        </nav>
        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 text-red-400 hover:bg-red-500/10 rounded-lg w-full transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Desktop -->
    <main class="desktop-main">
        <div class="p-8">
            @yield('desktop-content')
        </div>
    </main>
</div>

<!-- MOBILE LAYOUT -->
<div class="mobile-only">
    @yield('mobile-content')
</div>

<!-- Shared Modals -->
@include('delivery.partials.modals')

<script>
    lucide.createIcons();
    
    // Close modals on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                const modalId = this.id;
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>