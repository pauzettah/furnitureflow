@extends('admin.dashboard')

@section('title', 'User Management')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">User Management</div>
            <div class="section-sub">Manage all system users</div>
        </div>
        <a href="{{ route('admin.settings.users.create') }}" class="section-action"><i class="fa-solid fa-plus"></i> Add User</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="data-table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>{{ $user->name }} @if($user->id == auth()->id()) <span style="font-size: 10px; background: #c9a84c; color: white; padding: 2px 6px; border-radius: 4px;">You</span> @endif</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge 
                                @if($user->role == 'admin') badge-pending
                                @elseif($user->role == 'customer') badge-ready
                                @elseif($user->role == 'carpenter') badge-production
                                @else badge-delivered @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.settings.users.edit', $user->id) }}" class="btn-view">Edit</a>
                                @if($user->id != auth()->id())
                                <form action="{{ route('admin.settings.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-edit" style="background: #fee2e2; color: #dc2626;">Delete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">No users found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection