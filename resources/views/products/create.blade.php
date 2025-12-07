<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 5px;
            display: none;
            margin-top: 10px;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .file-upload-area.dragover {
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade show" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="false" style="display: block;" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createProductModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New Product
                    </h5>
                    <a href="{{ route('products.index') }}" type="button" class="btn-close btn-close-white"
                        aria-label="Close"></a>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Name Field -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                    value="{{ old('name') }}" placeholder="Enter product name" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-bold">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="Enter product description" required>{{ old('description') }}</textarea>
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
                                        value="{{ old('price') }}" placeholder="0.00" min="0" step="0.01" required>
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
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Upload Field -->
                            <div class="col-12">
                                <label for="image" class="form-label fw-bold">Product Image <span
                                        class="text-danger">*</span></label>
                                <div class="file-upload-area" id="fileUploadArea">
                                    <input type="file" name="image" id="image" class="d-none" accept="image/*" required>
                                    <div id="uploadText">
                                        <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                        <p class="mt-2 mb-0">
                                            <strong>Click to upload</strong> or drag and drop
                                        </p>
                                        <p class="text-muted small mb-0">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <img id="imagePreview" class="image-preview" alt="Preview">
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Field -->
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="status"
                                        role="switch" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="status">
                                        Product Status: <span id="statusLabel" class="ms-2">
                                            <span class="badge bg-success">Active</span>
                                        </span>
                                    </label>
                                </div>
                                <small class="text-muted">Toggle to set product status (Active/Expired)</small>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Create Product
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

        // File upload area click handler
        document.getElementById('fileUploadArea').addEventListener('click', function() {
            document.getElementById('image').click();
        });

        // File input change handler
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    document.getElementById('uploadText').innerHTML = `
                        <i class="bi bi-check-circle" style="font-size: 2rem; color: #198754;"></i>
                        <p class="mt-2 mb-0"><strong>${file.name}</strong></p>
                        <p class="text-muted small mb-0">Click to change image</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop handlers
        const fileUploadArea = document.getElementById('fileUploadArea');
        const imageInput = document.getElementById('image');

        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                const event = new Event('change', { bubbles: true });
                imageInput.dispatchEvent(event);
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
