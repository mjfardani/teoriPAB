<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function register_admin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(10),
            'role' => 'ADMINISTRATOR',
            'plain_token' => '',
        ]);
        return response()->json(['message' => 'Berhasil'], 200);
    }

    public function register_terminal(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
        ]);
        $id = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
            'role' => 'TERMINAL',
            'plain_token' => '',
        ]);
        $user = User::find($id);
        $plain_token = $user->createToken('machine-to-machine-token')
            ->plainTextToken;
        $user->plain_token = $plain_token;
        $user->save();
        return response()->json([
            'token' => $plain_token,
            'message' => 'Berhasil'
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Attempt to find the user by email
        $user = User::where('email', $request->email)
            ->where('role', 'ADMINISTRATOR')->first();
        // Verify if user exists and password is correct
        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }
        // Create a new Sanctum token for the user
        $token = $user->createToken('API Token')->plainTextToken;
        // Return the token
        return response()->json([
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
        return response()->json(['message' => 'Berhasil'], 200);
    }
}
