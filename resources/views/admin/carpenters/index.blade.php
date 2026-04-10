@extends('admin.dashboard')

@section('title', 'Carpenters Management')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Carpenters Management</div>
            <div class="section-sub">View and manage all carpenters</div>
        </div>
        <a href="#" class="section-action"><i class="fa-solid fa-plus"></i> Add Carpenter</a>
    </div>

    <div class="data-table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Tasks Assigned</th><th>Completed</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($carpenters as $carpenter)
                    <tr>
                        <td>#{{ $carpenter->id }}</td>
                        <td>{{ $carpenter->name }}</td>
                        <td>{{ $carpenter->email }}</td>
                        <td>{{ $carpenter->phone ?? 'N/A' }}</td>
                        <td>{{ $carpenter->assignedTasks->count() }}</td>
                        <td>{{ $carpenter->assignedTasks->where('status', 'completed')->count() }}</td>
                        <td><div class="action-btns"><a href="{{ route('admin.carpenters.show', $carpenter->id) }}" class="btn-view">View</a><button class="btn-edit">Edit</button></div></td>
                    </tr>
                    @empty
                    <tr><td colspan="7">No carpenters found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">{{ $carpenters->links() }}</div>
    </div>
</div>
@endsection