<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        // dd('here');
        $credentials = $request->only(['email', 'password']);

        if (!JWTAuth::attempt($credentials)) {
            return $this->error("Your email and password is wrong!", null, 401);
        }

        $user = User::where('email', $credentials['email'])->first();

        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'status' => $user->status === 1 ? "Active" : "Suspend",
        ];

        $token = JWTAuth::customClaims($payload)->attempt(['email' => $user->email, 'password' => $credentials['password']]);

        return $this->success($token, "User Login Successfully", 200);
    }
}
