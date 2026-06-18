@extends('layouts.app')

@section('page-title', 'Edit Employee')
@section('breadcrumb', 'Home / Employees / Edit')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-pen-to-square me-2" style="color:#6366f1;font-size:1.1rem;"></i>Edit Employee</h1>
        <p>Update account credentials and profile details for <strong>{{ $employee->name }}</strong>.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Profile
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-pen-to-square" style="color:#6366f1;"></i>
                Update Employee: {{ $employee->name }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Account Credentials --}}
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#6366f1;border-left:3px solid #6366f1;padding-left:10px;margin-bottom:18px;">
                        <i class="fa-solid fa-lock me-1"></i> Account Credentials
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Full Name <span style="color:#ef4444">*</span></label>
                            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   name="name" value="{{ old('name', $employee->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email Address <span style="color:#ef4444">*</span></label>
                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   name="email" value="{{ old('email', $employee->user->email ?? '') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="password">
                                Change Password
                                <span style="font-weight:400;color:#94a3b8;font-size:.75rem;">(leave blank to keep current)</span>
                            </label>
                            <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   name="password" placeholder="Enter new password to reset it">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr style="border-color:#f1f5f9;margin:24px 0;">

                    {{-- Employee Profile --}}
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#6366f1;border-left:3px solid #6366f1;padding-left:10px;margin-bottom:18px;">
                        <i class="fa-solid fa-id-card me-1"></i> Employee Profile
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="emp_id">Employee ID <span style="color:#ef4444">*</span></label>
                            <input id="emp_id" type="text" class="form-control {{ $errors->has('emp_id') ? 'is-invalid' : '' }}"
                                   name="emp_id" value="{{ old('emp_id', $employee->emp_id) }}" required>
                            @error('emp_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="doj">Date of Joining <span style="color:#ef4444">*</span></label>
                            <input id="doj" type="date" class="form-control {{ $errors->has('doj') ? 'is-invalid' : '' }}"
                                   name="doj" value="{{ old('doj', $employee->doj) }}" required>
                            @error('doj') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="department">Department <span style="color:#ef4444">*</span></label>
                            <input id="department" type="text" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}"
                                   name="department" value="{{ old('department', $employee->department) }}" required>
                            @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="designation">Designation <span style="color:#ef4444">*</span></label>
                            <input id="designation" type="text" class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}"
                                   name="designation" value="{{ old('designation', $employee->designation) }}" required>
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="emp_role">Role / Specialty <span style="color:#ef4444">*</span></label>
                            <input id="emp_role" type="text" class="form-control {{ $errors->has('emp_role') ? 'is-invalid' : '' }}"
                                   name="emp_role" value="{{ old('emp_role', $employee->emp_role) }}" required>
                            @error('emp_role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <a href="{{ route('employees.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
