<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Troubleshooting: Log saat request masuk ProductRequest (sebelum controller)
        Log::channel('single')->info('[ProductRequest] Request masuk', [
            'route' => $this->route()?->getName(),
            'method' => $this->method(),
            'url' => $this->fullUrl(),
        ]);
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        Log::channel('single')->warning('[ProductRequest] Validasi gagal', [
            'route' => $this->route()?->getName(),
            'errors' => $validator->errors()->toArray(),
        ]);
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'description' => ['nullable', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'normal_price' => ['nullable', 'numeric', 'min:0'],
            'minimal_grosir' => ['nullable', 'integer', 'min:2'],
            'harga_grosir' => [
                'nullable',
                'numeric',
                'min:0',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ($value === null || $value === '') {
                        return;
                    }
                    $price = $this->input('price');
                    if ($price !== null && (float) $value >= (float) $price) {
                        $fail('Harga grosir harus lebih rendah dari harga normal.');
                    }
                },
            ],
            'category' => ['required', 'string', 'max:100'],
            'weight' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'media' => ['nullable', 'array', 'max:4'],
            'media.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,mp4,webm,ogg,mov', 'max:15360'], // max 15MB for video
            'remove_media' => ['nullable', 'array'],
            'remove_media.*' => ['integer', 'exists:product_media,id'],
            'media_order' => ['nullable', 'array'],
            'media_order.*' => ['integer', 'exists:product_media,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*' => ['string', 'max:100'],
            'usage' => ['nullable', 'string', 'max:255'],
            'shelf_life' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'voucher_ids' => ['nullable', 'array'],
            'voucher_ids.*' => ['integer', 'exists:vouchers,id'],
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'minimal_grosir.min' => 'Minimal grosir minimal 2.',
            'harga_grosir.lt' => 'Harga grosir harus lebih rendah dari harga normal.',
            'weight.required' => 'Berat produk wajib diisi.',
            'category.required' => 'Kategori produk wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'media.max' => 'Maksimal 4 foto/video.',
            'media.*.mimes' => 'Format harus: jpeg, png, jpg, gif, webp (gambar) atau mp4, webm, ogg (video).',
            'media.*.max' => 'Ukuran file maksimal 15MB.',
        ];
    }
}
