@extends('layouts.dashboard')

@section('title', 'Products')
@section('page-title', 'Products')

@push('styles')
    <style>
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #198754;
        }

        .product-status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Product Lists</h1>
                <p>Manage your products</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Create Product
            </a>
        </div>
    </div>

        @if (count($products) > 0)
            <div class="row g-4">
                @foreach ($products as $data)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card product-card shadow-sm">
                            <div class="position-relative">
                                <img src="{{ asset('productImages/' . $data->image) }}"
                                     alt="{{ $data->image }}"
                                     class="product-image card-img-top">
                                @if ($data->status == 1)
                                    <span class="badge bg-success product-status-badge">Active</span>
                                @else
                                    <span class="badge bg-danger product-status-badge">Expired</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="text-muted small">#{{ $data['id'] }}</span>
                                </div>
                                <h5 class="card-title mb-2">{{ $data['name'] }}</h5>
                                <p class="card-text text-muted small mb-2" style="min-height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $data['description'] }}
                                </p>
                                <div class="mb-2">
                                    <span class="badge bg-info">
                                        {{ $data['category'] ? $data["category"]['name'] : "No Category" }}
                                    </span>
                                </div>
                                <div class="product-price mb-3">
                                    ${{ number_format($data['price'], 2) }}
                                </div>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('products.edit', ['id' => $data->id]) }}"
                                        class="btn btn-outline-secondary btn-sm flex-fill">Edit</a>
                                    <form action="{{ route('products.delete', $data->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <h5 class="alert-heading">No Products Found</h5>
                <p>Start by creating your first product.</p>
                <a href="{{ route('products.create') }}" class="btn btn-success">Create Product</a>
            </div>
        @endif
@endsection
