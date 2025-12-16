<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
class TaskControllerForEmployee extends Controller
{
    //
    public function getTasks(Request $request)
    {
        try {
            // Lấy bản ghi employee của user hiện tại
            $employee = $request->user()->employee;

            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found',
                    'success' => false
                ], 404);
            }

            $tasks = $employee->tasks()
                ->whereHas('project', function ($q) {
                    $q->whereNull('deleted_at');
                })
                ->with('project')
                ->get();
            return response()->json([
                'message' => 'Get tasks successfully',
                'success' => true,
                'data' => $tasks
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Lỗi server',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            //
            $data = $request->validate([
                'status' => 'required|in:todo,doing,done,review',
                'progress' => 'required|integer|min:0|max:100',
            ]);

            // Update
            $task->update($data);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Update task successfully',
                'data' => $task
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ],500);
        }
    }

}
