<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .current-image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 5px;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade show" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="false" style="display: block;" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProductModalLabel">
                        <i class="bi bi-pencil-square"></i> Edit Product
                    </h5>
                    <a href="{{ route('products.index') }}" type="button" class="btn-close btn-close-white"
                        aria-label="Close"></a>
                </div>
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Current Image Display -->
                            <div class="col-12 text-center mb-3">
                                <label class="form-label fw-bold">Current Product Image</label>
                                <div class="mt-2">
                                    <img src="{{ asset('productImages/' . $product->image) }}"
                                        alt="{{ $product->image }}" class="current-image-preview">
                                </div>
                            </div>

                            <!-- Name Field -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                    value="{{ $product->name }}" placeholder="Enter product name" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="Enter product description" required>{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Field -->
                            <div class="col-12">
                                <label for="price" class="form-label fw-bold">Price <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="price" id="price" class="form-control form-control-lg"
                                        value="{{ $product->price }}" placeholder="0.00" min="0" step="0.01" required>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Field -->
                            <div class="col-12">
                                <label for="category_id" class="form-label fw-bold">Category <span
                                        class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Field -->
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="status"
                                        role="switch" {{ $product->status == 1 ? 'checked' : '' }}>
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
                                    <div class="text-danger small mt-1">{{ $message }}</div>
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
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div class="modal-backdrop fade show" id="modalBackdrop"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        // Handle backdrop click to redirect to index
        document.getElementById('modalBackdrop').addEventListener('click', function() {
            window.location.href = "{{ route('products.index') }}";
        });

        // Handle escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.href = "{{ route('products.index') }}";
            }
        });

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
</body>

</html>
