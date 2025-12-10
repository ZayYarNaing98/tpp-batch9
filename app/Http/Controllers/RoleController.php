<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->index();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionRepository->index();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        // dd($request->all());
        $validatedData = $request->validated();

        $this->roleRepository->store($validatedData);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->roleRepository->show($id);
        $permissions = $this->permissionRepository->index();

        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();

        $this->roleRepository->update($id, $validatedData);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function delete($id)
    {
        $this->roleRepository->delete($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}

