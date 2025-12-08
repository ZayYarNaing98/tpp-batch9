@extends('layouts.dashboard')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@push('styles')
    <style>
        .current-image-preview {
            max-width: 300px;
            max-height: 300px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 5px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Edit Product</h1>
                <p>Update product information</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                
                <div class="row g-3">
                    <!-- Current Image Display -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Current Product Image</label>
                        <div class="mt-2">
                            <img src="{{ asset('productImages/' . $product->image) }}"
                                alt="{{ $product->image }}" class="current-image-preview">
                        </div>
                    </div>

                    <!-- Name Field -->
                    <div class="col-12">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4"
                            placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Price Field -->
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" id="price" class="form-control"
                                value="{{ old('price', $product->price) }}" placeholder="0.00" min="0" step="0.01">
                        </div>
                        @error('price')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Category Field -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Image Upload Field -->
                    <div class="col-12">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <small class="text-muted">Leave blank if you don't want to change the image</small>
                        @error('image')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status"
                                role="switch" {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="status">
                                Product Status: <span id="statusLabel" class="ms-2">
                                    @if ($product->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </span>
                            </label>
                        </div>
                        <small class="text-muted">Toggle to change product status between Active and Expired</small>
                        @error('status')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Product Info -->
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <small>
                                <strong>Product ID:</strong> #{{ $product->id }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Product
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
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
                statusLabel.innerHTML = '<span class="badge bg-danger">Expired</span>';
            }
        });
    </script>
@endpush
