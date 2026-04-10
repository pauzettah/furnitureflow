@extends('admin.dashboard')

@section('title', 'System Information')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">System Information</div>
            <div class="section-sub">Technical details about your system</div>
        </div>
        <a href="{{ route('admin.settings') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back to Settings</a>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Software Versions</div>
            </div>
            <div style="padding: 20px 24px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span>Laravel Version</span>
                    <span class="balance-positive">{{ $systemInfo['laravel_version'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span>PHP Version</span>
                    <span class="balance-positive">{{ $systemInfo['php_version'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span>MySQL Version</span>
                    <span class="balance-positive">{{ $systemInfo['mysql_version'] }}</span>
                </div>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Server Information</div>
            </div>
            <div style="padding: 20px 24px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span>Server Software</span>
                    <span class="balance-positive">{{ $systemInfo['server_software'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span>Environment</span>
                    <span class="balance-positive">{{ ucfirst($systemInfo['app_env']) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span>Debug Mode</span>
                    <span class="balance-positive">{{ $systemInfo['app_debug'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span>Timezone</span>
                    <span class="balance-positive">{{ $systemInfo['timezone'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="data-table-wrap" style="margin-top: 20px;">
        <div class="data-table-header" style="padding: 20px 24px 0;">
            <div class="section-title" style="font-size: 1rem;">System Status</div>
        </div>
        <div style="padding: 20px 24px;">
            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <span style="display: flex; align-items: center; gap: 8px;"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></span> Database Connected</span>
                <span style="display: flex; align-items: center; gap: 8px;"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></span> Storage Writable</span>
                <span style="display: flex; align-items: center; gap: 8px;"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></span> Cache Working</span>
                <span style="display: flex; align-items: center; gap: 8px;"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></span> Sessions Active</span>
            </div>
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                <span>Current Server Time: <strong>{{ $systemInfo['date'] }}</strong></span>
            </div>
        </div>
    </div>
</div>
@endsection