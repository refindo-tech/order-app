<?php

namespace App\Http\Requests\Admin;

class LoginRequest extends BaseAdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Login should be accessible to all users (not just admins)
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
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3'], // Minimum 3 for demo
        ];
    }

    /**
     * Custom error messages for login
     */
    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 3 karakter.',
        ]);
    }
}
