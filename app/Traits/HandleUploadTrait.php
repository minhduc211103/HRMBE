<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait HandleUploadTrait
{
    protected function handleUpload(Request $request, $model, $folder = 'documents')
    {
        try{
            $validator = Validator::make($request->all(), [
                'files' => 'nullable',
                'files.*' => [
                    'required',
                    'file',
                    'mimes:pdf,doc,docx,jpg,jpeg,png,zip,xlsx', // Các đuôi file cho phép
                    'max:10240', // max: 10mb
                ],
            ], [
                'files.*.mimes' => 'Files type not allowed',
                'files.*.max' => 'File size not over 10MB',
            ]);
            $storedPaths = [];

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    // Lưu file vào ổ cứng (local disk)
                    $path = $file->store($folder . '/' . date('Y/m'), 'local');
                    $storedPaths[] = $path;

                    // Lưu vào Database
                    $model->documents()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'uploaded_by' => auth()->id(),
                        // 2 cột documentable sẽ được tự động thêm nhờ model
                    ]);
                }
            }
            // trả về các đường dẫn
            return $storedPaths;
        }
        catch (ValidationException $e){
            return response()->json(['errors' => $e->errors()]);
        }
        catch (\Exception $e){
            return response()->json(['errors' => $e->getMessage()]);
        }

    }

    // Xóa file nếu gặp rollback
    protected function rollbackFiles(array $paths)
    {
        foreach ($paths as $path) {
            Storage::disk('local')->delete($path);
        }
    }
}
