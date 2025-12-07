<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function store($data)
    {
        return Product::create($data);
    }

    public function show($id)
    {
        return Product::find($id);
    }
}