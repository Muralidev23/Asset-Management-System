@extends('layouts.app')

@section('page-title', 'Edit Asset')
@section('breadcrumb', 'Home / Assets / Edit')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-pen-to-square me-2" style="color:#6366f1;font-size:1.1rem;"></i>Edit Asset</h1>
        <p>Update hardware specifications for <strong>{{ $asset->name }}</strong>.</p>
    </div>
    <a href="{{ route('assets.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <span style="width:32px;height:32px;background:rgba(6,182,212,.12);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;color:#06b6d4;font-size:.8rem;">
                    <i class="fa-solid fa-laptop"></i>
                </span>
                Asset: {{ $asset->asset_id }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('assets.update', $asset->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="asset_id">Asset ID <span style="color:#ef4444">*</span></label>
                            <input id="asset_id" type="text" class="form-control {{ $errors->has('asset_id') ? 'is-invalid' : '' }}"
                                   name="asset_id" value="{{ old('asset_id', $asset->asset_id) }}" required autofocus>
                            @error('asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="type">Asset Type <span style="color:#ef4444">*</span></label>
                            <select id="type" class="form-select {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" required>
                                <option value="" disabled>Select hardware type…</option>
                                @foreach(['Laptop','Monitor','Keyboard','Mouse','Headset','Mobile Phone','Other'] as $t)
                                    <option value="{{ $t }}" {{ old('type', $asset->type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="name">Asset Name <span style="color:#ef4444">*</span></label>
                            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   name="name" value="{{ old('name', $asset->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="serial_number">Serial Number <span style="color:#ef4444">*</span></label>
                            <input id="serial_number" type="text" class="form-control {{ $errors->has('serial_number') ? 'is-invalid' : '' }}"
                                   name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" required>
                            @error('serial_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <a href="{{ route('assets.index') }}" class="btn btn-ghost">Cancel</a>
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
