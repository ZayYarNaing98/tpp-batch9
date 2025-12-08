@extends('layouts.dashboard')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@push('styles')
    <style>
        .current-image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 5px;
            margin-top: 10px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Edit Category</h1>
                <p>Update category information</p>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Enter Category Name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label">Category Image</label>
                        @if($category->image)
                            <div class="mb-2">
                                <p class="mb-1 fw-bold">Current Image:</p>
                                <img src="{{ asset('categoryImages/' . $category->image) }}" alt="{{ $category->image }}"
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
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Category
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
