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
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // user 
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // token
            return response()->json([
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
            ]);    

        }

        // auth
        public function auth(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email' , 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string','min:8'],
            ]);

            $user = User::whereEmail('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return response()->json([
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
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
