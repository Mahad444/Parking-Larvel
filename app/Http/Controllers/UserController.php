<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Storing info
     public function store(Request $request)

     {
            $request -> validate([
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            // user 
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // token
            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken('new_user')->plainTextToken,
            ]);    

        }

        // auth login
        public function auth(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email' , 'string', 'max:255'],
                'password' => ['required', 'string','min:8'],
            ]);

            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)) 
            {
                return response()->json([
                    'message' => 'Invalid credentials provided!!'
                ], 401);
            }

            return response()->json([
                'user' => $user,
                'access_token' => $user->createToken('new_user')->plainTextToken
            ]);
        }

        // logout
        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();

            return response()->noContent();

            // return response()->json(['message' => 'Logged out']);
        }
}
