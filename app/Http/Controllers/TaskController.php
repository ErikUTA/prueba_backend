<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\PayUService\Exception;

class TaskController extends Controller
{
    public function getTasks()
    {
        try {
            $tasks = Task::get();
            return response()->json([
                'success' => true,
                'tasks' => $tasks,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createTask(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'project_id' => 'required|exists:projects,id'
            ]);
            $users = $request->users;

            $task = Task::create($validator);
            if(!empty($users)) {
                $task = $task->users()->attach($users);
            }

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tarea creada correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateTask(Request $request, $taskId)
    {
        \DB::beginTransaction();
        try {
            $task = Task::find($taskId);
            if(!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarea no encontrada'
                ], 500);
            }
            $validator = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'required|exists:status,id',
                'project_id' => 'required|exists:projects,id'
            ]);
            if(auth()->user()->role === 'RH') {
                $request->only(['title', 'description', 'project_id']);
                $validator = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required',
                    'project_id' => 'required|exists:projects,id'
                ]);
            }
            
            $task->update($validator);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tarea actualizada correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $taskId)
    {
        \DB::beginTransaction();
        try {
            $task = Task::find($taskId);
            if(!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarea no encontrada'
                ], 500);
            }
            $validator = $request->validate([
                'status' => 'required|exists:status,id',
            ]);
            $task->update($validator);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Estado de la tarea actualizado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTask($taskId)
    {
        \DB::beginTransaction();
        try {
            $task = Task::find($taskId);
            if(!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarea no encontrada'
                ], 500);
            }
            $task->delete();

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tarea eliminada correctamente'
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function assignUsersToTask(Request $request, $taskId) {
        \DB::beginTransaction();
        try {
            $task = Task::find($taskId);
            $users = $request->users;
            
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarea no encontrada'
                ], 500);
            }
            $task->users()->sync($users);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Se han asignado los usuarios correctamente',
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