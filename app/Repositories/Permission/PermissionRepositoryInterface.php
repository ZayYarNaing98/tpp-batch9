<?php

namespace App\Repositories\Permission;

interface PermissionRepositoryInterface
{
    public function index();

    public function store($data);

    public function show($id);

    public function update($id, $data);

    public function delete($id);
}

