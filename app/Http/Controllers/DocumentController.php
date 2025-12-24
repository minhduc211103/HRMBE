<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HandleUploadTrait;
use Illuminate\Support\Facades\DB;
class DocumentController extends Controller
{
    use HandleUploadTrait ,AuthorizesRequests ;
    public function upload(Request $request)
    {
        $storedFiles = [];
        DB::beginTransaction();
        try {
            $modelId = $request->input('documentable_id');
            $modelType = $request->input('documentable_type');

            if ($modelType === 'project') {
                $model = Project::findOrFail($modelId);
            } else {
                $model = Task::findOrFail($modelId);
            }
            $storedFiles = $this->handleUpload($request, $model);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Upload document successfully',
                'data' => $model->load('documents.user')
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            $this->rollbackFiles($storedFiles);
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->rollbackFiles($storedFiles);
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function download($id)
    {
        try{
            $document = Document::findOrFail($id);
//            $user = auth()->user();
//            $parent = $document->documentable; // Lấy Project hoặc Task liên quan
//            // Chủ sở hữu
//            $isOwner = $user->id === $document->uploaded_by;
//            $isAssignedToTask = false;
//            if ($document->documentable_type === 'App\Models\Task') {
//                // Kiểm tra xem ID của employee được giao task có khớp với employee của user hiện tại không
//                // Giả sử quan hệ là $user->employee->id
//                if ($parent && $user->employee && $parent->employee_id === $user->employee->id) {
//                    $isAssignedToTask = true;
//                }
//            }
//            if (!$isOwner && !$isAssignedToTask) {
//                return response()->json(['message' => 'Not allowed'], 403);
//            }
            $this->authorize('download', $document);
            if (!Storage::disk('local')->exists($document->path)) {
                return response()->json(['message' => 'Not found'], 404);
            }

            return Storage::disk('local')->download(
                $document->path,
                $document->name
            );
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Not found'], 404);
        }
    }
    public function deleteDocument($id){
        DB::beginTransaction();
        try{
            $user = auth()->user();
            $document = Document::findOrFail($id);
            $this->authorize('delete', $document);
            $filePath = $document->path;
            $document->delete();
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Delete document successfully'
            ], 200);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Not Found'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
