<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsers()
    {
        try {
            $users = User::with('tasks')
                ->where('active', true)
                ->get();
            return response()->json([
                'users' => $users,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserById($userId)
    {
        try {
            $user = User::with('tasks')
                ->whereId($userId)
                ->where('active', true)
                ->first();
            return response()->json([
                'user' => $user,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsersToPlanning()
    {
        try {
            $users = User::select('id', 'name')
                ->with('tasks')
                ->where('active', true)
                ->get();
            return response()->json([
                'users' => $users,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $userId)
    {
        \DB::beginTransaction();
        try {
            $user = User::find($userId);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 500);
            }
            $data = [
                'name', 
                'last_name', 
                'second_last_name', 
                'password', 
                'role'
            ];
            $rules = [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'second_last_name' => 'required|string|max:255',
                'role' => 'required|string',
            ];
            if(auth()->user()->role === 'RH') {
                array_push($data, 'email');
                array_push($data, 'password');
                $rules['email'] = 'required|string|email|max:255|unique:users';
                $rules['password'] = 'required|string|min:8';
            }
            $request->only($data);
            $validated = $request->validate($rules);

            $user->fill($validated);
            $user->update($validated);
            
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);        
        }
    }

    public function updatePassword(Request $request, $userId) {
        \DB::beginTransaction();
        try {
            $user = User::find($userId);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 500);
            }
            $request->validate([
                'password' => 'required|string|min:8',
            ]);  
            $user->update([
                'password' => Hash::make($request['password'])
            ]);      

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage(),
                'line' => $exception->getLine()
            ], 500);
        }
    }

    public function updateRole(Request $request, $userId)
    {
        \DB::beginTransaction();
        try {
            $user = User::whereId($userId);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 500);
            }
            $request->validate([
                'role' => 'required|string',
            ]);
            $user->update([
                'role' => $request['role']
            ]); 

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Role actualizado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function deleteUser($userId)
    {
        \DB::beginTransaction();
        try {
            $user = User::find($userId);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 500);
            }
            $user->update([
                'active' => false
            ]);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    public function assignTaskToUser(Request $request, $userId) {
        \DB::beginTransaction();
        try {
            $user = User::find($userId);
            $tasks = $request->tasks;
            
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 500);
            }
            $user->tasks()->sync($tasks);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Se han asignado las tareas correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'second_last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
    
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente'
            ]);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);        
        }
        
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        return response()->json(['message' => 'Logout completado']);
    }

    public function user()
    {
        return response()->json(Auth::user());
    }
}