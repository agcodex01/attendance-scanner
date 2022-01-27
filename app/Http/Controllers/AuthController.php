<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            return response()->json([
                'token' => $user->createToken('access_token')->plainTextToken,
                'user' => $user,
                'location' => $request->location
            ]);
        }

        return response()->json([
            'errors' => [
                'password' => ['Invalid password.'],
                'message' => 'Invalid credentials'
            ]
        ], 422);
    }

    public function logout(User $user)
    {
       return $user->tokens()->delete();
    }
}
