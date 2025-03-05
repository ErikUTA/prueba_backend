<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario creado correctamente']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ])->withCookie(cookie('token', $token, 60, '/', null, true, true, false, 'None'));
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user()
    {
        return response()->json(Auth::user());
    }
}

// $validator = Validator::make($request->all(), [
//     'email' => 'required|email',
//     'password' => 'required|string',
// ]);

// if ($validator->fails()) {
//     return response()->json(['errors' => $validator->errors()], 422);
// }

// $user = User::where('email', $request->email)->first();

// if (!$user || !Hash::check($request->password, $user->password)) {
//     return response()->json(['message' => 'Credenciales incorrectas'], 401);
// }

// // Generar el token
// $token = $user->createToken('AppName')->plainTextToken;

// return response()->json(['token' => $token]);