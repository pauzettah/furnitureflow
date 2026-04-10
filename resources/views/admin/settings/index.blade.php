@extends('admin.dashboard')

@section('title', 'Settings')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Settings</div>
            <div class="section-sub">Manage your account and system preferences</div>
        </div>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        <a href="{{ route('admin.settings.profile') }}" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
            <div class="stat-icon navy"><i class="fa-solid fa-user"></i></div>
            <div class="stat-label">Profile</div>
            <div class="stat-value" style="font-size: 1.2rem;">Update Info</div>
            <div style="font-size: 0.75rem; color: #64748b;">Manage your personal information</div>
        </a>

        <a href="{{ route('admin.settings.security') }}" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
            <div class="stat-icon gold"><i class="fa-solid fa-lock"></i></div>
            <div class="stat-label">Security</div>
            <div class="stat-value" style="font-size: 1.2rem;">Change Password</div>
            <div style="font-size: 0.75rem; color: #64748b;">Update your password</div>
        </a>

        <a href="{{ route('admin.settings.users') }}" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
            <div class="stat-icon emerald"><i class="fa-solid fa-users"></i></div>
            <div class="stat-label">User Management</div>
            <div class="stat-value" style="font-size: 1.2rem;">Manage Users</div>
            <div style="font-size: 0.75rem; color: #64748b;">Add, edit, or remove users</div>
        </a>

        <a href="{{ route('admin.settings.system') }}" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
            <div class="stat-icon rose"><i class="fa-solid fa-microchip"></i></div>
            <div class="stat-label">System</div>
            <div class="stat-value" style="font-size: 1.2rem;">Information</div>
            <div style="font-size: 0.75rem; color: #64748b;">System status and info</div>
        </a>
    </div>

    <div class="data-table-wrap">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">System Overview</div>
            <div class="section-sub">Quick statistics about your system</div>
        </div>
        <div style="padding: 20px 24px;">
            <div class="grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; text-align: center;">
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #0f172a;">{{ $totalUsers }}</div>
                    <div style="font-size: 12px; color: #64748b;">Total Users</div>
                </div>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #3b82f6;">{{ $totalAdmins }}</div>
                    <div style="font-size: 12px; color: #64748b;">Admins</div>
                </div>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #10b981;">{{ $totalCustomers }}</div>
                    <div style="font-size: 12px; color: #64748b;">Customers</div>
                </div>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #f59e0b;">{{ $totalCarpenters }}</div>
                    <div style="font-size: 12px; color: #64748b;">Carpenters</div>
                </div>
                <div>
                    <div style="font-size: 28px; font-weight: 700; color: #8b5cf6;">{{ $totalDelivery }}</div>
                    <div style="font-size: 12px; color: #64748b;">Delivery Staff</div>
                </div>
            </div>
        </div>
    </div>

    <div class="data-table-wrap" style="margin-top: 20px;">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">Quick Actions</div>
        </div>
        <div style="padding: 20px 24px;">
            <div class="grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <a href="{{ route('admin.settings.profile') }}" class="btn-view" style="text-align: center; padding: 12px;">Edit Profile</a>
                <a href="{{ route('admin.settings.security') }}" class="btn-view" style="text-align: center; padding: 12px;">Change Password</a>
                <a href="{{ route('admin.settings.users') }}" class="btn-view" style="text-align: center; padding: 12px;">Manage Users</a>
            </div>
        </div>
    </div>
</div>
@endsection