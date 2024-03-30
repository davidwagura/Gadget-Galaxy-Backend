<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate
        ([
            'username' => 'required|string',
            'email' => 'required|email|unique:users|string',
            'password' => 'required|min:8'
        ]);

        User::create
        ([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Registered successfully',
        ],200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!empty($user)) {
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("myToken")->plainTextToken;
                
                return response()->json([
                    'status' => true,
                    'message' => 'login successful',
                    'token' => $token
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => "password didn't match"
            ]);
        }
    }
}
