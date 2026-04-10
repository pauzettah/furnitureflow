@extends('admin.dashboard')

@section('title', 'Carpenter Details')

@section('content')
<div class="fade-up">
    <div class="section-header"><div><div class="section-title">Carpenter Details</div><div class="section-sub">{{ $carpenter->name }}</div></div><a href="{{ route('admin.carpenters') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back</a></div>

    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap"><div class="data-table-header" style="padding: 20px 24px 0;"><div class="section-title" style="font-size: 1rem;">Personal Information</div></div><div style="padding: 20px 24px;"><p><strong>Name:</strong> {{ $carpenter->name }}</p><p><strong>Email:</strong> {{ $carpenter->email }}</p><p><strong>Phone:</strong> {{ $carpenter->phone ?? 'Not provided' }}</p><p><strong>Joined:</strong> {{ $carpenter->created_at->format('d M Y') }}</p></div></div>

        <div class="data-table-wrap"><div class="data-table-header" style="padding: 20px 24px 0;"><div class="section-title" style="font-size: 1rem;">Statistics</div></div><div style="padding: 20px 24px;"><p><strong>Total Tasks:</strong> {{ $tasks->count() }}</p><p><strong>Completed:</strong> {{ $tasks->where('status', 'completed')->count() }}</p><p><strong>In Progress:</strong> {{ $tasks->where('status', 'in_progress')->count() }}</p><p><strong>Pending:</strong> {{ $tasks->where('status', 'assigned')->count() }}</p></div></div>
    </div>

    <div class="data-table-wrap" style="margin-top: 20px;"><div class="data-table-header" style="padding: 20px 24px 0;"><div class="section-title" style="font-size: 1rem;">Assigned Tasks</div></div><div class="overflow-x-auto"><table class="data-table"><thead><tr><th>Order ID</th><th>Task</th><th>Status</th><th>Assigned</th><th>Due Date</th><th>Actions</th></tr></thead><tbody>@forelse($tasks as $task)<tr><td>{{ $task->order->order_number ?? 'N/A' }}</td><td>{{ $task->task_name }}</td><td><span class="badge badge-{{ $task->status }}">{{ ucfirst($task->status) }}</span></td><td>{{ $task->assigned_date->format('d M Y') }}</td><td>{{ $task->due_date ? $task->due_date->format('d M Y') : 'N/A' }}</td><td><a href="{{ route('admin.orders.show', $task->order_id) }}" class="btn-view">View Order</a></td></tr>@empty<tr><td colspan="6">No tasks assigned</td></tr>@endforelse</tbody></table></div></div>
</div>
@endsection