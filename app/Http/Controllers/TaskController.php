<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function store(StoreTaskRequest $request){
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
    public function update(UpdateTaskRequest $request, $id){
        try{
            $task = Task::findOrFail($id);
            $data = $request->validated();
            $task->update($data);
            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Update task successfully',
                'data' => $task
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }

    }
    public function destroy($id){
        try{
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Delete task successfully',
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }
}
