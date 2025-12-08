<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->index();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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

        $this->userRepository->store($validatedData);

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = $this->userRepository->show($id);

        return view('users.edit', compact('user'));
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

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle image update if provided
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('productImages'), $imageName);
            $data['image'] = $imageName;
        }

        $this->userRepository->update($request->id, $data);

        return redirect()->route('users.index');
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('users.index');
    }
}
