<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class tokenController extends Controller
{
    public function register(Request $request) {
        
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);

    }

    public function logout(Request $request) {

        auth()->user()->tokens()->delete();
        return response()->json([
            'massage' => 'Logged Out.!'
        ]);

    }
    
    public function login(Request $request) {
        
        $fields = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'massage' => 'Invalid email or password.!'
            ], 401);
        }
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);

    }

}
