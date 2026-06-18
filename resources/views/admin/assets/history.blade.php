@extends('layouts.app')

@section('page-title', 'Asset History')
@section('breadcrumb', 'Home / Assets / History')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-clock-rotate-left me-2" style="color:#8b5cf6;font-size:1.1rem;"></i>Asset History</h1>
        <p>Full assignment and return timeline for <strong>{{ $asset->name }}</strong>.</p>
    </div>
    <a href="{{ route('assets.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Assets
    </a>
</div>

<div class="row g-4">

    {{-- Asset Info --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(6,182,212,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                    <i class="fa-solid fa-laptop"></i>
                </span>
                Asset Specifications
            </div>
            <div class="card-body" style="font-size:.85rem;">
                <div class="d-flex flex-column gap-4">
                    <div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;margin-bottom:3px;">Asset ID</div>
                        <span style="font-weight:700;font-size:1rem;background:rgba(6,182,212,.1);color:#0e7490;padding:4px 12px;border-radius:20px;">{{ $asset->asset_id }}</span>
                    </div>
                    <div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;margin-bottom:3px;">Asset Name</div>
                        <div style="font-weight:600;">{{ $asset->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;margin-bottom:3px;">Type</div>
                        <div>{{ $asset->type }}</div>
                    </div>
                    <div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;margin-bottom:3px;">Serial Number</div>
                        <code>{{ $asset->serial_number }}</code>
                    </div>
                    <div>
                        <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;margin-bottom:6px;">Current Status</div>
                        @if($asset->status === 'available')
                            <span class="badge-pill badge-available">
                                <i class="fa-solid fa-circle" style="font-size:.5rem;"></i> Available
                            </span>
                        @else
                            <span class="badge-pill badge-assigned">
                                <i class="fa-solid fa-circle" style="font-size:.5rem;"></i> Assigned to {{ $asset->employee->name ?? 'Unknown' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- History Timeline --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="justify-content:space-between;">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:32px;height:32px;background:rgba(139,92,246,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#8b5cf6;font-size:.8rem;">
                        <i class="fa-solid fa-timeline"></i>
                    </span>
                    Assignment Logs
                </div>
                @if($asset->history && count($asset->history) > 0)
                    <span class="badge-pill" style="background:rgba(99,102,241,.1);color:#4f46e5;">
                        {{ count($asset->history) }} events
                    </span>
                @endif
            </div>
            <div class="card-body p-0">
                @if($asset->history && count($asset->history) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Event</th>
                                    <th>Employee</th>
                                    <th>Date & Time</th>
                                    <th class="pe-4">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(array_reverse($asset->history) as $idx => $log)
                                    <tr>
                                        <td class="ps-4" style="font-size:.78rem;color:#94a3b8;font-weight:600;">{{ $idx + 1 }}</td>
                                        <td>
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
                                            @if(!empty($log['employee_id']))
                                                <a href="{{ route('employees.show', $log['employee_id']) }}"
                                                   style="color:#6366f1;text-decoration:none;font-weight:600;font-size:.85rem;">
                                                    {{ $log['employee_name'] }}
                                                </a>
                                            @else
                                                <span style="font-size:.85rem;">{{ $log['employee_name'] }}</span>
                                            @endif
                                        </td>
                                        <td style="font-size:.8rem;color:#64748b;">
                                            {{ \Carbon\Carbon::parse($log['date'])->format('d M, Y h:i A') }}
                                        </td>
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
                        <p>No assignment or return events have been recorded for this asset. Assign it to an employee to start tracking.</p>
                        <a href="{{ route('assets.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-laptop me-1"></i> Go to Assets
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
