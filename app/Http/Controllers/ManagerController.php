<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{

    public function getManager(Request $request){
        try{
            $manager = $request->user()
                ->manager()
                ->with('user:id,email')
                ->firstOrFail();
            if (!$manager) {
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $manager
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }
    public function getEmployees(Request $request)
    {
        try{
            $manager = $request->user()->manager;
            $employees = $manager
                        ->employees()
                        ->with('user:id,email')
                        ->get();
            return response()->json([
                'success' => true,
                'data' => $employees
            ],200);
        }
        catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function getProjects(Request $request)
    {
        try{
            $manager = $request->user()->manager;
            $projects = $manager->projects;
            return response()->json([
                'success' => true,
                'data' => $projects
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
