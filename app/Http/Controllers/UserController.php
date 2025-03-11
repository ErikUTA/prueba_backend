<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PayUService\Exception;

class UserController extends Controller
{
    public function getUsers()
    {
        try {
            $users = User::get();
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
            $input = $request->all();
            $user = User::findOrFail($userId);
            $user->fill($request->all());

            $user->update($input);
            
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
            $user = User::findOrNew($userId);

            if ($request->has('password') && !empty($request['password'])) {
                $request['password'] = bcrypt($request['password']);
            }            
            $user->fill($request->all());
            $user->saveOrFail();

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
            $user = User::whereId(userId);
            $user->role = $request['role'];
            $user->saveOrFail();
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
                ]);
            }
            $user->delete();

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
            
            if(!$user) {|
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ]);
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
}