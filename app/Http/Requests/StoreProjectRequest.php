<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            // 1. Tên dự án: Bắt buộc, chuỗi, tối đa 255 ký tự
            'name' => 'required|string|max:255',

            // 2. Manager:
            'manager_id' => 'required|exists:managers,id',

            // 3. Mô tả: Cho phép null
            'description' => 'nullable|string',

            // 4. Ngày bắt đầu: Phải là định dạng ngày tháng
            'start_date' => 'required|date',

            // 5. Ngày kết thúc: Phải là ngày tháng VÀ phải sau hoặc bằng ngày bắt đầu
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (Optional)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Project name is required.',
            'manager_id.exists' => 'The selected manager is invalid.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}
