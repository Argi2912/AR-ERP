<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\AUTH\LoginRequest;
use App\Http\Requests\AUTH\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
           'message' => 'User created successfully'
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials =$request->only('email', 'password');

        try {

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Token Unauthorized'
                ], 400);
            }
            
        } catch (JWTException $e) {
        
            return response()->json([
                'error' => 'Not created token'
            ], 500);
            
        }

        return response()->json(compact('token'));

    }
}
