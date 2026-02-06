<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::withTrashed();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'deleted') {
                $query->onlyTrashed();
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Product::distinct()->pluck('category');

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'currentSearch' => $request->search,
            'currentCategory' => $request->category,
            'currentStatus' => $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        // Handle ingredients input (convert from comma-separated string to array)
        if ($request->has('ingredients_input') && $request->ingredients_input) {
            $ingredients = array_map('trim', explode(',', $request->ingredients_input));
            $data['ingredients'] = array_filter($ingredients);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // --- Troubleshooting: Log proses update produk ---
        Log::channel('single')->info('[Product Update] Memulai update produk', [
            'product_id' => $product->id,
            'product_slug' => $product->slug,
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'is_multipart' => str_contains($request->header('Content-Type', ''), 'multipart/form-data'),
            'php_files' => $_FILES ?? [],
            'has_file_image' => $request->hasFile('image'),
            'all_input_keys' => array_keys($request->all()),
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::channel('single')->info('[Product Update] File image diterima', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ]);
        } else {
            Log::channel('single')->warning('[Product Update] File image TIDAK diterima - hasFile(image)=false');
        }

        $data = $request->validated();

        // Handle ingredients input (convert from comma-separated string to array)
        if ($request->has('ingredients_input') && $request->ingredients_input) {
            $ingredients = array_map('trim', explode(',', $request->ingredients_input));
            $data['ingredients'] = array_filter($ingredients);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                Log::channel('single')->info('[Product Update] Gambar lama dihapus', ['path' => $product->image]);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
            Log::channel('single')->info('[Product Update] Gambar baru disimpan', ['path' => $data['image']]);
        } else {
            Log::channel('single')->info('[Product Update] Tidak ada gambar baru - mempertahankan gambar lama', [
                'current_image' => $product->image,
            ]);
        }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Ensure slug is unique (excluding current product)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');

        $product->update($data);

        Log::channel('single')->info('[Product Update] Produk berhasil diperbarui', [
            'product_id' => $product->id,
            'image_field_value' => $product->fresh()->image,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Soft delete
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Restore soft deleted product
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dipulihkan.');
    }

    /**
     * Permanently delete product
     */
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->forceDelete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus permanen.');
    }
}
