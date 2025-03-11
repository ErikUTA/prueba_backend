<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\PayUService\Exception;

class ProjectController extends Controller
{
    public function getProjects()
    {
        try {
            if(auth()->user()->role === 'RH') {
                return response()->json([
                    'success' => false,
                    'Role no permitido'
                ])
            }
            $projects = Project::get();
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
                'name' => 'required|string|max:255'
                'description' => 'required'
                'status' => 'required|string'
                'user_id' => 'required|exists:users,id'
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
            $validator = $request->validate([
                'name' => 'required|string|max:255'
                'description' => 'required'
                'status' => 'required|string'
                'user_id' => 'required|exists:users,id'
            ]);
            
            $project->saveOrFail();

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
                ]);
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
                ]);
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