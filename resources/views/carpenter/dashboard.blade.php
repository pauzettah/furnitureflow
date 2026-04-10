@extends('layouts.carpenter')

@section('title', 'My Tasks')

{{-- Content for DESKTOP layout --}}
@section('content')
{{-- Stats Cards (Desktop) --}}
<div class="stats-grid hidden md:grid">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <i data-lucide="list-checks" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ count($tasks) }}</p>
                <p class="text-sm text-slate-500">Total Tasks</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                <p class="text-sm text-slate-500">In Progress</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                <i data-lucide="hourglass" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'pending')->count() }}</p>
                <p class="text-sm text-slate-500">Pending</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'ready')->count() }}</p>
                <p class="text-sm text-slate-500">Completed</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter Chips (Desktop) --}}
<div class="flex gap-2 mb-6 overflow-x-auto no-scrollbar pb-2">
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-[#0f172a] text-white transition-transform active:scale-95" data-filter="all">All <span class="opacity-60 text-xs">({{ count($tasks) }})</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 transition-transform active:scale-95" data-filter="in_progress">In Progress <span class="opacity-60 text-xs">{{ $tasks->where('status', 'in_progress')->count() }}</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-slate-100 text-slate-600 transition-transform active:scale-95" data-filter="pending">Pending <span class="opacity-60 text-xs">{{ $tasks->where('status', 'pending')->count() }}</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700 transition-transform active:scale-95" data-filter="ready">Ready <span class="opacity-60 text-xs">{{ $tasks->where('status', 'ready')->count() }}</span></button>
</div>

{{-- Task Grid (Desktop) --}}
<div class="task-grid" id="cardsContainer">
    @foreach($tasks as $index => $task)
    <div class="task-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" data-status="{{ $task['status'] }}">
        <div class="h-1 
            @if($task['status'] == 'in_progress') bg-[#f59e0b]
            @elseif($task['status'] == 'ready') bg-[#10b981]
            @else bg-slate-200 @endif">
        </div>
        <div class="p-5">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="hammer" class="w-5 h-5 text-[#334155]"></i>
                    </div>
                    <div>
                        <p class="font-mono text-xs text-slate-400">{{ $task['order_id'] }}</p>
                        <p class="font-bold text-[#0f172a] text-base">{{ $task['title'] }}</p>
                    </div>
                </div>
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold 
                    @if($task['status'] == 'in_progress') bg-blue-50 text-blue-600
                    @elseif($task['status'] == 'ready') bg-emerald-50 text-emerald-600
                    @else bg-slate-100 text-slate-500 @endif">
                    <span class="w-1.5 h-1.5 rounded-full 
                        @if($task['status'] == 'in_progress') bg-blue-500 animate-pulse
                        @elseif($task['status'] == 'ready') bg-emerald-500
                        @else bg-slate-400 @endif"></span>
                    {{ ucfirst(str_replace('_', ' ', $task['status'])) }}
                </span>
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2 text-slate-500 text-sm">
                    <i data-lucide="user" class="w-4 h-4"></i><span>{{ $task['customer'] }}</span>
                </div>
                @if($task['urgent'] ?? false)
                <div class="flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i><span>{{ $task['deadline'] }}</span><span class="ml-0.5">⚡</span>
                </div>
                @else
                <div class="flex items-center gap-1 text-xs text-slate-400">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i><span>{{ $task['deadline'] }}</span>
                </div>
                @endif
            </div>
            <div class="flex gap-3">
                <button onclick="openDetails({{ $index }})" class="btn-ripple flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border-2 border-[#0f172a] text-[#0f172a] text-sm font-semibold hover:bg-[#0f172a] hover:text-white transition-all duration-200 active:scale-95">
                    <i data-lucide="eye" class="w-4 h-4"></i>View Details
                </button>
                @if($task['status'] != 'ready')
                <button onclick="confirmReady('{{ $task['order_id'] }}','{{ $task['title'] }}',{{ $index }})" class="btn-ripple flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#10b981] text-white text-sm font-semibold hover:bg-[#059669] transition-all duration-200 active:scale-95">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>Mark Ready
                </button>
                @else
                <div class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-sm font-semibold cursor-default">
                    <i data-lucide="badge-check" class="w-4 h-4"></i>Completed
                </div>
                @endif
            </div>
            <button onclick="openReport('{{ $task['order_id'] }}')" class="mt-3 w-full flex items-center justify-center gap-2 py-1.5 text-xs text-slate-400 hover:text-amber-600 transition-colors">
                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>Report an Issue
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection

{{-- Content for MOBILE layout --}}
@section('mobile-content')
{{-- Filter chips (Mobile) --}}
<div class="flex gap-2 mb-5 overflow-x-auto no-scrollbar pb-1">
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold bg-[#0f172a] text-white transition-transform active:scale-95" data-filter="all">All <span class="opacity-60 text-xs">({{ count($tasks) }})</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 transition-transform active:scale-95" data-filter="in_progress">In Progress <span class="opacity-60 text-xs">{{ $tasks->where('status', 'in_progress')->count() }}</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold bg-slate-100 text-slate-600 transition-transform active:scale-95" data-filter="pending">Pending <span class="opacity-60 text-xs">{{ $tasks->where('status', 'pending')->count() }}</span></button>
    <button class="chip flex-shrink-0 flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700 transition-transform active:scale-95" data-filter="ready">Ready <span class="opacity-60 text-xs">{{ $tasks->where('status', 'ready')->count() }}</span></button>
</div>

{{-- Task Cards (Mobile) --}}
<div class="space-y-3" id="cardsContainer">
    @foreach($tasks as $index => $task)
    <div class="task-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" data-status="{{ $task['status'] }}">
        <div class="h-1 
            @if($task['status'] == 'in_progress') bg-[#f59e0b]
            @elseif($task['status'] == 'ready') bg-[#10b981]
            @else bg-slate-200 @endif">
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="hammer" class="w-4 h-4 text-[#334155]"></i>
                    </div>
                    <div>
                        <p class="font-mono text-[11px] text-slate-400">{{ $task['order_id'] }}</p>
                        <p class="font-bold text-[#0f172a] text-sm">{{ $task['title'] }}</p>
                    </div>
                </div>
                <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold 
                    @if($task['status'] == 'in_progress') bg-blue-50 text-blue-600
                    @elseif($task['status'] == 'ready') bg-emerald-50 text-emerald-600
                    @else bg-slate-100 text-slate-500 @endif">
                    <span class="w-1.5 h-1.5 rounded-full 
                        @if($task['status'] == 'in_progress') bg-blue-500 animate-pulse
                        @elseif($task['status'] == 'ready') bg-emerald-500
                        @else bg-slate-400 @endif"></span>
                    {{ ucfirst(str_replace('_', ' ', $task['status'])) }}
                </span>
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-1.5 text-slate-500 text-sm">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i><span>{{ $task['customer'] }}</span>
                </div>
                @if($task['urgent'] ?? false)
                <div class="flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i><span>{{ $task['deadline'] }}</span><span class="ml-0.5">⚡</span>
                </div>
                @else
                <div class="flex items-center gap-1 text-xs text-slate-400">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i><span>{{ $task['deadline'] }}</span>
                </div>
                @endif
            </div>
            <div class="flex gap-2">
                <button onclick="openDetails({{ $index }})" class="btn-ripple flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl border-2 border-[#0f172a] text-[#0f172a] text-sm font-semibold hover:bg-[#0f172a] hover:text-white transition-all duration-200 active:scale-95">
                    <i data-lucide="eye" class="w-4 h-4"></i>View
                </button>
                @if($task['status'] != 'ready')
                <button onclick="confirmReady('{{ $task['order_id'] }}','{{ $task['title'] }}',{{ $index }})" class="btn-ripple flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-[#10b981] text-white text-sm font-semibold hover:bg-[#059669] transition-all duration-200 active:scale-95">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>Ready
                </button>
                @else
                <div class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-sm font-semibold cursor-default">
                    <i data-lucide="badge-check" class="w-4 h-4"></i>Done
                </div>
                @endif
            </div>
            <button onclick="openReport('{{ $task['order_id'] }}')" class="mt-2.5 w-full flex items-center justify-center gap-1.5 py-1.5 text-xs text-slate-400 hover:text-amber-600 transition-colors">
                <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>Report Issue
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection