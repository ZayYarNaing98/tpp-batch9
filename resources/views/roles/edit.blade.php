@extends('layouts.dashboard')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Edit Role</h1>
                <p>Update role information and permissions</p>
            </div>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Roles
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $role->id }}">
                
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter Role Name"
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $role->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Permissions <span class="text-muted">(Optional)</span></label>
                        <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                            @forelse ($permissions as $permission)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                        value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                        {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No permissions available. 
                                    <a href="{{ route('permissions.create') }}">Create a permission first</a>.
                                </p>
                            @endforelse
                        </div>
                        @error('permissions')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('permissions.*')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Role
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

