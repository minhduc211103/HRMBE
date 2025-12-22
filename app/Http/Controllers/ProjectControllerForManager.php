<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Traits\HandleUploadTrait ;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectControllerForManager extends Controller
{
    //
    use HandleUploadTrait ;
    public function store(StoreProjectRequest $request){
        $storedFiles = [];
        DB::beginTransaction();
        try{
            // Insert dữ liệu cơ bản của project
            $project = Project::create($request->validated());
            // Kéo file về
            $storedFiles = $this->handleUpload($request, $project);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Project created successfully'
            ]);

        }
        catch (\Exception $exception){
            DB::rollBack();
            $this->rollbackFiles($storedFiles); // Clear file do lỗi
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
    public function show(Request $request,$id)
    {
        try {
            $project = Project::with([
                'manager',

                'tasks.employee',
                'tasks.documents.user.manager',  // Lấy document của từng task + user upload + manager của user đó
                'tasks.documents.user.employee', // Lấy document của từng task + user upload + employee của user đó

                'documents.user.manager',
                'documents.user.employee'
            ])
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $project
            ], 200);

        } catch (ModelNotFoundException $e) {
            // Trả về lỗi 404 nếu ID không tồn tại
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        } catch (\Exception $e) {
            // Trả về lỗi 500 nếu server lỗi
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }


    // Update của manager
    public function updateFromManager(UpdateProjectRequest $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            // $request->validated() chỉ lấy những trường đã được khai báo trong rules
            // Hàm fill() sẽ điền dữ liệu vào model nhưng chưa lưu
            $project->fill($request->validated());
            if ($request->status === 'completed') {
                $project->progress = 100;
            }
            // Lưu vào DB
            $project->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Project updated successfully',
                'data' => $project
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Project not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try{
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Project deleted successfully'
            ]);
        }
        catch (\Exception $exception){
           return response()->json([
               'status' => 'error',
               'message' => $exception->getMessage()
           ]);
        }
    }
}
