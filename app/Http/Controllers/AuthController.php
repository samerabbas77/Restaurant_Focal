<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Traits\ApiTraits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiTrait;
    public function register(UserRequest $request)
    {
        try {
            $user = $request->validated();

            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => ["Customer"]
            ]);
            $user->assignRole(["Customer"]);
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->apiResponse(new UserResource($user), $token, 'register successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('something wrong with register', 400);
        }

    }
    public function login(LoginRequest $request)
    {

        try {
            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('authToken')->plainTextToken;

            return $this->apiResponse(new LoginResource($user), $token, 'login success', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse('something wrong with login', 400);

        }
    }
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->customeResponse('logout success', 200);

        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse('something wrong with logout', 204);

        }

    }

}


