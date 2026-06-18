@extends('layouts.app')

@section('page-title', 'Bulk Upload')
@section('breadcrumb', 'Home / Employees / Bulk Upload')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-file-arrow-up me-2" style="color:#6366f1;font-size:1.1rem;"></i>Bulk Upload Employees</h1>
        <p>Import multiple employee records by uploading a filled CSV template.</p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row g-4 justify-content-center">

    {{-- Instructions card --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(6,182,212,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                    <i class="fa-solid fa-circle-info"></i>
                </span>
                How it Works
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex gap-3">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">1</div>
                        <div>
                            <div style="font-size:.85rem;font-weight:600;margin-bottom:2px;">Download Template</div>
                            <div style="font-size:.78rem;color:#64748b;">Get the CSV template with the correct column headers.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#06b6d4,#0284c7);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">2</div>
                        <div>
                            <div style="font-size:.85rem;font-weight:600;margin-bottom:2px;">Fill Employee Data</div>
                            <div style="font-size:.78rem;color:#64748b;">Edit the file in Excel/Sheets. Add one employee per row.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#10b981,#059669);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">3</div>
                        <div>
                            <div style="font-size:.85rem;font-weight:600;margin-bottom:2px;">Upload & Import</div>
                            <div style="font-size:.78rem;color:#64748b;">Upload the saved .csv file to create all accounts at once.</div>
                        </div>
                    </div>
                </div>

                <hr style="border-color:#f1f5f9;margin:24px 0;">

                <div style="font-size:.78rem;font-weight:600;color:#374151;margin-bottom:10px;">Required CSV Columns:</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['name','email','password','emp_id','department','designation','emp_role','doj'] as $col)
                        <code>{{ $col }}</code>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('employees.download-template') }}" class="btn btn-outline-primary w-100">
                        <i class="fa-solid fa-file-arrow-down me-2"></i> Download CSV Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload card --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(16,185,129,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#10b981;font-size:.8rem;">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </span>
                Upload CSV File
            </div>
            <div class="card-body">

                @if(session('import_errors'))
                    <div class="alert alert-danger alert-dismissible mb-4">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <strong>Import Aborted — Validation Errors:</strong>
                            <ul class="mb-0 mt-2 small" style="max-height:150px;overflow:auto;">
                                @foreach(session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('employees.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Drop zone --}}
                    <div id="drop-zone" style="border:2px dashed #e2e8f0;border-radius:12px;padding:48px 24px;text-align:center;cursor:pointer;transition:all .2s;background:#fafafa;"
                         onclick="document.getElementById('csv_file').click();"
                         ondragover="event.preventDefault();this.style.borderColor='#6366f1';this.style.background='rgba(99,102,241,.05)';"
                         ondragleave="this.style.borderColor='#e2e8f0';this.style.background='#fafafa';"
                         ondrop="handleDrop(event)">
                        <div style="width:60px;height:60px;background:rgba(99,102,241,.1);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.6rem;color:#6366f1;">
                            <i class="fa-solid fa-file-csv"></i>
                        </div>
                        <div style="font-size:.9rem;font-weight:600;color:#374151;margin-bottom:4px;">
                            Drag & drop your CSV file here
                        </div>
                        <div style="font-size:.78rem;color:#94a3b8;">or click to browse your computer</div>
                        <div id="file-name" style="margin-top:12px;font-size:.8rem;color:#6366f1;font-weight:500;display:none;"></div>
                    </div>

                    <input class="d-none {{ $errors->has('csv_file') ? 'is-invalid' : '' }}"
                           type="file" id="csv_file" name="csv_file" accept=".csv" required
                           onchange="showFileName(this)">
                    @error('csv_file')
                        <div style="font-size:.75rem;color:#ef4444;margin-top:6px;">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100 mt-4">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Start Importing Employees
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function showFileName(input) {
        if (input.files && input.files[0]) {
            const el = document.getElementById('file-name');
            el.textContent = '📎 ' + input.files[0].name;
            el.style.display = 'block';
            document.getElementById('drop-zone').style.borderColor = '#6366f1';
            document.getElementById('drop-zone').style.background = 'rgba(99,102,241,.05)';
        }
    }
    function handleDrop(e) {
        e.preventDefault();
        const dt = e.dataTransfer;
        if (dt.files.length) {
            const input = document.getElementById('csv_file');
            const dz = document.getElementById('drop-zone');
            input.files = dt.files;
            showFileName(input);
            dz.style.borderColor = '#e2e8f0';
            dz.style.background = '#fafafa';
        }
    }
</script>
@endpush
