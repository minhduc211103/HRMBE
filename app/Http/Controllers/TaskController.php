<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function store(Request $request){
        try {
            $data = $request->validated();

            $task = Task::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Create task successfully',
                'data' => $task
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
