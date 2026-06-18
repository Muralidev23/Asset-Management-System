@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Home / Dashboard')

@push('styles')
<style>
    /* ─── Gradient stat cards ──────────────────────── */
    .stat-grad-card {
        border-radius: 16px;
        padding: 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,.15);
        transition: transform .22s, box-shadow .22s;
    }
    .stat-grad-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 40px rgba(0,0,0,.2);
    }
    .stat-grad-card::after {
        content: '';
        position: absolute;
        right: -20px; top: -20px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,.12);
    }
    .stat-grad-card::before {
        content: '';
        position: absolute;
        right: 30px; bottom: -30px;
        width: 70px; height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
    }
    .sgc-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 14px;
    }
    .sgc-value { font-size: 2.2rem; font-weight: 800; line-height: 1; }
    .sgc-label { font-size: .78rem; font-weight: 500; opacity: .85; margin-top: 4px; }
    .sgc-link  { font-size: .75rem; opacity: .8; text-decoration: none; color: #fff; margin-top: 10px; display: inline-flex; align-items: center; gap: 4px; }
    .sgc-link:hover { opacity: 1; color: #fff; }

    .grad-purple { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); }
    .grad-teal   { background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); }
    .grad-green  { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .grad-amber  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

    /* ─── Chart wrappers ─────────────────────────── */
    .chart-card { border-radius: 16px; background: #fff; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
    .chart-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px 0;
    }
    .chart-title { font-size: .95rem; font-weight: 700; color: #1e293b; }
    .chart-subtitle { font-size: .75rem; color: #94a3b8; margin-top: 2px; }
    .chart-body { padding: 16px 22px 22px; }

    /* ─── Activity table ─────────────────────────── */
    .activity-dot {
        width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }
    .dot-assigned { background: #6366f1; }
    .dot-returned { background: #10b981; }

    /* ─── Progress bar ───────────────────────────── */
    .utilisation-bar { background: #f1f5f9; border-radius: 20px; height: 8px; overflow: hidden; }
    .utilisation-fill { height: 100%; border-radius: 20px; background: linear-gradient(90deg,#6366f1,#06b6d4); transition: width .6s ease; }

    /* ─── Mini KPI strip ─────────────────────────── */
    .kpi-strip {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        border-radius: 16px;
        padding: 20px 28px;
        display: flex; align-items: center; gap: 32px;
        flex-wrap: wrap;
        box-shadow: 0 8px 32px rgba(0,0,0,.2);
    }
    .kpi-item { flex: 1; min-width: 120px; }
    .kpi-value { font-size: 1.6rem; font-weight: 800; color: #f8fafc; }
    .kpi-label { font-size: .7rem; color: #64748b; text-transform: uppercase; letter-spacing: .07em; margin-top: 2px; }
    .kpi-divider { width: 1px; height: 40px; background: rgba(255,255,255,.08); }
</style>
@endpush

@section('content')

{{-- ── KPI Strip ─────────────────────────────────────────────── --}}
<div class="kpi-strip mb-4">
    <div class="kpi-item">
        <div class="kpi-value">{{ $employeeCount }}</div>
        <div class="kpi-label"><i class="fa-solid fa-users me-1" style="color:#6366f1;"></i>Total Employees</div>
    </div>
    <div class="kpi-divider d-none d-md-block"></div>
    <div class="kpi-item">
        <div class="kpi-value">{{ $assetCount }}</div>
        <div class="kpi-label"><i class="fa-solid fa-laptop me-1" style="color:#06b6d4;"></i>Total Assets</div>
    </div>
    <div class="kpi-divider d-none d-md-block"></div>
    <div class="kpi-item">
        <div class="kpi-value">{{ $assignedCount }}</div>
        <div class="kpi-label"><i class="fa-solid fa-user-tag me-1" style="color:#10b981;"></i>Assigned Assets</div>
    </div>
    <div class="kpi-divider d-none d-md-block"></div>
    <div class="kpi-item">
        <div class="kpi-value">{{ $availableCount }}</div>
        <div class="kpi-label"><i class="fa-solid fa-circle-check me-1" style="color:#f59e0b;"></i>Available Assets</div>
    </div>
    @if($assetCount > 0)
    <div class="kpi-divider d-none d-md-block"></div>
    <div class="kpi-item">
        <div class="kpi-value">{{ round(($assignedCount / $assetCount) * 100) }}%</div>
        <div class="kpi-label"><i class="fa-solid fa-chart-pie me-1" style="color:#8b5cf6;"></i>Utilisation Rate</div>
    </div>
    @endif
</div>

{{-- ── Gradient Stat Cards ───────────────────────────────────── --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-grad-card grad-purple">
            <div class="sgc-icon"><i class="fa-solid fa-users"></i></div>
            <div class="sgc-value">{{ $employeeCount }}</div>
            <div class="sgc-label">Total Employees</div>
            <a href="{{ route('employees.index') }}" class="sgc-link">
                View all employees <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-grad-card grad-teal">
            <div class="sgc-icon"><i class="fa-solid fa-laptop"></i></div>
            <div class="sgc-value">{{ $assetCount }}</div>
            <div class="sgc-label">Total Assets</div>
            <a href="{{ route('assets.index') }}" class="sgc-link">
                Manage inventory <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-grad-card grad-green">
            <div class="sgc-icon"><i class="fa-solid fa-user-tag"></i></div>
            <div class="sgc-value">{{ $assignedCount }}</div>
            <div class="sgc-label">Assigned Assets</div>
            <span class="sgc-link">Currently in use</span>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-grad-card grad-amber">
            <div class="sgc-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="sgc-value">{{ $availableCount }}</div>
            <div class="sgc-label">Available Assets</div>
            <span class="sgc-link">Ready to assign</span>
        </div>
    </div>
</div>

{{-- ── Charts Row ────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- Donut chart: Asset Status --}}
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Asset Distribution</div>
                    <div class="chart-subtitle">Assigned vs Available inventory</div>
                </div>
                <span style="width:32px;height:32px;background:rgba(99,102,241,.1);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#6366f1;font-size:.8rem;">
                    <i class="fa-solid fa-chart-pie"></i>
                </span>
            </div>
            <div class="chart-body">
                <canvas id="assetDonut" style="max-height:200px;"></canvas>
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <div class="d-flex align-items-center gap-2" style="font-size:.78rem;">
                        <span style="width:10px;height:10px;border-radius:50%;background:#6366f1;"></span>
                        <span class="text-muted">Assigned ({{ $assignedCount }})</span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:.78rem;">
                        <span style="width:10px;height:10px;border-radius:50%;background:#10b981;"></span>
                        <span class="text-muted">Available ({{ $availableCount }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bar chart: Assets per month (uses recent activity data) --}}
    <div class="col-lg-8">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Asset Activity Timeline</div>
                    <div class="chart-subtitle">Assignments & returns over time</div>
                </div>
                <span style="width:32px;height:32px;background:rgba(6,182,212,.1);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                    <i class="fa-solid fa-chart-bar"></i>
                </span>
            </div>
            <div class="chart-body">
                <canvas id="activityBar" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ── Utilisation + Quick Actions Row ──────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- Utilisation card --}}
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Asset Utilisation</div>
                    <div class="chart-subtitle">Current stock breakdown</div>
                </div>
            </div>
            <div class="chart-body">
                @php
                    $total = max($assetCount, 1);
                    $assignedPct = round(($assignedCount / $total) * 100);
                    $availablePct = round(($availableCount / $total) * 100);
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size:.8rem;font-weight:600;">Assigned</span>
                        <span style="font-size:.78rem;color:#6366f1;font-weight:700;">{{ $assignedPct }}%</span>
                    </div>
                    <div class="utilisation-bar">
                        <div class="utilisation-fill" style="width:{{ $assignedPct }}%;background:linear-gradient(90deg,#6366f1,#8b5cf6);"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size:.8rem;font-weight:600;">Available</span>
                        <span style="font-size:.78rem;color:#10b981;font-weight:700;">{{ $availablePct }}%</span>
                    </div>
                    <div class="utilisation-bar">
                        <div class="utilisation-fill" style="width:{{ $availablePct }}%;background:linear-gradient(90deg,#10b981,#34d399);"></div>
                    </div>
                </div>

                <hr style="border-color:#f1f5f9;">

                <div class="row text-center g-2">
                    <div class="col-6">
                        <div style="font-size:1.4rem;font-weight:800;color:#6366f1;">{{ $assignedCount }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">In Use</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:1.4rem;font-weight:800;color:#10b981;">{{ $availableCount }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;">Free</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Quick Actions</div>
                    <div class="chart-subtitle">Common administrative tasks</div>
                </div>
                <span style="width:32px;height:32px;background:rgba(245,158,11,.1);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#f59e0b;font-size:.8rem;">
                    <i class="fa-solid fa-bolt"></i>
                </span>
            </div>
            <div class="chart-body d-flex flex-column gap-3">
                <a href="{{ route('employees.create') }}" class="btn btn-outline-primary text-start py-3 px-4 d-flex align-items-center gap-3" style="border-radius:12px;">
                    <span style="width:36px;height:36px;background:rgba(99,102,241,.1);border-radius:9px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-user-plus" style="color:#6366f1;font-size:.85rem;"></i>
                    </span>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;">Add Employee</div>
                        <div style="font-size:.72rem;color:#64748b;">Create a single profile</div>
                    </div>
                </a>
                <a href="{{ route('employees.upload') }}" class="btn btn-ghost text-start py-3 px-4 d-flex align-items-center gap-3" style="border-radius:12px;">
                    <span style="width:36px;height:36px;background:rgba(6,182,212,.1);border-radius:9px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-file-arrow-up" style="color:#06b6d4;font-size:.85rem;"></i>
                    </span>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;">Bulk Upload</div>
                        <div style="font-size:.72rem;color:#64748b;">Import from CSV</div>
                    </div>
                </a>
                <a href="{{ route('assets.create') }}" class="btn btn-ghost text-start py-3 px-4 d-flex align-items-center gap-3" style="border-radius:12px;">
                    <span style="width:36px;height:36px;background:rgba(16,185,129,.1);border-radius:9px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-plus-circle" style="color:#10b981;font-size:.85rem;"></i>
                    </span>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;">Add Asset</div>
                        <div style="font-size:.72rem;color:#64748b;">Register a new device</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- System summary --}}
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">System Summary</div>
                    <div class="chart-subtitle">Key metrics at a glance</div>
                </div>
            </div>
            <div class="chart-body d-flex flex-column gap-3">
                @php
                    $recentCount = count($recentActivities);
                    $assignEvents = collect($recentActivities)->where('action', 'assigned')->count();
                    $returnEvents = collect($recentActivities)->where('action', 'returned')->count();
                @endphp

                <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:.8rem;">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.82rem;font-weight:600;">Recent Assignments</div>
                        <div style="font-size:.72rem;color:#64748b;">From latest 5 activities</div>
                    </div>
                    <div style="font-size:1.2rem;font-weight:800;color:#6366f1;">{{ $assignEvents }}</div>
                </div>

                <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#10b981,#34d399);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:.8rem;">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.82rem;font-weight:600;">Recent Returns</div>
                        <div style="font-size:.72rem;color:#64748b;">From latest 5 activities</div>
                    </div>
                    <div style="font-size:1.2rem;font-weight:800;color:#10b981;">{{ $returnEvents }}</div>
                </div>

                <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:.8rem;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.82rem;font-weight:600;">Activity Log Entries</div>
                        <div style="font-size:.72rem;color:#64748b;">Total recent events tracked</div>
                    </div>
                    <div style="font-size:1.2rem;font-weight:800;color:#f59e0b;">{{ $recentCount }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Recent Activities Table ───────────────────────────────── --}}
<div class="chart-card">
    <div class="chart-header" style="padding-bottom:0;">
        <div>
            <div class="chart-title">Recent Asset Activity</div>
            <div class="chart-subtitle">Latest 5 assignment and return events across all assets</div>
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-outline-primary btn-sm" style="font-size:.78rem;">
            View All Assets <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div style="padding:0 0 4px;">
        @if(count($recentActivities) > 0)
            <div class="table-responsive">
                <table class="table table-hover" style="margin:0;">
                    <thead>
                        <tr>
                            <th class="ps-4">Asset</th>
                            <th>Type</th>
                            <th>Action</th>
                            <th>Employee</th>
                            <th class="pe-4">When</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivities as $activity)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $activity['action'] === 'assigned' ? '#6366f1' : '#10b981' }};flex-shrink:0;"></div>
                                        <div>
                                            <div style="font-size:.875rem;font-weight:600;">{{ $activity['asset_name'] }}</div>
                                            <div style="font-size:.72rem;color:#94a3b8;">{{ $activity['asset_id_code'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size:.75rem;background:#f1f5f9;color:#374151;padding:3px 10px;border-radius:20px;font-weight:500;">
                                        {{ $activity['asset_type'] ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @if($activity['action'] === 'assigned')
                                        <span class="badge-pill badge-assigned">
                                            <i class="fa-solid fa-arrow-right-to-bracket" style="font-size:.6rem;"></i> Assigned
                                        </span>
                                    @else
                                        <span class="badge-pill badge-available">
                                            <i class="fa-solid fa-rotate-left" style="font-size:.6rem;"></i> Returned
                                        </span>
                                    @endif
                                </td>
                                <td style="font-size:.875rem;font-weight:500;">{{ $activity['employee_name'] }}</td>
                                <td class="pe-4" style="font-size:.78rem;color:#64748b;">
                                    {{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state" style="padding:48px 20px;">
                <div class="empty-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h5>No Activity Yet</h5>
                <p>Asset assignment and return logs will appear here once you start managing assets.</p>
                <a href="{{ route('assets.index') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-laptop me-1"></i> Go to Assets
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Shared defaults ──────────────────────────────────────────
Chart.defaults.font.family = "'Poppins', sans-serif";
Chart.defaults.color = '#94a3b8';

// ── Donut: Asset Status ──────────────────────────────────────
const donutCtx = document.getElementById('assetDonut').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Assigned', 'Available'],
        datasets: [{
            data: [{{ $assignedCount }}, {{ $availableCount }}],
            backgroundColor: ['#6366f1', '#10b981'],
            hoverBackgroundColor: ['#4f46e5', '#059669'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        animation: { animateRotate: true, duration: 900 },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed} assets`
                }
            }
        }
    }
});

// ── Bar: Activity per recent events ─────────────────────────
// Build label/count from Blade data
const rawActivities = @json($recentActivities);

// Group by date (day) for assigned vs returned
const dayMap = {};
rawActivities.forEach(a => {
    const d = new Date(a.date);
    const label = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
    if (!dayMap[label]) dayMap[label] = { assigned: 0, returned: 0 };
    if (a.action === 'assigned') dayMap[label].assigned++;
    else dayMap[label].returned++;
});
const barLabels = Object.keys(dayMap);
const assignedData = barLabels.map(l => dayMap[l].assigned);
const returnedData = barLabels.map(l => dayMap[l].returned);

const barCtx = document.getElementById('activityBar').getContext('2d');

// Gradient for assigned bars
const g1 = barCtx.createLinearGradient(0, 0, 0, 200);
g1.addColorStop(0, 'rgba(99,102,241,.9)');
g1.addColorStop(1, 'rgba(99,102,241,.4)');

const g2 = barCtx.createLinearGradient(0, 0, 0, 200);
g2.addColorStop(0, 'rgba(16,185,129,.9)');
g2.addColorStop(1, 'rgba(16,185,129,.4)');

new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: barLabels.length > 0 ? barLabels : ['No data yet'],
        datasets: [
            {
                label: 'Assigned',
                data: assignedData.length > 0 ? assignedData : [0],
                backgroundColor: g1,
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Returned',
                data: returnedData.length > 0 ? returnedData : [0],
                backgroundColor: g2,
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        animation: { duration: 900, easing: 'easeOutQuart' },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { font: { size: 11 } }
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,.04)' },
                border: { display: false },
                ticks: { stepSize: 1, font: { size: 11 } }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: { boxWidth: 10, boxHeight: 10, borderRadius: 5, useBorderRadius: true, font: { size: 12 } }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} event(s)`
                }
            }
        }
    }
});
</script>
@endpush
