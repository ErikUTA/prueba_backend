<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Services\PayUService\Exception;

class ProjectController extends Controller
{
    public function getProjects()
    {
        try {
            $projects = Project::with(['tasks.users', 'users'])->get();
            return response()->json([
                'success' => true,
                'projects' => $projects,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createProject(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'required|exists:project_status,id',
            ], [
                'required' => 'Todos los campos son requeridos'
            ]);
            $project = Project::create($validator);
 
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProject(Request $request, $projectId)
    {
        \DB::beginTransaction();
        try {
            $project = Project::find($projectId);
            if(!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 500);
            }
            $validator = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'required|exists:project_status,id'
            ]);
            
            $project->update($validator);

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Proyecto actualizado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProject($projectId)
    {
        \DB::beginTransaction();
        try {
            $project = Project::find($projectId);
            if(!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 500);
            }
            $project->delete();

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Proyecto eliminado correctamente',
            ], 200);
        } catch(\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function assignUserToProject(Request $request, $projectId) {
        \DB::beginTransaction();
        try {
            $project = Project::find($projectId);
            $users = $request->users;
            
            if(!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 500);
            }
            $project->users()->sync($users);

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