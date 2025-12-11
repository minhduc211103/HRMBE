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
            'email'      => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password'   => 'required|min:8',
            'role'       => 'required|in:employee,manager',
            'name'       => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|max:10|min:10',

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
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number may contain digits only.',
            'phone.max' => 'Phone number must be 10 characters.',
            'phone.min' => 'Phone number must be 10 characters.',


            'role.required'     => 'Role is required.',
            'role.in'           => 'Invalid role.',
            'name.required'     => 'Full name is required.',

            'manager_id.required_if' => 'Manager is required for employee.',
            'manager_id.exists'      => 'Selected manager does not exist.',

            'position.required_if'   => 'Position is required for manager.',
        ];
    }
}
