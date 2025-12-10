@extends('layouts.dashboard')

@section('title', 'Edit Permission')
@section('page-title', 'Edit Permission')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Edit Permission</h1>
                <p>Update permission information</p>
            </div>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Permissions
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $permission->id }}">
                
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter Permission Name"
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $permission->name) }}">
                        <small class="text-muted">Use lowercase with dots or underscores (e.g., 'product.create', 'user_manage')</small>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Permission
                    </button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

