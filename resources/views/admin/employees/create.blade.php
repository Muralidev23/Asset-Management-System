@extends('layouts.app')

@section('page-title', 'Add Employee')
@section('breadcrumb', 'Home / Employees / Add')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-user-plus me-2" style="color:#6366f1;font-size:1.1rem;"></i>Add New Employee</h1>
        <p>Create a user login account and employee profile details manually.</p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-user-plus" style="color:#6366f1;"></i>
                Employee Information
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf

                    {{-- Account Credentials --}}
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#6366f1;border-left:3px solid #6366f1;padding-left:10px;margin-bottom:18px;">
                        <i class="fa-solid fa-lock me-1"></i> Account Credentials
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Full Name <span style="color:#ef4444">*</span></label>
                            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email Address <span style="color:#ef4444">*</span></label>
                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required placeholder="john.doe@company.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="password">Temporary Password <span style="color:#ef4444">*</span></label>
                            <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   name="password" required placeholder="Choose a temporary password (min 8 characters)">
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
                                   name="emp_id" value="{{ old('emp_id') }}" required placeholder="e.g. EMP-001">
                            @error('emp_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="doj">Date of Joining <span style="color:#ef4444">*</span></label>
                            <input id="doj" type="date" class="form-control {{ $errors->has('doj') ? 'is-invalid' : '' }}"
                                   name="doj" value="{{ old('doj') }}" required>
                            @error('doj') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="department">Department <span style="color:#ef4444">*</span></label>
                            <input id="department" type="text" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}"
                                   name="department" value="{{ old('department') }}" required placeholder="e.g. Technology">
                            @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="designation">Designation <span style="color:#ef4444">*</span></label>
                            <input id="designation" type="text" class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}"
                                   name="designation" value="{{ old('designation') }}" required placeholder="e.g. Software Engineer">
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="emp_role">Role / Specialty <span style="color:#ef4444">*</span></label>
                            <input id="emp_role" type="text" class="form-control {{ $errors->has('emp_role') ? 'is-invalid' : '' }}"
                                   name="emp_role" value="{{ old('emp_role') }}" required placeholder="e.g. Full Stack Developer">
                            @error('emp_role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <a href="{{ route('employees.index') }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-user-plus me-1"></i> Create Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
