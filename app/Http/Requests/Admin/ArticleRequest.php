<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ArticleRequest extends BaseAdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $articleId = $this->route('article')?->id ?? null;

        $thumbnailRules = ['image', 'mimes:jpeg,jpg,png,gif,webp', 'max:2048'];
        if ($this->isMethod('POST')) {
            array_unshift($thumbnailRules, 'required');
        } else {
            array_unshift($thumbnailRules, 'nullable');
        }

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($articleId),
            ],
            'author_name' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => $thumbnailRules,
            'excerpt' => ['nullable', 'string', 'max:250'],
            'content' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'publish_date' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal :max karakter.',
            'slug.unique' => 'Slug sudah digunakan oleh artikel lain.',
            'thumbnail.required' => 'Thumbnail artikel wajib diupload.',
            'thumbnail.image' => 'Thumbnail harus berupa file gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat: :values.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal :max KB.',
            'excerpt.max' => 'Excerpt maksimal :max karakter.',
            'status.in' => 'Status artikel tidak valid.',
            'publish_date.date' => 'Format tanggal publish tidak valid.',
        ];
    }
}

