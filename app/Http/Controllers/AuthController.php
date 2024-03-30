<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $userData = $request->validate
        ([
            'username' => 'required|string',
            'email' => 'requireda|email|unique:users|string',
            'password' => 'required|min:8'
        ]);

        User::create
        ([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        return response()->json([
            'message' => 'Registered successfully',
        ],200);
    }
}
