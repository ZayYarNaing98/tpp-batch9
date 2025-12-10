<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users = $this->userRepository->index();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('productImages'), $imageName);

            $validatedData = array_merge($validatedData, ['image' => $imageName]);
        }

        $validatedData['status'] = $request->has('status') ? true : false;

        // Hash password if it exists
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $roleId = $validatedData['role'] ?? null;
        unset($validatedData['role']);

        $user = $this->userRepository->store($validatedData);

        if ($roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $user->assignRole($role);
            }
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userRepository->show($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('productImages'), $imageName);
            $data['image'] = $imageName;
        }

        $user = $this->userRepository->update($request->id, $data);

        if ($user) {
            if ($request->filled('role')) {
                $role = Role::find($request->role);
                if ($role) {
                    $user->syncRoles([$role]);
                }
            } else {
                // If no role selected, remove all roles
                $user->syncRoles([]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('users.index');
    }
}
