@extends('layouts.app')

@section('page-title', 'Assets Inventory')
@section('breadcrumb', 'Home / Assets')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-laptop me-2" style="color:#06b6d4;font-size:1.2rem;"></i>Assets Inventory</h1>
        <p>Manage company assets, assign them to employees, or return them to the pool.</p>
    </div>
    <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Add Asset
    </a>
</div>

<div class="card">
    @if(count($assets) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="ps-4">Asset ID</th>
                        <th>Name & Type</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th class="pe-4 text-end" style="min-width:260px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr>
                            <td class="ps-4">
                                <span style="font-size:.8rem;font-weight:700;background:rgba(6,182,212,.1);color:#0e7490;padding:3px 10px;border-radius:20px;">
                                    {{ $asset->asset_id }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size:.875rem;font-weight:600;">{{ $asset->name }}</div>
                                <div style="font-size:.72rem;color:#64748b;">{{ $asset->type }}</div>
                            </td>
                            <td><code>{{ $asset->serial_number }}</code></td>
                            <td>
                                @if($asset->status === 'available')
                                    <span class="badge-pill badge-available">
                                        <i class="fa-solid fa-circle" style="font-size:.5rem;"></i> Available
                                    </span>
                                @else
                                    <span class="badge-pill badge-assigned">
                                        <i class="fa-solid fa-circle" style="font-size:.5rem;"></i> Assigned
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($asset->employee)
                                    <div>
                                        <a href="{{ route('employees.show', $asset->employee->id) }}"
                                           style="font-size:.85rem;font-weight:600;color:#6366f1;text-decoration:none;">
                                            {{ $asset->employee->name }}
                                        </a>
                                        <div style="font-size:.72rem;color:#94a3b8;">{{ $asset->employee->emp_id }}</div>
                                    </div>
                                @else
                                    <span style="font-size:.82rem;color:#94a3b8;">—</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="d-flex align-items-center justify-content-end gap-2 flex-wrap">

                                    {{-- Assign / Return --}}
                                    @if($asset->status === 'available')
                                        <form action="{{ route('assets.assign', $asset->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                            @csrf
                                            <select name="employee_id" class="form-select form-select-sm" style="width:130px;" required>
                                                <option value="" disabled selected>Assign to…</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->emp_id }})</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-success btn-sm" title="Assign Asset">
                                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>Assign
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('assets.return', $asset->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning"
                                                    onclick="return confirm('Return this asset to the available pool?')">
                                                <i class="fa-solid fa-rotate-left me-1"></i> Return
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Actions --}}
                                    <a href="{{ route('assets.history', $asset->id) }}" class="btn btn-sm btn-outline-info" title="View History">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </a>
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Asset">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                            onclick="if(confirm('Delete this asset permanently?')) { document.getElementById('del-asset-{{ $asset->id }}').submit(); }">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <form id="del-asset-{{ $asset->id }}" action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-laptop-code"></i></div>
            <h5>No Assets Yet</h5>
            <p>Start by adding company hardware assets such as laptops, keyboards, and monitors.</p>
            <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Add First Asset
            </a>
        </div>
    @endif
</div>
@endsection
