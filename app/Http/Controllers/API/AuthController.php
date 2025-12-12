<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            // dd($credentials);

            if (!JWTAuth::attempt($credentials)) {
                return $this->error("Your Email & Password is wrong!", null, 401);
            }

            $user = User::where('email', $credentials['email'])->first();

            $payload = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status === 1 ? "Active" : "Suspend",
                'phone' => $user->phone,
                'gender' => $user->gender,
                'address' => $user->address
            ];

            $token = JWTAuth::customClaims($payload)->attempt(['email' => $user->email, 'password' => $credentials['password']]);

            return $this->success($token, "User Login Successfully", 200);

        } catch (Exception $e) {
            $this->error("Something went wrong!", null, 500);
        }
    }
}
