<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Manager;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    public function create(){
        $managers = Manager::all();
        return view('admin.projects.create', compact('managers'));
    }
    public function store(StoreProjectRequest $request){
        try{
            Project::create($request->validated());

            return redirect()
                ->route('admin.projects.create')
                ->with('success', 'Project created successfully!');
        }
        catch (\Exception $exception){
            return back()
                ->withErrors(['name' => ($exception->getMessage())])
                ->withInput();
        }
    }
    public function show(Request $request,$id)
    {
        try {
            // ✅ Eager Loading: Lấy Project kèm theo:
            // 1. tasks: Danh sách công việc của dự án
            // 2. tasks.employee: Thông tin nhân viên làm task đó (để hiện tên thay vì id)
            // 3. manager: Thông tin người quản lý dự án (nếu cần)

            $project = Project::with(['manager', 'tasks.employee'])
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
    public function update(UpdateProjectRequest $request, $id)
        {
            try {
                $project = Project::findOrFail($id);
                // $request->validated() chỉ lấy những trường đã được khai báo trong rules
                // Hàm fill() sẽ điền dữ liệu vào model nhưng chưa lưu
                $project->fill($request->validated());

                if ($request->status === 'done') {
                    $project->progress = 100;
                }
                // 4. Lưu vào DB
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
}
