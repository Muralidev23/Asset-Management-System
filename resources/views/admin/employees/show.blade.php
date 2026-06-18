@extends('layouts.app')

@section('page-title', 'Employee Profile')
@section('breadcrumb', 'Home / Employees / Profile')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-id-card me-2" style="color:#6366f1;font-size:1.1rem;"></i>Employee Profile</h1>
        <p>Detailed view of employee account and their assigned assets.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Profile
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center" style="padding:32px;">

                {{-- Avatar --}}
                <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#06b6d4);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:2rem;font-weight:700;color:#fff;box-shadow:0 8px 24px rgba(99,102,241,.35);">
                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                </div>

                <h4 style="font-weight:700;margin-bottom:4px;">{{ $employee->name }}</h4>
                <span class="badge-pill badge-employee">{{ $employee->emp_role }}</span>

                <hr style="border-color:#f1f5f9;margin:20px 0;">

                {{-- Info list --}}
                <div class="text-start" style="font-size:.85rem;">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#6366f1;font-size:.8rem;">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Employee ID</div>
                            <div style="font-weight:600;">{{ $employee->emp_id }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(6,182,212,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#06b6d4;font-size:.8rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Email</div>
                            <div>{{ $employee->user->email ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#10b981;font-size:.8rem;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:600;">Department</div>
                            <div>{{ $employee->department }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
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

    {{-- Assigned Assets --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header" style="justify-content:space-between;">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:32px;height:32px;background:rgba(6,182,212,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                        <i class="fa-solid fa-laptop"></i>
                    </span>
                    Currently Assigned Assets
                </div>
                <span class="badge-pill" style="background:rgba(99,102,241,.1);color:#4f46e5;font-size:.72rem;">
                    {{ count($employee->assets) }} Assets
                </span>
            </div>
            <div class="card-body p-0">
                @if(count($employee->assets) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="ps-4">Asset ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Serial</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->assets as $asset)
                                    <tr>
                                        <td class="ps-4">
                                            <span style="font-size:.78rem;font-weight:700;background:rgba(99,102,241,.1);color:#4f46e5;padding:3px 10px;border-radius:20px;">
                                                {{ $asset->asset_id }}
                                            </span>
                                        </td>
                                        <td style="font-size:.875rem;font-weight:600;">{{ $asset->name }}</td>
                                        <td style="font-size:.82rem;color:#64748b;">{{ $asset->type }}</td>
                                        <td><code>{{ $asset->serial_number }}</code></td>
                                        <td class="pe-4 text-end">
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                    onclick="if(confirm('Are you sure you want to return this asset?')) { document.getElementById('ret-asset-{{ $asset->id }}').submit(); }">
                                                <i class="fa-solid fa-rotate-left me-1"></i> Return
                                            </button>
                                            <form id="ret-asset-{{ $asset->id }}" action="{{ route('assets.return', $asset->id) }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-laptop-code"></i></div>
                        <h5>No Assets Assigned</h5>
                        <p>This employee currently has no hardware or physical assets assigned. Go to Assets to assign one.</p>
                        <a href="{{ route('assets.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-laptop me-1"></i> View Assets
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
