<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function index();

    public function store($data);

    public function show($id);

}
