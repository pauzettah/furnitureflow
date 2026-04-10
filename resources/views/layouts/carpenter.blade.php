<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Carpenter Dashboard') – FurnitureFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:    { DEFAULT:'#0f172a', light:'#1e293b', lighter:'#334155' },
                        emerald: { DEFAULT:'#10b981', light:'#34d399', dark:'#059669' },
                        gold:    { DEFAULT:'#f59e0b', light:'#fcd34d', dark:'#d97706' },
                    },
                    fontFamily: {
                        sans: ['DM Sans','sans-serif'],
                        mono: ['IBM Plex Mono','monospace'],
                    },
                    animation: {
                        'slide-up': 'slideUp 0.4s cubic-bezier(0.16,1,0.3,1) both',
                        'fade-in':  'fadeIn 0.25s ease both',
                        'pop':      'pop 0.22s cubic-bezier(0.34,1.56,0.64,1) both',
                    },
                    keyframes: {
                        slideUp: { from:{opacity:0,transform:'translateY(18px)'}, to:{opacity:1,transform:'translateY(0)'} },
                        fadeIn:  { from:{opacity:0}, to:{opacity:1} },
                        pop:     { from:{transform:'scale(0.9)',opacity:0}, to:{transform:'scale(1)',opacity:1} },
                    },
                }
            }
        }
    </script>
    <style>
        *{-webkit-tap-highlight-color:transparent;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:#f1f5f9;margin:0;}
        .task-card{transition:transform .2s ease,box-shadow .2s ease;}
        .task-card:hover{transform:translateY(-2px);box-shadow:0 14px 30px -8px rgba(15,23,42,.13);}
        .btn-ripple{position:relative;overflow:hidden;}
        .btn-ripple::after{content:'';position:absolute;inset:0;background:rgba(255,255,255,.22);opacity:0;transition:opacity .25s;}
        .btn-ripple:active::after{opacity:1;}
        .modal-backdrop{backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);}
        .no-scrollbar::-webkit-scrollbar{display:none;}
        .no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
        
        /* Responsive container - adapts to screen size */
        .app-container {
            max-width: 100%;
            margin: 0 auto;
            min-height: 100vh;
            background: #f1f5f9;
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {
            .app-container {
                max-width: 100%;
                padding: 0;
            }
            .task-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
                gap: 20px;
            }
            .main-content {
                padding: 20px 40px;
            }
            .bottom-nav {
                display: none;
            }
            .desktop-sidebar {
                display: block;
            }
            .mobile-header {
                display: none;
            }
            .desktop-header {
                display: block;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 30px;
            }
        }
        
        /* Tablet styles */
        @media (min-width: 640px) and (max-width: 767px) {
            .task-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
                gap: 16px;
            }
            .bottom-nav {
                display: flex;
            }
            .desktop-sidebar {
                display: none;
            }
            .desktop-header {
                display: none;
            }
            .mobile-header {
                display: block;
            }
        }
        
        /* Mobile styles */
        @media (max-width: 639px) {
            .task-grid {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }
            .bottom-nav {
                display: flex;
            }
            .desktop-sidebar {
                display: none;
            }
            .desktop-header {
                display: none;
            }
            .mobile-header {
                display: block;
            }
            .main-content {
                padding: 16px;
                padding-bottom: 80px;
            }
        }
        
        .chip-active{background:#0f172a!important;color:#fff!important;}
        
        /* Desktop sidebar styles */
        .desktop-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 260px;
            background: #0f172a;
            color: #fff;
            overflow-y: auto;
            z-index: 50;
        }
        .desktop-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #94a3b8;
            transition: all 0.2s;
            border-radius: 10px;
            margin: 4px 12px;
        }
        .desktop-sidebar .sidebar-link:hover {
            background: #1e293b;
            color: #fff;
        }
        .desktop-sidebar .sidebar-link.active {
            background: #10b981;
            color: #fff;
        }
        .desktop-sidebar .sidebar-link i {
            width: 20px;
        }
        .main-content-area {
            margin-left: 260px;
        }
        @media (max-width: 767px) {
            .main-content-area {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- DESKTOP LAYOUT (visible on large screens) -->
<div class="hidden md:flex">
    <!-- Desktop Sidebar -->
    <aside class="desktop-sidebar">
        <div class="p-5 border-b border-slate-800 mb-4">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[#10b981] flex items-center justify-center">
                    <i data-lucide="hammer" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest">FurnitureFlow</p>
                    <h2 class="text-white font-bold text-lg">Carpenter Portal</h2>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-slate-800/50 rounded-xl">
                <div class="w-10 h-10 rounded-full bg-[#10b981] flex items-center justify-center font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'JM', 0, 2)) }}
                </div>
                <div>
                    <p class="text-white text-sm font-semibold">{{ auth()->user()->name ?? 'Carpenter' }}</p>
                    <p class="text-slate-400 text-xs">Carpenter</p>
                </div>
            </div>
        </div>
        
        <nav class="px-2 space-y-1">
            <a href="{{ route('carpenter.dashboard') }}" class="sidebar-link {{ request()->routeIs('carpenter.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-list" class="w-5 h-5"></i> My Tasks
            </a>
            <a href="#" class="sidebar-link">
                <i data-lucide="bar-chart-2" class="w-5 h-5"></i> My Progress
            </a>
            <a href="#" class="sidebar-link">
                <i data-lucide="clock" class="w-5 h-5"></i> Completed
            </a>
            <a href="#" class="sidebar-link">
                <i data-lucide="settings" class="w-5 h-5"></i> Settings
            </a>
        </nav>
        
        <div class="absolute bottom-0 left-0 right-0 p-5 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-400 hover:bg-red-500/10 hover:text-red-300">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Desktop Main Content -->
    <main class="main-content-area flex-1 min-h-screen">
        <!-- Desktop Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
            <div class="px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">@yield('title', 'My Tasks')</h1>
                    <p class="text-slate-500 text-sm mt-1">Manage your assigned furniture tasks</p>
                </div>
                <div class="flex items-center gap-4">
                    <button onclick="showToast('No new notifications','info')" class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                        <i data-lucide="bell" class="w-5 h-5 text-slate-500"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-[#f59e0b] rounded-full"></span>
                    </button>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name ?? 'Carpenter' }}</p>
                            <p class="text-xs text-slate-400">Carpenter</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'JM', 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="p-8">
            @yield('content')
        </div>
    </main>
</div>

<!-- MOBILE LAYOUT (visible on small screens) -->
<div class="block md:hidden">
    <div class="app-container">
        <!-- Mobile Header -->
        <header class="sticky top-0 z-30 bg-[#0f172a] shadow-lg">
            <div class="px-4 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#10b981] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="hammer" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <p class="font-mono text-[10px] text-slate-400 uppercase tracking-widest leading-none">FurnitureFlow</p>
                        <h1 class="text-white font-bold text-base leading-tight">My Tasks Today</h1>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="showToast('No new notifications','info')" class="relative w-9 h-9 rounded-full bg-[#1e293b] flex items-center justify-center hover:bg-[#334155] transition-colors">
                        <i data-lucide="bell" class="w-[18px] h-[18px] text-slate-300"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#f59e0b] rounded-full"></span>
                    </button>
                    <div class="w-9 h-9 rounded-full bg-[#10b981] flex items-center justify-center font-bold text-white text-sm cursor-default" title="{{ auth()->user()->name ?? 'Carpenter' }}">
                        {{ strtoupper(substr(auth()->user()->name ?? 'JM', 0, 2)) }}
                    </div>
                </div>
            </div>
            <div class="px-4 pb-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-slate-400">Daily Progress</span>
                    <span class="font-mono text-xs text-[#10b981]">{{ $completedCount ?? 0 }}/{{ $totalCount ?? 0 }} done</span>
                </div>
                <div class="h-1.5 bg-[#334155] rounded-full overflow-hidden">
                    <div class="h-full bg-[#10b981] rounded-full transition-all duration-700" style="width: {{ $progressPercent ?? 0 }}%"></div>
                </div>
            </div>
        </header>

        <main class="px-4 pt-5 pb-28">
            @yield('mobile-content')
        </main>

        <!-- Mobile Bottom Nav -->
        <nav class="fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur-xl border-t border-slate-100">
            <div class="grid grid-cols-3 divide-x divide-slate-100 max-w-md mx-auto">
                <a href="{{ route('carpenter.dashboard') }}" class="flex flex-col items-center gap-1 py-3 text-xs font-semibold text-[#10b981] active:scale-95 transition-transform">
                    <i data-lucide="layout-list" class="w-5 h-5"></i>Tasks
                </a>
                <a href="#" class="flex flex-col items-center gap-1 py-3 text-xs font-medium text-slate-400 hover:text-[#0f172a] active:scale-95 transition-all">
                    <i data-lucide="bar-chart-2" class="w-5 h-5"></i>Progress
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center gap-1 py-3">
                    @csrf
                    <button type="submit" class="flex flex-col items-center gap-1 text-xs font-medium text-red-400 hover:text-red-600">
                        <i data-lucide="log-out" class="w-5 h-5"></i>Exit
                    </button>
                </form>
            </div>
        </nav>
    </div>
</div>

<!-- MODALS (shared between desktop and mobile) -->
<!-- Order Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 z-50 modal-backdrop bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-pop">
        <div class="sticky top-0 bg-white pt-4 pb-3 px-6 z-10 rounded-t-3xl border-b border-slate-100">
            <div class="flex items-start justify-between">
                <div>
                    <p id="detailOrderId" class="font-mono text-xs text-slate-400 mb-0.5"></p>
                    <h2 id="detailTitle" class="text-[#0f172a] font-bold text-xl"></h2>
                </div>
                <button onclick="closeModal('detailsModal')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition-colors">
                    <i data-lucide="x" class="w-4 h-4 text-slate-500"></i>
                </button>
            </div>
        </div>
        <div class="px-6 py-6 space-y-6">
            <div class="bg-slate-50 rounded-2xl p-5">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5"><i data-lucide="ruler" class="w-3.5 h-3.5"></i>Dimensions</p>
                <p id="detailDimensions" class="font-mono text-[#0f172a] font-bold text-xl"></p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5"><i data-lucide="package" class="w-3.5 h-3.5"></i>Materials Required</p>
                <ul id="detailMaterials" class="space-y-2"></ul>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-amber-500"></i>
                    <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Special Instructions</p>
                </div>
                <p id="detailInstructions" class="text-sm text-amber-800 leading-relaxed"></p>
            </div>
            <div id="detailImagesSection">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5"><i data-lucide="image" class="w-3.5 h-3.5"></i>Reference Images</p>
                <div id="detailImages" class="flex gap-3 overflow-x-auto no-scrollbar pb-2"></div>
            </div>
            <button id="detailMarkReadyBtn" class="btn-ripple w-full py-4 rounded-2xl bg-[#10b981] text-white font-bold text-base flex items-center justify-center gap-2 hover:bg-[#059669] transition-colors active:scale-95 shadow-lg">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>Mark as Ready for Quality Check
            </button>
            <button id="detailReportBtn" class="btn-ripple w-full py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 font-semibold text-sm flex items-center justify-center gap-2 hover:bg-amber-50 hover:border-amber-200 hover:text-amber-700 transition-all active:scale-95">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i>Report an Issue
            </button>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="hidden fixed inset-0 z-50 modal-backdrop bg-black/50 flex items-center justify-center p-5">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 animate-pop shadow-2xl">
        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i data-lucide="check-circle-2" class="w-7 h-7 text-[#10b981]"></i>
        </div>
        <h3 class="text-[#0f172a] font-bold text-lg text-center mb-1.5">Mark as Ready?</h3>
        <p id="confirmDesc" class="text-slate-500 text-sm text-center mb-6 leading-relaxed"></p>
        <div class="flex gap-3">
            <button onclick="closeModal('confirmModal')" class="flex-1 py-3 rounded-xl border-2 border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors active:scale-95">Cancel</button>
            <button onclick="submitReady()" class="btn-ripple flex-1 py-3 rounded-xl bg-[#10b981] text-white font-bold hover:bg-[#059669] transition-colors active:scale-95">Confirm ✓</button>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div id="reportModal" class="hidden fixed inset-0 z-50 modal-backdrop bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-pop">
        <div class="sticky top-0 bg-white pt-4 pb-3 px-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <p id="reportOrderId" class="font-mono text-xs text-slate-400"></p>
                        <h2 class="text-[#0f172a] font-bold text-lg">Report an Issue</h2>
                    </div>
                </div>
                <button onclick="closeModal('reportModal')" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition-colors">
                    <i data-lucide="x" class="w-4 h-4 text-slate-500"></i>
                </button>
            </div>
        </div>
        <div class="px-6 py-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Issue Type</label>
                <select id="issueType" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#0f172a] font-medium text-sm focus:outline-none focus:border-[#0f172a] focus:ring-2 focus:ring-[#0f172a]/10">
                    <option value="">— Select an issue —</option>
                    <option value="missing_materials">Missing Materials</option>
                    <option value="unclear_specs">Unclear Specifications</option>
                    <option value="damaged_materials">Damaged Materials</option>
                    <option value="incorrect_dimensions">Incorrect Dimensions</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Explanation</label>
                <textarea id="issueText" rows="4" placeholder="Describe the issue so the supervisor can act quickly..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#0f172a] placeholder-slate-400 focus:outline-none focus:border-[#0f172a] focus:ring-2 focus:ring-[#0f172a]/10 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Urgency Level</label>
                <div class="grid grid-cols-3 gap-3">
                    <label id="urg-low" class="urgency-btn flex items-center justify-center gap-1.5 py-3 rounded-xl cursor-pointer bg-slate-100 text-slate-600 text-sm font-semibold active:scale-95 transition-all">
                        <input type="radio" name="urgency" value="low" class="hidden">🟢 Low
                    </label>
                    <label id="urg-medium" class="urgency-btn flex items-center justify-center gap-1.5 py-3 rounded-xl cursor-pointer bg-amber-100 text-amber-700 text-sm font-semibold active:scale-95 transition-all">
                        <input type="radio" name="urgency" value="medium" class="hidden">🟡 Medium
                    </label>
                    <label id="urg-high" class="urgency-btn flex items-center justify-center gap-1.5 py-3 rounded-xl cursor-pointer bg-red-100 text-red-700 text-sm font-semibold active:scale-95 transition-all">
                        <input type="radio" name="urgency" value="high" class="hidden">🔴 High
                    </label>
                </div>
            </div>
            <button onclick="submitReport()" class="btn-ripple w-full py-4 rounded-2xl bg-[#0f172a] text-white font-bold text-base flex items-center justify-center gap-2 active:scale-95 hover:bg-[#1e293b] transition-colors">
                <i data-lucide="send" class="w-5 h-5"></i>Submit Report
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="hidden fixed top-4 left-1/2 -translate-x-1/2 z-[100] px-4">
    <div id="toastInner" class="flex items-center gap-3 p-4 rounded-2xl shadow-xl text-white text-sm font-medium animate-slide-up">
        <i id="toastIcon" data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
        <span id="toastMsg"></span>
    </div>
</div>

<script>
// ─── Task Data from Laravel ─────────────────────────────────────────────────
let tasks = @json($tasks ?? []);
let pendingReadyId = null, pendingReadyName = null, pendingReadyIndex = null;

lucide.createIcons();

// ─── Toast ────────────────────────────────────────────────────────────────────
let toastTimer;
function showToast(msg, type='success') {
    const map = {
        success:{ bg:'#10b981', icon:'check-circle' },
        error:  { bg:'#ef4444', icon:'x-circle' },
        warning:{ bg:'#f59e0b', icon:'alert-triangle' },
        info:   { bg:'#3b82f6', icon:'info' },
    };
    const s = map[type]||map.success;
    const inner=document.getElementById('toastInner');
    inner.style.background=s.bg;
    document.getElementById('toastIcon').setAttribute('data-lucide',s.icon);
    document.getElementById('toastMsg').textContent=msg;
    lucide.createIcons();
    const toast=document.getElementById('toast');
    toast.classList.remove('hidden');
    clearTimeout(toastTimer);
    toastTimer=setTimeout(()=>toast.classList.add('hidden'),3600);
}

// ─── Modals ───────────────────────────────────────────────────────────────────
function openModal(id){ document.getElementById(id).classList.remove('hidden'); document.body.style.overflow='hidden'; }
function closeModal(id){ document.getElementById(id).classList.add('hidden'); document.body.style.overflow=''; }
['detailsModal','confirmModal','reportModal'].forEach(id=>{
    const el = document.getElementById(id);
    if(el) {
        el.addEventListener('click',function(e){ if(e.target===this) closeModal(id); });
    }
});

// ─── Order Details ────────────────────────────────────────────────────────────
function openDetails(i) {
    const t = tasks[i];
    if(!t) return;
    document.getElementById('detailOrderId').textContent  = t.order_id;
    document.getElementById('detailTitle').textContent    = t.title;
    document.getElementById('detailDimensions').textContent = t.dimensions;
    document.getElementById('detailInstructions').textContent = t.instructions;

    document.getElementById('detailMaterials').innerHTML = t.materials.map(m=>`
        <li class="flex items-center gap-2 text-sm text-slate-700 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
            <span class="w-1.5 h-1.5 bg-[#0f172a] rounded-full flex-shrink-0"></span>${m}
        </li>`).join('');

    const imgEl=document.getElementById('detailImages');
    const imgSec=document.getElementById('detailImagesSection');
    if(t.images && t.images.length){
        imgEl.innerHTML=t.images.map(s=>`
            <img src="${s}" alt="Ref" class="w-28 h-20 object-cover rounded-xl border border-slate-200 flex-shrink-0 hover:scale-105 transition-transform" loading="lazy">`).join('');
        imgSec.classList.remove('hidden');
    } else { imgSec.classList.add('hidden'); }

    const btn=document.getElementById('detailMarkReadyBtn');
    const rBtn=document.getElementById('detailReportBtn');
    if(t.status==='ready'){
        btn.disabled=true;
        btn.innerHTML='<i data-lucide="badge-check" class="w-5 h-5"></i> Already Marked Ready';
        btn.style.background='#e2e8f0'; btn.style.color='#94a3b8'; btn.style.boxShadow='none';
        btn.onclick=null;
    } else {
        btn.disabled=false;
        btn.innerHTML='<i data-lucide="check-circle-2" class="w-5 h-5"></i> Mark as Ready for Quality Check';
        btn.style.background='#10b981'; btn.style.color='#fff'; btn.style.boxShadow='0 8px 20px -4px rgba(16,185,129,.4)';
        btn.onclick=()=>{ closeModal('detailsModal'); confirmReady(t.order_id,t.title,i); };
    }
    rBtn.onclick=()=>{ closeModal('detailsModal'); openReport(t.order_id); };
    lucide.createIcons();
    openModal('detailsModal');
}

// ─── Confirm Ready ────────────────────────────────────────────────────────────
function confirmReady(id,name,index) {
    pendingReadyId=id; pendingReadyName=name; pendingReadyIndex=index;
    document.getElementById('confirmDesc').textContent=
        `You are about to mark "${name}" (${id}) as ready for quality inspection. This action cannot be undone.`;
    openModal('confirmModal');
}
function submitReady() {
    closeModal('confirmModal');
    if(pendingReadyIndex!==null) {
        tasks[pendingReadyIndex].status='ready';
        showToast(`✅ ${pendingReadyName} marked ready for QC!`,'success');
        setTimeout(() => location.reload(), 1000);
    }
    pendingReadyId=pendingReadyName=pendingReadyIndex=null;
}

// ─── Report Issue ─────────────────────────────────────────────────────────────
function openReport(id) {
    document.getElementById('reportOrderId').textContent=id;
    document.getElementById('issueType').value='';
    document.getElementById('issueText').value='';
    document.querySelectorAll('.urgency-btn').forEach(b=>b.style.outline='none');
    openModal('reportModal');
}
function submitReport() {
    const type=document.getElementById('issueType').value;
    const text=document.getElementById('issueText').value.trim();
    if(!type){ showToast('Please select an issue type.','warning'); return; }
    if(!text){ showToast('Please describe the issue.','warning'); return; }
    closeModal('reportModal');
    showToast('Issue reported. Supervisor notified.','warning');
}

// ─── Urgency radio highlight ──────────────────────────────────────────────────
document.querySelectorAll('input[name="urgency"]').forEach(r=>{
    r.addEventListener('change',function(){
        document.querySelectorAll('.urgency-btn').forEach(b=>{b.style.outline='none';b.style.outlineOffset='0';});
        this.parentElement.style.outline='2.5px solid #0f172a';
        this.parentElement.style.outlineOffset='2px';
    });
});

// ─── Filter chips ─────────────────────────────────────────────────────────────
document.querySelectorAll('.chip').forEach(chip=>{
    chip.addEventListener('click',function(){
        const filter=this.dataset.filter;
        document.querySelectorAll('.chip').forEach(c=>{
            c.style.background=''; c.style.color='';
        });
        this.style.background='#0f172a'; this.style.color='#fff';
        document.querySelectorAll('#cardsContainer > div, .task-card').forEach(card=>{
            if(filter==='all'||card.dataset.status===filter){
                card.style.display='';
            } else { card.style.display='none'; }
        });
    });
});
</script>
@stack('scripts')
</body>
</html>