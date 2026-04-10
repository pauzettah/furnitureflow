@extends('admin.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Edit User</div>
            <div class="section-sub">Update user information</div>
        </div>
        <a href="{{ route('admin.settings.users') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Users</a>
    </div>

    <div class="data-table-wrap">
        <form method="POST" action="{{ route('admin.settings.users.update', $editUser->id) }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $editUser->name) }}" class="form-input" required>
                    @error('name') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $editUser->email) }}" class="form-input" required>
                    @error('email') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', $editUser->phone) }}" class="form-input">
                    @error('phone') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Role</label>
                    <select name="role" class="form-input" required>
                        <option value="customer" {{ $editUser->role == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="carpenter" {{ $editUser->role == 'carpenter' ? 'selected' : '' }}>Carpenter</option>
                        <option value="delivery" {{ $editUser->role == 'delivery' ? 'selected' : '' }}>Delivery Staff</option>
                        <option value="admin" {{ $editUser->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Address</label>
                    <textarea name="address" rows="2" class="form-input">{{ old('address', $editUser->address) }}</textarea>
                    @error('address') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">New Password (optional)</label>
                    <input type="password" name="password" class="form-input">
                    @error('password') <span style="color: #ef4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px;">
                <button type="submit" class="btn-view" style="background: #10b981; color: white; padding: 10px 24px;">Update User</button>
                <a href="{{ route('admin.settings.users') }}" class="btn-view" style="background: #64748b; color: white; padding: 10px 24px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection