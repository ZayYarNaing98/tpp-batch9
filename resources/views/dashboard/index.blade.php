@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Welcome to TPP Management System</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Products Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem;">Total Products</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_products'] }}</h3>
                            <small class="text-muted">
                                <span class="text-success">{{ $stats['active_products'] }} Active</span> /
                                <span class="text-danger">{{ $stats['inactive_products'] }} Inactive</span>
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('products.index') }}" class="text-decoration-none small">
                        View all products <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem;">Total Categories</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_categories'] }}</h3>
                            <small class="text-muted">Product categories</small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-tags text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('categories.index') }}" class="text-decoration-none small">
                        View all categories <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem;">Total Users</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_users'] }}</h3>
                            <small class="text-muted">
                                <span class="text-success">{{ $stats['active_users'] }} Active</span> /
                                <span class="text-danger">{{ $stats['inactive_users'] }} Inactive</span>
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('users.index') }}" class="text-decoration-none small">
                        View all users <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Active Products Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem;">Active Products</h6>
                            <h3 class="mb-0 fw-bold text-success">{{ $stats['active_products'] }}</h3>
                            <small class="text-muted">Currently available</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('products.index') }}" class="text-decoration-none small">
                        Manage products <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4">
        <!-- Recent Products -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Products</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($stats['recent_products']->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($stats['recent_products'] as $product)
                                <div class="list-group-item px-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $product->name }}</h6>
                                            <small class="text-muted">
                                                Category: {{ $product->category ? $product->category->name : 'N/A' }}
                                                | Price: ${{ number_format($product->price, 2) }}
                                            </small>
                                        </div>
                                        <div>
                                            @if($product->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No products found</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>Recent Users</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($stats['recent_users']->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($stats['recent_users'] as $user)
                                <div class="list-group-item px-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $user->name }}</h6>
                                            <small class="text-muted">
                                                {{ $user->email }}
                                                @if($user->phone)
                                                    | {{ $user->phone }}
                                                @endif
                                            </small>
                                        </div>
                                        <div>
                                            @if($user->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No users found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

