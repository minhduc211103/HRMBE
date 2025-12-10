<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Bắt buộc phải thuộc về 1 dự án
            'project_id'  => 'required|exists:projects,id',

            // Bắt buộc phải gán cho 1 nhân viên (theo migration của bạn cột này không nullable)
            'employee_id' => 'required|exists:employees,id',

            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',

            // Validate status nếu có gửi lên
            'status'      => 'nullable|in:todo,doing,done,review',

            'start_date'  => 'required|date',
            // Ngày kết thúc phải sau ngày bắt đầu
            'end_date'    => 'required|date|after_or_equal:start_date',

            // Validate phần trăm hoàn thành (0 -> 100)
            // Lưu ý: Trong migration bạn đặt tên là 'process', nên ở đây cũng phải là 'process'
            'progress'     => 'nullable|integer|min:0|max:100',
        ];
    }
    public function messages()
    {
        return [
            'project_id.required'   => 'Please select a project.',
            'employee_id.required'  => 'Please select an employee.',
            'name.required'         => 'The task name is required.',
            'progress.min'          => 'The progress must not be less than 0%.',
            'progress.max'          => 'The progress must not exceed 100%.',
        ];
    }
}
