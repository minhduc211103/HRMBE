<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            //
            'email'      => 'required|email|unique:hr,email,NULL,id,deleted_at,NULL',
            'password'   => 'required|min:8',
            'role'       => 'required|in:employee,manager',
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',

            // validate theo role
            'manager_id' => 'required_if:role,employee|nullable|exists:managers,id',
            'position'   => 'required_if:role,manager|nullable|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Invalid email format.',
            'email.unique'      => 'This email already exists.',

            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',

            'role.required'     => 'Role is required.',
            'role.in'           => 'Invalid role.',

            'name.required'     => 'Full name is required.',
            'phone.required'    => 'Phone number is required.',

            'manager_id.required_if' => 'Manager is required for employee.',
            'manager_id.exists'      => 'Selected manager does not exist.',

            'position.required_if'   => 'Position is required for manager.',
        ];
    }
}
