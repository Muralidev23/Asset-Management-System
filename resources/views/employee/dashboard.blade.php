@extends('layouts.app')

@section('page-title', 'My Dashboard')
@section('breadcrumb', 'Home / My Dashboard')

@section('content')

{{-- Welcome Header --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:16px;padding:28px 32px;margin-bottom:28px;display:flex;align-items:center;gap:20px;">
    <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#06b6d4);display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;color:#fff;flex-shrink:0;box-shadow:0 8px 24px rgba(99,102,241,.5);">
        {{ strtoupper(substr($employee->name, 0, 1)) }}
    </div>
    <div>
        <h2 style="font-size:1.4rem;font-weight:700;color:#f8fafc;margin:0 0 4px;">Hello, {{ $employee->name }} 👋</h2>
        <p style="font-size:.85rem;color:#94a3b8;margin:0;">
            {{ $employee->designation }} · {{ $employee->department }}
            · Joined {{ \Carbon\Carbon::parse($employee->doj)->format('d M Y') }}
        </p>
    </div>
    <div class="ms-auto d-none d-md-flex gap-3">
        <div style="text-align:center;">
            <div style="font-size:1.5rem;font-weight:700;color:#f8fafc;">{{ count($assignedAssets) }}</div>
            <div style="font-size:.72rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Active Assets</div>
        </div>
        <div style="width:1px;background:rgba(255,255,255,.1);"></div>
        <div style="text-align:center;">
            <div style="font-size:1.5rem;font-weight:700;color:#f8fafc;">{{ count($myHistory) }}</div>
            <div style="font-size:.72rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Total Events</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(99,102,241,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#6366f1;font-size:.8rem;">
                    <i class="fa-solid fa-id-card"></i>
                </span>
                My Employee Profile
            </div>
            <div class="card-body" style="font-size:.85rem;">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#6366f1;font-size:.8rem;">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Employee ID</div>
                            <div style="font-weight:600;">{{ $employee->emp_id }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(6,182,212,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#06b6d4;font-size:.8rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Email</div>
                            <div>{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#10b981;font-size:.8rem;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Department</div>
                            <div>{{ $employee->department }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(245,158,11,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#f59e0b;font-size:.8rem;">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Designation</div>
                            <div>{{ $employee->designation }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#8b5cf6;font-size:.8rem;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Joined</div>
                            <div>{{ \Carbon\Carbon::parse($employee->doj)->format('d M, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Assets --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(6,182,212,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                    <i class="fa-solid fa-laptop"></i>
                </span>
                Active Assets Assigned to Me
                @if(count($assignedAssets) > 0)
                    <span class="badge-pill ms-2" style="background:rgba(16,185,129,.12);color:#065f46;font-size:.7rem;">{{ count($assignedAssets) }} active</span>
                @endif
            </div>
            <div class="card-body p-0">
                @if(count($assignedAssets) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="ps-4">Asset ID</th>
                                    <th>Name & Type</th>
                                    <th>Serial</th>
                                    <th class="pe-4">Assigned On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedAssets as $asset)
                                    @php
                                        $assignDate = null;
                                        if ($asset->history) {
                                            foreach ($asset->history as $log) {
                                                if ($log['action'] === 'assigned' && $log['employee_id'] == $employee->id) {
                                                    $assignDate = $log['date'];
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span style="font-size:.78rem;font-weight:700;background:rgba(6,182,212,.1);color:#0e7490;padding:3px 10px;border-radius:20px;">
                                                {{ $asset->asset_id }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size:.875rem;font-weight:600;">{{ $asset->name }}</div>
                                            <div style="font-size:.72rem;color:#64748b;">{{ $asset->type }}</div>
                                        </td>
                                        <td><code>{{ $asset->serial_number }}</code></td>
                                        <td class="pe-4" style="font-size:.82rem;color:#64748b;">
                                            {{ $assignDate ? \Carbon\Carbon::parse($assignDate)->format('d M, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-laptop-code"></i></div>
                        <h5>No Active Assets</h5>
                        <p>You do not have any hardware assets assigned to you. Contact your admin if you need equipment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- History --}}
<div class="card">
    <div class="card-header">
        <span style="width:32px;height:32px;background:rgba(139,92,246,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#8b5cf6;font-size:.8rem;">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </span>
        My Asset Allocation History
    </div>
    <div class="card-body p-0">
        @if(count($myHistory) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Asset ID</th>
                            <th>Asset Name</th>
                            <th>Date & Time</th>
                            <th class="pe-4">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myHistory as $log)
                            <tr>
                                <td class="ps-4">
                                    @if($log['action'] === 'assigned')
                                        <span class="badge-pill badge-assigned">
                                            <i class="fa-solid fa-arrow-right-to-bracket" style="font-size:.65rem;"></i> Assigned
                                        </span>
                                    @else
                                        <span class="badge-pill badge-available">
                                            <i class="fa-solid fa-rotate-left" style="font-size:.65rem;"></i> Returned
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-size:.78rem;font-weight:700;background:rgba(6,182,212,.1);color:#0e7490;padding:3px 10px;border-radius:20px;">
                                        {{ $log['asset_id_code'] }}
                                    </span>
                                </td>
                                <td style="font-size:.875rem;">{{ $log['asset_name'] }}</td>
                                <td style="font-size:.8rem;color:#64748b;">{{ \Carbon\Carbon::parse($log['date'])->format('d M, Y h:i A') }}</td>
                                <td class="pe-4" style="font-size:.8rem;color:#64748b;">{{ $log['notes'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h5>No History Yet</h5>
                <p>Your asset assignment and return events will appear here.</p>
            </div>
        @endif
    </div>
</div>

@endsection
