<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductMedia;
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

        // Handle ingredients input (convert from semicolon-separated string to array)
        if ($request->has('ingredients_input') && $request->ingredients_input) {
            $ingredients = array_map('trim', explode(';', $request->ingredients_input));
            $data['ingredients'] = array_filter($ingredients);
        }

        // Single image (backward compat) or first of media
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->hasFile('media')) {
            $files = $request->file('media');
            $firstImage = collect($files)->first(fn ($f) => str_starts_with($f->getMimeType(), 'image/'));
            if ($firstImage) {
                $data['image'] = $firstImage->store('products', 'public');
            }
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

        // Remove media keys from $data so we don't mass-assign
        unset($data['media'], $data['remove_media']);

        $product = Product::create($data);

        // Store multiple media (up to 4)
        if ($request->hasFile('media')) {
            $sortOrder = 0;
            foreach ($request->file('media') as $file) {
                $path = $file->store('products', 'public');
                $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';
                $product->media()->create([
                    'path' => $path,
                    'type' => $type,
                    'sort_order' => $sortOrder++,
                ]);
            }
            // Sync primary image from first image media
            $firstImageMedia = $product->media()->where('type', 'image')->first();
            if ($firstImageMedia && !$product->image) {
                $product->update(['image' => $firstImageMedia->path]);
            }
        } elseif ($request->hasFile('image')) {
            $product->media()->create([
                'path' => $product->image,
                'type' => 'image',
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.products.show', $product)
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
        $data = $request->validated();

        // Handle ingredients input (convert from semicolon-separated string to array)
        if ($request->has('ingredients_input') && $request->ingredients_input) {
            $ingredients = array_map('trim', explode(';', $request->ingredients_input));
            $data['ingredients'] = array_filter($ingredients);
        }

        // Remove media: delete selected product_media and their files
        $removeIds = $request->input('remove_media', []);
        if (!empty($removeIds)) {
            $toRemove = $product->media()->whereIn('id', $removeIds)->get();
            foreach ($toRemove as $m) {
                Storage::disk('public')->delete($m->path);
                $m->delete();
            }
        }

        // Apply new order for existing (kept) media
        $mediaOrder = $request->input('media_order', []);
        foreach ($mediaOrder as $pos => $id) {
            ProductMedia::where('id', $id)->where('product_id', $product->id)->update(['sort_order' => $pos]);
        }

        // Single image: add as new media (image type)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $maxOrder = (int) $product->media()->max('sort_order');
            $product->media()->create([
                'path' => $path,
                'type' => 'image',
                'sort_order' => $maxOrder + 1,
            ]);
        }

        // New media files: total media must stay <= 4 (currentCount already reflects removals)
        $currentCount = $product->media()->count();
        $newFiles = $request->file('media', []);
        $sortOrderStart = !empty($mediaOrder) ? count($mediaOrder) : $currentCount;
        if (!empty($newFiles)) {
            $maxNew = max(0, 4 - $currentCount);
            $added = 0;
            foreach ($newFiles as $file) {
                if ($added >= $maxNew) {
                    break;
                }
                $path = $file->store('products', 'public');
                $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';
                $product->media()->create([
                    'path' => $path,
                    'type' => $type,
                    'sort_order' => $sortOrderStart + $added,
                ]);
                $added++;
            }
        }

        // Sync primary image from first image in media (for listing/backward compat)
        $firstImage = $product->media()->where('type', 'image')->orderBy('sort_order')->first();
        $data['image'] = $firstImage ? $firstImage->path : null;

        unset($data['media'], $data['remove_media'], $data['media_order']);

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

        return redirect()->route('admin.products.show', $product)
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

        foreach ($product->media as $m) {
            Storage::disk('public')->delete($m->path);
        }
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus permanen.');
    }
}
