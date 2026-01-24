<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BaseAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only admin users can make admin requests.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     * Override in child classes.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Common validation rules that can be used across admin forms
     */
    protected function commonRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    /**
     * Get common validation error messages
     */
    public function messages(): array
    {
        return [
            'required' => 'Field :attribute wajib diisi.',
            'email' => 'Format :attribute tidak valid.',
            'min' => 'Field :attribute minimal :min karakter.',
            'max' => 'Field :attribute maksimal :max karakter.',
            'numeric' => 'Field :attribute harus berupa angka.',
            'image' => 'File :attribute harus berupa gambar.',
            'mimes' => 'File :attribute harus berformat: :values.',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'password' => 'password',
            'price' => 'harga',
            'description' => 'deskripsi',
            'image' => 'gambar',
        ];
    }
}
