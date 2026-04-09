<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FurnitureFlow – Crafting Quality Furniture with Precision & Care</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy:    { DEFAULT: '#0f172a', 800: '#1e293b', 700: '#334155', 600: '#475569' },
        gold:    { DEFAULT: '#f59e0b', light: '#fcd34d', dark: '#d97706' },
        emerald: { DEFAULT: '#10b981', light: '#34d399', dark: '#059669' },
      },
      fontFamily: {
        display: ['"Playfair Display"', 'serif'],
        body:    ['"DM Sans"', 'sans-serif'],
      },
    }
  }
}
</script>
<style>
  *, *::before, *::after { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { font-family: 'DM Sans', sans-serif; background: #0f172a; color: #fff; }
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: #0f172a; }
  ::-webkit-scrollbar-thumb { background: #f59e0b; border-radius: 99px; }

  .glass {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.10);
  }
  .text-gradient {
    background: linear-gradient(135deg, #f59e0b 0%, #fcd34d 50%, #10b981 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .hover-underline { position: relative; }
  .hover-underline::after {
    content: ''; position: absolute; bottom: -2px; left: 0;
    width: 0; height: 2px;
    background: linear-gradient(90deg, #f59e0b, #10b981);
    transition: width 0.35s ease;
  }
  .hover-underline:hover::after { width: 100%; }

  .reveal { opacity: 0; transform: translateY(36px); transition: opacity 0.7s ease, transform 0.7s ease; }
  .reveal.visible { opacity: 1; transform: translateY(0); }
  .reveal-delay-1 { transition-delay: 0.1s; }
  .reveal-delay-2 { transition-delay: 0.2s; }
  .reveal-delay-3 { transition-delay: 0.3s; }
  .reveal-delay-4 { transition-delay: 0.4s; }

  .mesh-bg {
    background:
      radial-gradient(ellipse 80% 60% at 20% 20%, rgba(245,158,11,0.12) 0%, transparent 60%),
      radial-gradient(ellipse 60% 80% at 80% 80%, rgba(16,185,129,0.10) 0%, transparent 60%),
      #0f172a;
  }
  .btn-gold {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #0f172a; font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 24px rgba(245,158,11,0.35);
  }
  .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(245,158,11,0.55); }
  .btn-outline { border: 2px solid rgba(255,255,255,0.25); color: #fff; transition: all 0.3s ease; }
  .btn-outline:hover { border-color: #f59e0b; color: #f59e0b; transform: translateY(-2px); }

  .service-card { transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), box-shadow 0.35s ease, border-color 0.35s ease; }
  .service-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 20px 60px rgba(245,158,11,0.18); border-color: rgba(245,158,11,0.4); }
  .service-card:hover .service-icon { background: linear-gradient(135deg, #f59e0b, #10b981); transform: scale(1.1) rotate(5deg); }
  .service-icon { transition: transform 0.35s ease, background 0.35s ease; }

  #navbar { transition: background 0.4s ease, box-shadow 0.4s ease; }
  #navbar.scrolled { background: rgba(15,23,42,0.95) !important; backdrop-filter: blur(20px); box-shadow: 0 4px 40px rgba(0,0,0,0.4); }

  #mobile-menu { transition: max-height 0.4s ease, opacity 0.4s ease; max-height: 0; overflow: hidden; opacity: 0; }
  #mobile-menu.open { max-height: 480px; opacity: 1; }

  @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
  @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
  @keyframes spinSlow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  @keyframes spinSlowRev { from { transform: rotate(0deg); } to { transform: rotate(-360deg); } }

  .animate-float { animation: float 4s ease-in-out infinite; }
  .animate-fade-up { animation: fadeUp 0.8s ease both; }
  .animate-fade-in { animation: fadeIn 1s ease both; }
  .spin-slow { animation: spinSlow 40s linear infinite; }
  .spin-slow-rev { animation: spinSlowRev 25s linear infinite; }
</style>
</head>
<body class="antialiased">

<!-- ═══════════ NAVBAR ═══════════ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 py-4 px-6 md:px-10">
  <div class="max-w-7xl mx-auto flex items-center justify-between">
    <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
      <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg,#f59e0b,#10b981)">
        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h1v2h2v-2h10v2h2v-2h1a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2zM7 15H5v-2h2v2zm6 0H9v-2h4v2zm4 0h-2v-2h2v2z"/><path d="M4 7h16V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v2z"/></svg>
      </div>
      <span class="font-display font-bold text-xl text-white tracking-tight">Furniture<span class="text-gradient">Flow</span></span>
    </a>
    <ul class="hidden md:flex items-center gap-8">
      <li><a href="#home" class="hover-underline text-sm font-medium text-white/75 hover:text-white transition-colors">Home</a></li>
      <li><a href="#about" class="hover-underline text-sm font-medium text-white/75 hover:text-white transition-colors">About Us</a></li>
      <li><a href="#services" class="hover-underline text-sm font-medium text-white/75 hover:text-white transition-colors">Services</a></li>
      <li><a href="#contact" class="hover-underline text-sm font-medium text-white/75 hover:text-white transition-colors">Contact</a></li>
    </ul>
    <div class="hidden md:flex items-center gap-3">
      @auth
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.dashboard') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">Dashboard</a>
        @elseif(auth()->user()->role === 'customer')
          <a href="{{ route('customer.orders') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">My Orders</a>
        @elseif(auth()->user()->role === 'carpenter')
          <a href="{{ route('carpenter.dashboard') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">My Tasks</a>
        @elseif(auth()->user()->role === 'delivery')
          <a href="{{ route('delivery.dashboard') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">Deliveries</a>
        @else
          <a href="{{ route('customer.orders') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">Dashboard</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="btn-outline px-5 py-2 rounded-xl text-sm font-medium">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn-outline px-5 py-2 rounded-xl text-sm font-medium">Login</a>
        <a href="{{ route('register') }}" class="btn-gold px-5 py-2 rounded-xl text-sm font-medium">Register</a>
      @endauth
    </div>
    <button id="menu-btn" class="md:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-white/10 transition-colors">
      <span class="w-6 h-0.5 bg-white rounded-full"></span>
      <span class="w-4 h-0.5 bg-yellow-400 rounded-full ml-auto"></span>
      <span class="w-6 h-0.5 bg-white rounded-full"></span>
    </button>
  </div>
  <div id="mobile-menu" class="md:hidden glass rounded-2xl mt-3 mx-0">
    <div class="p-5 flex flex-col gap-3">
      <a href="#home" class="text-sm font-medium text-white/80 hover:text-yellow-400 transition-colors py-2 px-3 rounded-lg hover:bg-white/5">Home</a>
      <a href="#about" class="text-sm font-medium text-white/80 hover:text-yellow-400 transition-colors py-2 px-3 rounded-lg hover:bg-white/5">About Us</a>
      <a href="#services" class="text-sm font-medium text-white/80 hover:text-yellow-400 transition-colors py-2 px-3 rounded-lg hover:bg-white/5">Services</a>
      <a href="#contact" class="text-sm font-medium text-white/80 hover:text-yellow-400 transition-colors py-2 px-3 rounded-lg hover:bg-white/5">Contact</a>
      <hr class="border-white/10 my-1" />
      @auth
        <div class="flex gap-3">
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn-gold flex-1 text-center py-2.5 rounded-xl text-sm font-medium">Dashboard</a>
          @else
            <a href="{{ route('customer.orders') }}" class="btn-gold flex-1 text-center py-2.5 rounded-xl text-sm font-medium">Dashboard</a>
          @endif
          <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit" class="btn-outline w-full text-center py-2.5 rounded-xl text-sm font-medium">Logout</button>
          </form>
        </div>
      @else
        <div class="flex gap-3">
          <a href="{{ route('login') }}" class="btn-outline flex-1 text-center py-2.5 rounded-xl text-sm font-medium">Login</a>
          <a href="{{ route('register') }}" class="btn-gold flex-1 text-center py-2.5 rounded-xl text-sm font-medium">Register</a>
        </div>
      @endauth
    </div>
  </div>
</nav>

<!-- ═══════════ HERO ═══════════ -->
<section id="home" class="relative min-h-screen flex items-center overflow-hidden">
  <div class="absolute inset-0 mesh-bg"></div>
  <div class="absolute top-1/4 right-10 w-72 h-72 border border-yellow-400/15 rounded-full spin-slow"></div>
  <div class="absolute top-1/3 right-24 w-48 h-48 border border-emerald-400/10 rounded-full spin-slow-rev"></div>
  <div class="absolute top-1/4 right-1/3 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:rgba(245,158,11,0.08)"></div>
  <div class="absolute bottom-1/4 left-1/4 w-80 h-80 rounded-full blur-3xl pointer-events-none" style="background:rgba(16,185,129,0.06)"></div>

  <div class="relative max-w-7xl mx-auto px-6 md:px-10 py-32 md:py-40 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
    <div>
      <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full text-xs font-medium text-yellow-400 mb-8 animate-fade-in">
        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full" style="animation:pulse 2s infinite"></span>
        Trusted by 500+ Happy Clients Across East Africa
      </div>
      <h1 class="font-display font-black text-5xl md:text-6xl xl:text-7xl leading-tight tracking-tight mb-6 animate-fade-up" style="animation-delay:0.1s">
        Crafting Quality
        <span class="block text-gradient mt-1">Furniture</span>
        <span class="block text-white/90 mt-1" style="font-size:0.82em">with Precision &amp; Care</span>
      </h1>
      <p class="text-white/60 text-lg leading-relaxed max-w-lg mb-10 animate-fade-up" style="animation-delay:0.25s">
        FurnitureFlow streamlines your entire furniture warehouse — from raw material intake and workshop scheduling to order tracking and client delivery. Modern tools for master craftspeople.
      </p>
      <div class="flex flex-wrap gap-4 animate-fade-up" style="animation-delay:0.4s">
        @auth
          <a href="#" class="btn-gold px-7 py-4 rounded-2xl text-base font-semibold inline-flex items-center gap-2">
            Go to Dashboard
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        @else
          <a href="{{ route('register') }}" class="btn-gold px-7 py-4 rounded-2xl text-base font-semibold inline-flex items-center gap-2">
            Get Started
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        @endauth
        <a href="#services" class="btn-outline px-7 py-4 rounded-2xl text-base font-medium inline-flex items-center gap-2">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><path d="M10 8l6 4-6 4V8z"/></svg>
          View Our Work
        </a>
      </div>
      <div class="flex flex-wrap gap-6 mt-12 animate-fade-up" style="animation-delay:0.55s">
        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg><span class="text-white/50 text-sm">ISO 9001 Certified</span></div>
        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg><span class="text-white/50 text-sm">15-Day Delivery</span></div>
        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg><span class="text-white/50 text-sm">5★ Rated</span></div>
      </div>
    </div>

    <div class="hidden lg:flex justify-center items-center animate-fade-in" style="animation-delay:0.3s">
      <div class="relative">
        <div class="glass rounded-3xl p-8 w-80 shadow-2xl animate-float">
          <div class="flex items-center justify-between mb-6">
            <span class="text-white/60 text-sm font-medium">Active Orders</span>
            <span class="w-2.5 h-2.5 bg-emerald-400 rounded-full" style="box-shadow:0 0 10px rgba(16,185,129,0.8)"></span>
          </div>
          <div class="text-5xl font-display font-black text-gradient mb-1">247</div>
          <p class="text-white/40 text-xs mb-6">Orders in progress this month</p>
          <div class="flex items-end gap-1.5 h-14">
            <div class="flex-1 rounded-t-sm" style="height:40%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:65%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:45%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:80%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:55%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:90%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:70%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:85%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:60%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:100%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:75%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
            <div class="flex-1 rounded-t-sm" style="height:95%;background:linear-gradient(to top,rgba(245,158,11,0.6),rgba(16,185,129,0.4))"></div>
          </div>
          <div class="flex justify-between mt-2"><span class="text-white/25 text-xs">Jan</span><span class="text-white/25 text-xs">Dec</span></div>
        </div>
        <div class="absolute -top-6 -right-10 glass rounded-2xl px-5 py-3 shadow-xl">
          <div class="text-yellow-400 font-display font-bold text-2xl">98%</div>
          <div class="text-white/50 text-xs">Client Satisfaction</div>
        </div>
        <div class="absolute -bottom-6 -left-10 glass rounded-2xl px-5 py-3 shadow-xl">
          <div class="text-emerald-400 font-display font-bold text-2xl">15yr</div>
          <div class="text-white/50 text-xs">In Business</div>
        </div>
      </div>
    </div>
  </div>

  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
    <span class="text-white/30 text-xs tracking-widest uppercase">Scroll</span>
    <svg class="w-4 h-4 text-yellow-400/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </div>
</section>

<!-- ═══════════ STATS ═══════════ -->
<section class="relative py-12 border-y border-white/8 overflow-hidden">
  <div class="absolute inset-0" style="background:linear-gradient(90deg,rgba(30,41,59,0.5),rgba(15,23,42,0.8),rgba(30,41,59,0.5))"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
      <div class="text-center reveal"><div class="font-display font-black text-4xl md:text-5xl text-gradient"><span data-target="15" data-suffix="+">0+</span></div><p class="text-white/45 text-sm mt-2 font-medium">Years of Experience</p></div>
      <div class="text-center reveal reveal-delay-1"><div class="font-display font-black text-4xl md:text-5xl text-gradient"><span data-target="500" data-suffix="+">0+</span></div><p class="text-white/45 text-sm mt-2 font-medium">Happy Clients</p></div>
      <div class="text-center reveal reveal-delay-2"><div class="font-display font-black text-4xl md:text-5xl text-gradient"><span data-target="3000" data-suffix="+">0+</span></div><p class="text-white/45 text-sm mt-2 font-medium">Projects Completed</p></div>
      <div class="text-center reveal reveal-delay-3"><div class="font-display font-black text-4xl md:text-5xl text-gradient"><span data-target="98" data-suffix="%">0%</span></div><p class="text-white/45 text-sm mt-2 font-medium">Satisfaction Rate</p></div>
    </div>
  </div>
</section>

<!-- ═══════════ ABOUT ═══════════ -->
<section id="about" class="relative py-28 overflow-hidden">
  <div class="absolute inset-0 mesh-bg opacity-60"></div>
  <div class="absolute top-0 right-0 w-80 h-80 rounded-full blur-3xl" style="background:rgba(245,158,11,0.06)"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="reveal reveal-delay-1">
        <div class="inline-flex items-center gap-2 text-yellow-400 text-xs font-semibold tracking-widest uppercase mb-4">
          <span class="w-8 h-px bg-yellow-400"></span>Who We Are
        </div>
        <h2 class="font-display font-black text-4xl md:text-5xl text-white leading-tight mb-6">More Than Just<br/><span class="text-gradient">Furniture.</span><br/>It's a Legacy.</h2>
        <p class="text-white/55 leading-relaxed mb-6">Founded in 2008, FurnitureFlow began as a small family workshop in Nairobi. Today, we are East Africa's most trusted furniture manufacturer and warehouse management platform — blending traditional craftsmanship with cutting-edge technology to deliver pieces that stand the test of time.</p>
        <p class="text-white/55 leading-relaxed mb-10">Our FurnitureFlow system empowers warehouse managers, craftspeople, and delivery teams with real-time dashboards, inventory control, and seamless order management — all in one platform.</p>
        <div class="flex flex-wrap gap-3">
          <span class="glass px-4 py-2 rounded-full text-xs font-medium text-white/70 border border-white/10 hover:border-yellow-400/30 hover:text-yellow-400 transition-all duration-300 cursor-default">✦ Locally Sourced Timber</span>
          <span class="glass px-4 py-2 rounded-full text-xs font-medium text-white/70 border border-white/10 hover:border-yellow-400/30 hover:text-yellow-400 transition-all duration-300 cursor-default">✦ Eco-Friendly Finishes</span>
          <span class="glass px-4 py-2 rounded-full text-xs font-medium text-white/70 border border-white/10 hover:border-yellow-400/30 hover:text-yellow-400 transition-all duration-300 cursor-default">✦ Custom Designs</span>
          <span class="glass px-4 py-2 rounded-full text-xs font-medium text-white/70 border border-white/10 hover:border-yellow-400/30 hover:text-yellow-400 transition-all duration-300 cursor-default">✦ Nationwide Delivery</span>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-5 reveal reveal-delay-2">
        <div class="glass rounded-2xl p-6 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-12 h-12 bg-yellow-400/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 1 1 7.072 0l-.548.547A3.374 3.374 0 0 0 14 18.469V19a2 2 0 1 1-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="font-display font-bold text-xl text-white mb-0.5">15+ Years</div>
          <div class="text-white/45 text-xs">of Crafting Excellence</div>
        </div>
        <div class="glass rounded-2xl p-6 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-12 h-12 bg-emerald-400/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 0 1 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 0 1 9.288 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="font-display font-bold text-xl text-white mb-0.5">80+ Artisans</div>
          <div class="text-white/45 text-xs">Skilled &amp; Dedicated</div>
        </div>
        <div class="glass rounded-2xl p-6 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-12 h-12 bg-yellow-400/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2m14 0V9a2 2 0 0 0-2-2M5 11V9a2 2 0 0 1 2-2m0 0V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="font-display font-bold text-xl text-white mb-0.5">5,000+</div>
          <div class="text-white/45 text-xs">Products in Warehouse</div>
        </div>
        <div class="glass rounded-2xl p-6 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-12 h-12 bg-emerald-400/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="font-display font-bold text-xl text-white mb-0.5">3 Branches</div>
          <div class="text-white/45 text-xs">Nairobi, Mombasa, Kisumu</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ VISION & MISSION ═══════════ -->
<section id="vision" class="relative py-24 overflow-hidden">
  <div class="absolute inset-0" style="background:linear-gradient(to bottom,rgba(30,41,59,0.3),transparent)"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="text-center mb-16 reveal">
      <div class="inline-flex items-center gap-2 text-yellow-400 text-xs font-semibold tracking-widest uppercase mb-4">
        <span class="w-8 h-px bg-yellow-400"></span>What Drives Us<span class="w-8 h-px bg-yellow-400"></span>
      </div>
      <h2 class="font-display font-black text-4xl md:text-5xl text-white">Vision &amp; Mission</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="relative glass rounded-3xl p-10 overflow-hidden reveal reveal-delay-1 group hover:border-yellow-400/30 transition-all duration-500">
        <div class="absolute top-0 right-0 w-48 h-48 rounded-full blur-2xl group-hover:opacity-100 opacity-60 transition-opacity" style="background:rgba(245,158,11,0.1)"></div>
        <div class="relative">
          <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-7 group-hover:scale-110 transition-transform duration-300" style="background:rgba(245,158,11,0.15)">
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="inline-flex items-center gap-2 text-yellow-400 text-xs font-bold tracking-widest uppercase mb-3"><span class="w-6 h-px bg-yellow-400/60"></span>Our Vision</div>
          <h3 class="font-display font-bold text-2xl text-white mb-4">To Be Africa's #1 Furniture Brand</h3>
          <p class="text-white/55 leading-relaxed text-sm">We envision a future where every home and office in Africa is furnished with locally-crafted, world-class furniture. We aim to set the gold standard for quality, sustainability, and innovation — making "Made in Africa" synonymous with excellence in furniture design.</p>
          <div class="mt-8 pt-6 border-t border-white/10 flex gap-6">
            <span class="text-yellow-400 text-xs font-semibold">✦ Innovation</span>
            <span class="text-yellow-400 text-xs font-semibold">✦ Excellence</span>
            <span class="text-yellow-400 text-xs font-semibold">✦ Sustainability</span>
          </div>
        </div>
      </div>
      <div class="relative glass rounded-3xl p-10 overflow-hidden reveal reveal-delay-2 group hover:border-emerald-400/30 transition-all duration-500">
        <div class="absolute top-0 right-0 w-48 h-48 rounded-full blur-2xl group-hover:opacity-100 opacity-60 transition-opacity" style="background:rgba(16,185,129,0.1)"></div>
        <div class="relative">
          <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-7 group-hover:scale-110 transition-transform duration-300" style="background:rgba(16,185,129,0.15)">
            <svg class="w-8 h-8" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 0 0 1.946-.806 3.42 3.42 0 0 1 4.438 0 3.42 3.42 0 0 0 1.946.806 3.42 3.42 0 0 1 3.138 3.138 3.42 3.42 0 0 0 .806 1.946 3.42 3.42 0 0 1 0 4.438 3.42 3.42 0 0 0-.806 1.946 3.42 3.42 0 0 1-3.138 3.138 3.42 3.42 0 0 0-1.946.806 3.42 3.42 0 0 1-4.438 0 3.42 3.42 0 0 0-1.946-.806 3.42 3.42 0 0 1-3.138-3.138 3.42 3.42 0 0 0-.806-1.946 3.42 3.42 0 0 1 0-4.438 3.42 3.42 0 0 0 .806-1.946 3.42 3.42 0 0 1 3.138-3.138z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="inline-flex items-center gap-2 text-emerald-400 text-xs font-bold tracking-widest uppercase mb-3"><span class="w-6 h-px bg-emerald-400/60"></span>Our Mission</div>
          <h3 class="font-display font-bold text-2xl text-white mb-4">Delivering Quality, Every Single Time</h3>
          <p class="text-white/55 leading-relaxed text-sm">Our mission is to deliver precision-crafted furniture and a seamless warehouse management experience. We empower our artisans with the best tools, source sustainable raw materials, and ensure every client receives their dream furniture on time, within budget, and beyond expectations.</p>
          <div class="mt-8 pt-6 border-t border-white/10 flex gap-6">
            <span class="text-emerald-400 text-xs font-semibold">✦ Quality</span>
            <span class="text-emerald-400 text-xs font-semibold">✦ Integrity</span>
            <span class="text-emerald-400 text-xs font-semibold">✦ Timeliness</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ SERVICES ═══════════ -->
<section id="services" class="relative py-28 overflow-hidden">
  <div class="absolute inset-0 mesh-bg opacity-50"></div>
  <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-96 h-96 rounded-full blur-3xl" style="background:rgba(245,158,11,0.06)"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="text-center mb-16 reveal">
      <div class="inline-flex items-center gap-2 text-yellow-400 text-xs font-semibold tracking-widest uppercase mb-4">
        <span class="w-8 h-px bg-yellow-400"></span>What We Do<span class="w-8 h-px bg-yellow-400"></span>
      </div>
      <h2 class="font-display font-black text-4xl md:text-5xl text-white mb-4">Our Services</h2>
      <p class="text-white/50 max-w-xl mx-auto">From raw timber to finished masterpieces — we offer a complete range of furniture services tailored to your needs.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <div class="service-card glass rounded-3xl p-7 border border-white/10 reveal reveal-delay-1">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-6" style="background:rgba(245,158,11,0.13);color:#f59e0b">✦ Most Popular</div>
        <div class="service-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05))">
          <svg class="w-7 h-7" fill="none" stroke="#f59e0b" stroke-width="1.7" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-6l-2-2H5a2 2 0 0 0-2 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-display font-bold text-lg text-white mb-3">Sofa Set Making</h3>
        <p class="text-white/50 text-sm leading-relaxed">Bespoke sofa sets crafted with premium foam, durable fabric, and solid hardwood frames — designed to last decades.</p>
        <div class="mt-6 pt-5 border-t border-white/8"><a href="#contact" class="text-xs font-semibold hover-underline" style="color:#f59e0b">Enquire Now →</a></div>
      </div>

      <div class="service-card glass rounded-3xl p-7 border border-white/10 reveal reveal-delay-2">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-6" style="background:rgba(16,185,129,0.13);color:#10b981">✦ Premium</div>
        <div class="service-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(16,185,129,0.05))">
          <svg class="w-7 h-7" fill="none" stroke="#10b981" stroke-width="1.7" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-display font-bold text-lg text-white mb-3">Custom Furniture</h3>
        <p class="text-white/50 text-sm leading-relaxed">Bring your vision to life. Our designers and craftsmen build entirely custom pieces matching your space and style perfectly.</p>
        <div class="mt-6 pt-5 border-t border-white/8"><a href="#contact" class="text-xs font-semibold hover-underline" style="color:#10b981">Enquire Now →</a></div>
      </div>

      <div class="service-card glass rounded-3xl p-7 border border-white/10 reveal reveal-delay-3">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-6" style="background:rgba(245,158,11,0.13);color:#f59e0b">✦ Fast Turnaround</div>
        <div class="service-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05))">
          <svg class="w-7 h-7" fill="none" stroke="#f59e0b" stroke-width="1.7" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-display font-bold text-lg text-white mb-3">Repairs &amp; Maintenance</h3>
        <p class="text-white/50 text-sm leading-relaxed">Extend the life of your furniture. Our skilled technicians handle everything from structural repairs to full refinishing.</p>
        <div class="mt-6 pt-5 border-t border-white/8"><a href="#contact" class="text-xs font-semibold hover-underline" style="color:#f59e0b">Enquire Now →</a></div>
      </div>

      <div class="service-card glass rounded-3xl p-7 border border-white/10 reveal reveal-delay-4">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-6" style="background:rgba(16,185,129,0.13);color:#10b981">✦ Nationwide</div>
        <div class="service-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(16,185,129,0.05))">
          <svg class="w-7 h-7" fill="none" stroke="#10b981" stroke-width="1.7" viewBox="0 0 24 24"><path d="M9 17H5l-1-4h16l-1 4h-4M3 13l1-6h16l1 6M9 17a2 2 0 1 0 4 0m-4 0a2 2 0 0 1 4 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-display font-bold text-lg text-white mb-3">Delivery Services</h3>
        <p class="text-white/50 text-sm leading-relaxed">White-glove delivery and assembly anywhere in Kenya. GPS-tracked vehicles, professional handlers, damage-free guarantee.</p>
        <div class="mt-6 pt-5 border-t border-white/8"><a href="#contact" class="text-xs font-semibold hover-underline" style="color:#10b981">Enquire Now →</a></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ WHY CHOOSE US ═══════════ -->
<section id="why-us" class="relative py-28 overflow-hidden">
  <div class="absolute inset-0" style="background:linear-gradient(to bottom,transparent,rgba(30,41,59,0.4),transparent)"></div>
  <div class="absolute top-1/2 left-0 w-96 h-96 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2" style="background:rgba(16,185,129,0.06)"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="reveal">
        <div class="inline-flex items-center gap-2 text-yellow-400 text-xs font-semibold tracking-widest uppercase mb-4"><span class="w-8 h-px bg-yellow-400"></span>Our Edge</div>
        <h2 class="font-display font-black text-4xl md:text-5xl text-white leading-tight mb-6">Why Over 500 Clients<br/>Choose <span class="text-gradient">FurnitureFlow</span></h2>
        <p class="text-white/55 leading-relaxed mb-10">We combine the warmth of traditional craftsmanship with the efficiency of modern warehouse technology — giving you the best of both worlds.</p>
        @auth
          <a href="#" class="btn-gold px-8 py-4 rounded-2xl font-semibold inline-flex items-center gap-2">
            Go to Dashboard
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        @else
          <a href="{{ route('register') }}" class="btn-gold px-8 py-4 rounded-2xl font-semibold inline-flex items-center gap-2">
            Start Your Journey
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        @endauth
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 reveal reveal-delay-2">
        <div class="glass rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform" style="background:rgba(245,158,11,0.12)">
            <svg class="w-5 h-5" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 0 0 1.946-.806 3.42 3.42 0 0 1 4.438 0 3.42 3.42 0 0 0 1.946.806 3.42 3.42 0 0 1 3.138 3.138 3.42 3.42 0 0 0 .806 1.946 3.42 3.42 0 0 1 0 4.438 3.42 3.42 0 0 0-.806 1.946 3.42 3.42 0 0 1-3.138 3.138 3.42 3.42 0 0 0-1.946.806 3.42 3.42 0 0 1-4.438 0 3.42 3.42 0 0 0-1.946-.806 3.42 3.42 0 0 1-3.138-3.138 3.42 3.42 0 0 0-.806-1.946 3.42 3.42 0 0 1 0-4.438 3.42 3.42 0 0 0 .806-1.946 3.42 3.42 0 0 1 3.138-3.138z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h4 class="font-display font-bold text-white text-base mb-2">Quality Materials</h4>
          <p class="text-white/45 text-xs leading-relaxed">Only premium hardwoods and certified fabrics sourced responsibly from trusted local suppliers.</p>
        </div>
        <div class="glass rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform" style="background:rgba(16,185,129,0.12)">
            <svg class="w-5 h-5" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h4 class="font-display font-bold text-white text-base mb-2">Timely Delivery</h4>
          <p class="text-white/45 text-xs leading-relaxed">Our logistics team guarantees on-time delivery with real-time tracking and SMS updates for every order.</p>
        </div>
        <div class="glass rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform" style="background:rgba(245,158,11,0.12)">
            <svg class="w-5 h-5" fill="none" stroke="#f59e0b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h4 class="font-display font-bold text-white text-base mb-2">Affordable Pricing</h4>
          <p class="text-white/45 text-xs leading-relaxed">Factory-direct pricing with no hidden costs. Flexible payment plans available for large orders.</p>
        </div>
        <div class="glass rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 group hover:-translate-y-1">
          <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform" style="background:rgba(16,185,129,0.12)">
            <svg class="w-5 h-5" fill="none" stroke="#10b981" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 0 1 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 0 1 9.288 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h4 class="font-display font-bold text-white text-base mb-2">Skilled Team</h4>
          <p class="text-white/45 text-xs leading-relaxed">Our 80+ master craftsmen and certified designers bring decades of combined experience to every project.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ TESTIMONIALS ═══════════ -->
<section class="relative py-20 overflow-hidden border-y border-white/8">
  <div class="absolute inset-0" style="background:linear-gradient(90deg,rgba(245,158,11,0.05),transparent,rgba(16,185,129,0.05))"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10">
    <div class="text-center mb-12 reveal">
      <p class="text-yellow-400 text-xs font-semibold tracking-widest uppercase mb-3">★★★★★ Testimonials</p>
      <h2 class="font-display font-black text-3xl text-white">What Our Clients Say</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="glass rounded-2xl p-7 reveal hover:border-yellow-400/20 transition-all duration-300">
        <div class="flex gap-1 mb-4">★★★★★</div>
        <p class="text-white/60 text-sm leading-relaxed mb-5 italic">"The sofa set they built for us is absolutely stunning. 5 years later and it still looks brand new. The quality speaks for itself!"</p>
        <div><div class="font-semibold text-white text-sm">Amina Wanjiru</div><div class="text-white/35 text-xs">Homeowner, Nairobi</div></div>
      </div>
      <div class="glass rounded-2xl p-7 reveal reveal-delay-1 hover:border-yellow-400/20 transition-all duration-300">
        <div class="flex gap-1 mb-4 text-yellow-400">★★★★★</div>
        <p class="text-white/60 text-sm leading-relaxed mb-5 italic">"FurnitureFlow delivered our entire office setup — 40 workstations — in under 10 days. The system tracking was incredible."</p>
        <div><div class="font-semibold text-white text-sm">David Omondi</div><div class="text-white/35 text-xs">CEO, TechHub Mombasa</div></div>
      </div>
      <div class="glass rounded-2xl p-7 reveal reveal-delay-2 hover:border-yellow-400/20 transition-all duration-300">
        <div class="flex gap-1 mb-4 text-yellow-400">★★★★★</div>
        <p class="text-white/60 text-sm leading-relaxed mb-5 italic">"We've worked with many suppliers, but none match FurnitureFlow's attention to detail and customer service. Truly world-class."</p>
        <div><div class="font-semibold text-white text-sm">Grace Muthoni</div><div class="text-white/35 text-xs">Interior Designer</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════ CTA ═══════════ -->
<section class="relative py-32 overflow-hidden">
  <div class="absolute inset-0" style="background:radial-gradient(ellipse 80% 70% at 50% 50%,rgba(245,158,11,0.14) 0%,rgba(16,185,129,0.08) 50%,transparent 100%),#0f172a"></div>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-yellow-400/8 rounded-full spin-slow"></div>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] border border-emerald-400/8 rounded-full spin-slow-rev"></div>
  <div class="relative max-w-4xl mx-auto px-6 md:px-10 text-center reveal">
    <div class="inline-flex items-center gap-2 text-emerald-400 text-xs font-semibold tracking-widest uppercase mb-6">
      <span class="w-8 h-px bg-emerald-400"></span>Get Started Today<span class="w-8 h-px bg-emerald-400"></span>
    </div>
    <h2 class="font-display font-black text-5xl md:text-6xl text-white leading-tight mb-6">Ready to Order Your<br/><span class="text-gradient">Dream Furniture?</span></h2>
    <p class="text-white/55 text-lg max-w-2xl mx-auto mb-12">Join 500+ satisfied clients across East Africa. Create your account today and experience furniture management like never before.</p>
    <div class="flex flex-wrap gap-4 justify-center">
      @auth
        <a href="#" class="btn-gold px-10 py-5 rounded-2xl text-base font-bold inline-flex items-center gap-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Go to Dashboard
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      @else
        <a href="{{ route('register') }}" class="btn-gold px-10 py-5 rounded-2xl text-base font-bold inline-flex items-center gap-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Create an Order
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      @endauth
      <a href="#contact" class="btn-outline px-10 py-5 rounded-2xl text-base font-medium inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Talk to Us First
      </a>
    </div>
    <p class="text-white/25 text-sm mt-8">No credit card required · Free 14-day trial · Cancel anytime</p>
  </div>
</section>

<!-- ═══════════ FOOTER ═══════════ -->
<footer id="contact" class="relative overflow-hidden border-t border-white/10">
  <div class="absolute top-0 left-0 right-0 h-px" style="background:linear-gradient(90deg,transparent,#f59e0b,transparent)"></div>
  <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2" style="background:rgba(245,158,11,0.05)"></div>
  <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2" style="background:rgba(16,185,129,0.05)"></div>
  <div class="relative max-w-7xl mx-auto px-6 md:px-10 pt-20 pb-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
      <div class="lg:col-span-1">
        <a href="#home" class="flex items-center gap-2.5 mb-5">
          <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#f59e0b,#10b981)">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h1v2h2v-2h10v2h2v-2h1a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2zM7 15H5v-2h2v2zm6 0H9v-2h4v2zm4 0h-2v-2h2v2z"/><path d="M4 7h16V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v2z"/></svg>
          </div>
          <span class="font-display font-bold text-xl text-white">Furniture<span class="text-gradient">Flow</span></span>
        </a>
        <p class="text-white/50 text-sm leading-relaxed mb-6">Premium furniture warehouse management — where craftsmanship meets technology. Delivering elegance since 2008.</p>
        <div class="flex gap-3">
          <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-yellow-400/20 transition-all duration-300"><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
          <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-yellow-400/20 transition-all duration-300"><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
          <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-yellow-400/20 transition-all duration-300"><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zm1.5-4.87h.01M6.5 19.5h11a3 3 0 0 0 3-3v-11a3 3 0 0 0-3-3h-11a3 3 0 0 0-3 3v11a3 3 0 0 0 3 3z" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
          <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center hover:bg-yellow-400/20 transition-all duration-300"><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z M4 6a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        </div>
      </div>
      <div>
        <h4 class="font-display font-semibold text-white mb-5 text-lg">Quick Links</h4>
        <ul class="space-y-3">
          <li><a href="#home" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Home</a></li>
          <li><a href="#about" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>About Us</a></li>
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Services</a></li>
          <li><a href="#vision" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Vision &amp; Mission</a></li>
          <li><a href="#why-us" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Why Choose Us</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-display font-semibold text-white mb-5 text-lg">Our Services</h4>
        <ul class="space-y-3">
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Sofa Set Making</a></li>
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Custom Furniture</a></li>
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Repairs &amp; Maintenance</a></li>
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Delivery Services</a></li>
          <li><a href="#services" class="text-white/50 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 group"><span class="w-4 h-px bg-white/20 group-hover:bg-yellow-400 group-hover:w-6 transition-all"></span>Interior Consultation</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-display font-semibold text-white mb-5 text-lg">Contact Us</h4>
        <ul class="space-y-4">
          <li class="flex items-start gap-3 group">
            <div class="w-8 h-8 glass rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-yellow-400/20 transition-colors">
              <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span class="text-white/55 text-sm leading-relaxed">123 Furniture Lane, Nairobi, Kenya</span>
          </li>
          <li class="flex items-start gap-3 group">
            <div class="w-8 h-8 glass rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-yellow-400/20 transition-colors">
              <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span class="text-white/55 text-sm leading-relaxed">+254 700 123 456</span>
          </li>
          <li class="flex items-start gap-3 group">
            <div class="w-8 h-8 glass rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-yellow-400/20 transition-colors">
              <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span class="text-white/55 text-sm leading-relaxed">hello@furnitureflow.co.ke</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-white/35 text-sm">&copy; 2025 <span class="text-yellow-400/70">FurnitureFlow</span>. All rights reserved.</p>
      <div class="flex gap-6">
        <a href="#" class="text-white/35 hover:text-yellow-400 text-xs transition-colors">Privacy Policy</a>
        <a href="#" class="text-white/35 hover:text-yellow-400 text-xs transition-colors">Terms of Service</a>
        <a href="#" class="text-white/35 hover:text-yellow-400 text-xs transition-colors">Cookie Policy</a>
      </div>
    </div>
  </div>
</footer>

<script>
  // Navbar scroll effect
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 60); });

  // Mobile menu
  const menuBtn = document.getElementById('menu-btn');
  if (menuBtn) {
    menuBtn.addEventListener('click', () => {
      document.getElementById('mobile-menu').classList.toggle('open');
    });
    document.querySelectorAll('#mobile-menu a').forEach(a => a.addEventListener('click', () => document.getElementById('mobile-menu').classList.remove('open')));
  }

  // Scroll reveal
  const observer = new IntersectionObserver(entries => entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); }), { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  // Count-up animation
  function animateCount(el, target, duration = 1800) {
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
      start += step;
      if (start >= target) { el.textContent = target + (el.dataset.suffix || ''); clearInterval(timer); }
      else el.textContent = Math.floor(start) + (el.dataset.suffix || '');
    }, 16);
  }
  const countObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting) { animateCount(e.target, parseInt(e.target.dataset.target)); countObs.unobserve(e.target); } });
  }, { threshold: 0.5 });
  document.querySelectorAll('[data-target]').forEach(el => countObs.observe(el));
</script>
</body>
</html>