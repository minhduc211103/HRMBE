<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(Request $request){
        try{
            $employee = $request->user()->employee;

            if (!$employee) {
                return response()->json([
                    'message' => 'Không tìm thấy employee'
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

}
