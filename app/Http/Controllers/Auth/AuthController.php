<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:admin,student', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);

        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, 

        ];

        $token = JWTAuth::customPayload($payload);

        Auth::login($user); 

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Email atau password salah.'], 401);
        }
        
        $user = Auth::user();

        $payload = [
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        $token = JWTAuth::customPayload($payload);

    } catch (JWTException $e) {
        return response()->json(['error' => 'Tidak dapat membuat token.'], 500);
    }

    return response()->json([
        'token' => $token,
        'user' => $user,
        'message' =>  'Login Successfully',
    ], 200); 
}
}