<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $permissions = $this->permissionRepository->index();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        $validatedData = $request->validated();
        
        $this->permissionRepository->store($validatedData);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = $this->permissionRepository->show($id);
        
        if (!$permission) {
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
        }

        return view('permissions.edit', compact('permission'));
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        
        $this->permissionRepository->update($id, $validatedData);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function delete($id)
    {
        $this->permissionRepository->delete($id);
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}

