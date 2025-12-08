@extends('layouts.dashboard')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@push('styles')
    <style>
        .current-image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 5px;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Edit User</h1>
                <p>Update user information</p>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter User Name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" placeholder="Enter Your Email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter New Password (leave blank to keep current)"
                            class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">Leave blank if you don't want to change the password</small>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm New Password"
                            class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Enter Your Phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" id="address" placeholder="Enter Your Address"
                            class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label">Profile Image</label>
                        @if($user->image)
                            <div class="mb-2">
                                <p class="mb-1 fw-bold">Current Image:</p>
                                <img src="{{ asset('productImages/' . $user->image) }}" alt="{{ $user->image }}"
                                    class="current-image-preview">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <small class="text-muted">Leave blank if you don't want to change the image</small>
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" role="switch" 
                                {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="status">
                                User Status: <span id="statusLabel" class="ms-2">
                                    @if ($user->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </span>
                            </label>
                        </div>
                        <small class="text-muted">Toggle to change user status between Active and Inactive</small>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update User
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Update status label when checkbox changes
        document.getElementById('status').addEventListener('change', function() {
            const statusLabel = document.getElementById('statusLabel');
            if (this.checked) {
                statusLabel.innerHTML = '<span class="badge bg-success">Active</span>';
            } else {
                statusLabel.innerHTML = '<span class="badge bg-danger">Inactive</span>';
            }
        });
    </script>
@endpush

