<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\Role\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function index()
    {
        return Role::with('permissions')->get();
    }

    public function store($data)
    {
        $role = Role::create(['name' => $data['name']]);

        // Sync permissions if provided
        if (isset($data['permissions']) && is_array($data['permissions']) && !empty($data['permissions'])) {
            // Convert permission IDs to Permission models
            $permissions = Permission::whereIn('id', $data['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            // If no permissions provided, sync with empty array to clear any existing permissions
            $role->syncPermissions([]);
        }

        return $role->load('permissions');
    }

    public function show($id)
    {
        return Role::with('permissions')->find($id);
    }

    public function update($id, $data)
    {
        $role = Role::find($id);
        if ($role) {
            $role->update(['name' => $data['name']]);

            if (isset($data['permissions']) && is_array($data['permissions']) && !empty($data['permissions'])) {
                // Convert permission IDs to Permission models
                $permissions = Permission::whereIn('id', $data['permissions'])->get();
                $role->syncPermissions($permissions);
            } else {
                // If no permissions provided, sync with empty array to clear any existing permissions
                $role->syncPermissions([]);
            }

            return $role->load('permissions');
        }
        return null;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            return $role->delete();
        }
        return false;
    }
}

