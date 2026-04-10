@extends('admin.dashboard')

@section('title', 'Profile Settings')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Profile Settings</div>
            <div class="section-sub">Update your personal information</div>
        </div>
        <a href="{{ route('admin.settings') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Settings</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-table-wrap">
        <form method="POST" action="{{ route('admin.settings.profile.update') }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    @error('name') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                    @error('email') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
                    @error('phone') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Role</label>
                    <input type="text" value="{{ ucfirst($user->role) }}" class="form-input" disabled style="background: #f1f5f9;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Address</label>
                    <textarea name="address" rows="3" class="form-input">{{ old('address', $user->address) }}</textarea>
                    @error('address') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px;">
                <button type="submit" class="btn-view" style="background: #10b981; color: white; padding: 10px 24px;">Save Changes</button>
                <a href="{{ route('admin.settings') }}" class="btn-view" style="background: #64748b; color: white; padding: 10px 24px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection