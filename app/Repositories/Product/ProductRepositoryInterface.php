<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function index();

    public function store($data);

    public function show($id);
}