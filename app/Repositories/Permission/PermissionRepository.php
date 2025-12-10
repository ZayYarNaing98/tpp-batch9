<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function index()
    {
        return Permission::get();
    }

    public function store($data)
    {
        return Permission::create(['name' => $data['name']]);
    }

    public function show($id)
    {
        return Permission::find($id);
    }

    public function update($id, $data)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->update(['name' => $data['name']]);
            return $permission;
        }
        return null;
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            return $permission->delete();
        }
        return false;
    }
}

