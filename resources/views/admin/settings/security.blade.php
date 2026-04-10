@extends('admin.dashboard')

@section('title', 'Security Settings')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Security Settings</div>
            <div class="section-sub">Change your password</div>
        </div>
        <a href="{{ route('admin.settings') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Settings</a>
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
        <form method="POST" action="{{ route('admin.settings.password.update') }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <div class="grid" style="display: grid; grid-template-columns: 1fr; max-width: 500px; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Current Password</label>
                    <input type="password" name="current_password" class="form-input" required>
                    @error('current_password') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">New Password</label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password') <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px;">
                <button type="submit" class="btn-view" style="background: #10b981; color: white; padding: 10px 24px;">Update Password</button>
                <a href="{{ route('admin.settings') }}" class="btn-view" style="background: #64748b; color: white; padding: 10px 24px;">Cancel</a>
            </div>
        </form>
    </div>

    <div class="data-table-wrap" style="margin-top: 20px;">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">Security Tips</div>
        </div>
        <div style="padding: 20px 24px;">
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 10px;">✓ Use a strong password with at least 8 characters</li>
                <li style="margin-bottom: 10px;">✓ Include uppercase, lowercase, numbers, and special characters</li>
                <li style="margin-bottom: 10px;">✓ Never share your password with anyone</li>
                <li style="margin-bottom: 10px;">✓ Change your password regularly</li>
            </ul>
        </div>
    </div>
</div>
@endsection