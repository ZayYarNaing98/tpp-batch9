@extends('layouts.dashboard')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Category Listing</h1>
                <p>Manage product categories</p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Create Category
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $category)
                            <tr>
                                <td>{{ $category['id'] }}</td>
                                <td class="fw-bold">{{ $category['name'] }}</td>
                                <td>
                                    <img src="{{ asset('categoryImages/' . $category->image) }}" alt="{{ $category->image }}"
                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.delete', ['id' => $category->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
