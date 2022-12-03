<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|String',
            'password' => 'required',
        ]);

        $user = User::where('email', '=', $validated['email'])->first();



        // checking the email and password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response(
                [
                    'message' => 'Login failed',
                    'errors' => 'Wrong email or password',
                ],
                401
            );
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response(
            [
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ],
            200
        );
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|String',
            'email' => 'required|String|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response(
            [
                'message' => 'Created account successfully',
                'user' => $user,
                'token' => $token
            ],
            200
        );
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response([
            'message' => 'Logged out successfully'
        ]);
    }
}
