<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function getEmployee(Request $request){
        try{
            $employee = $request->user()
                ->employee()
                ->with(['user:id,email,role','manager:id,name'])
                ->firstOrFail();
            if (!$employee) {
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $employee
            ]);
        }
        catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()

            ]);
        }
    }
    public function getManager(Request $request)
    {
        try{
            $employee = $request->user()->employee;
            $manager = $employee->manager;
            if (!$manager) {
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }
            else {
                return response()->json([
                    'success' => true,
                    'data' => $manager->name
                ]);
            }
        }
        catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }
}
