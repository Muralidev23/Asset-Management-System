@extends('layouts.app')

@section('page-title', 'Employees')
@section('breadcrumb', 'Home / Employees')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-users me-2" style="color:#6366f1;font-size:1.2rem;"></i>All Employees</h1>
        <p>Manage employee profiles, create new records or do a bulk CSV import.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('employees.upload') }}" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-file-arrow-up me-1"></i> Bulk Upload
        </a>
        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Add Employee
        </a>
    </div>
</div>

<div class="card">
    @if(count($employees) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="ps-4">Emp ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Joined</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td class="ps-4">
                                <span style="font-size:.8rem;font-weight:700;background:rgba(99,102,241,.1);color:#4f46e5;padding:3px 10px;border-radius:20px;">
                                    {{ $employee->emp_id }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#06b6d4);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.75rem;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size:.875rem;font-weight:600;">{{ $employee->name }}</div>
                                        <div style="font-size:.72rem;color:#64748b;">{{ $employee->emp_role ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:.82rem;color:#64748b;">{{ $employee->user->email ?? 'N/A' }}</td>
                            <td style="font-size:.85rem;">{{ $employee->department }}</td>
                            <td style="font-size:.85rem;">{{ $employee->designation }}</td>
                            <td style="font-size:.82rem;color:#64748b;">{{ \Carbon\Carbon::parse($employee->doj)->format('d M, Y') }}</td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-info" title="View Profile">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Profile">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                            onclick="if(confirm('Are you sure you want to delete this employee? This will also delete their login account and return all assigned assets.')) { document.getElementById('del-emp-{{ $employee->id }}').submit(); }">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <form id="del-emp-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-none">
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
            <div class="empty-icon"><i class="fa-solid fa-users"></i></div>
            <h5>No Employees Yet</h5>
            <p>Start by creating an employee profile or upload records in bulk from a CSV file.</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="{{ route('employees.upload') }}" class="btn btn-ghost btn-sm">
                    <i class="fa-solid fa-file-arrow-up me-1"></i> Bulk Upload
                </a>
                <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-1"></i> Add Employee
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
