@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Edit Produk: {{ $product->name }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white">Informasi Dasar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $product->name) }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text"
                                               name="slug"
                                               class="form-control @error('slug') is-invalid @enderror"
                                               value="{{ old('slug', $product->slug) }}"
                                               placeholder="Akan di-generate otomatis jika kosong">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">URL-friendly identifier (opsional)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Singkat</label>
                                        <textarea name="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="3">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Lengkap</label>
                                        <textarea name="long_description"
                                                  class="form-control @error('long_description') is-invalid @enderror"
                                                  rows="5">{{ old('long_description', $product->long_description) }}</textarea>
                                        @error('long_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mb-3">
                                <div class="card-header bg-success">
                                    <h5 class="mb-0 text-white">Harga</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   name="price"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="{{ old('price', $product->price) }}"
                                                   min="0"
                                                   step="100"
                                                   required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Berat (gram) <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   name="weight"
                                                   class="form-control @error('weight') is-invalid @enderror"
                                                   value="{{ old('weight', $product->weight) }}"
                                                   min="0"
                                                   required>
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   name="category"
                                                   class="form-control @error('category') is-invalid @enderror"
                                                   value="{{ old('category', $product->category) }}"
                                                   list="categories"
                                                   required>
                                            <datalist id="categories">
                                                <option value="Bumbu Masak">
                                                <option value="Ungkep">
                                                <option value="Bumbu Instan">
                                            </datalist>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-info">
                                    <h5 class="mb-0 text-white">Informasi Tambahan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Komposisi (pisahkan dengan koma)</label>
                                        <input type="text"
                                               name="ingredients_input"
                                               class="form-control"
                                               value="{{ old('ingredients_input', is_array($product->ingredients) ? implode(', ', $product->ingredients) : $product->ingredients) }}"
                                               placeholder="Contoh: Cabai merah, Bawang merah, Bawang putih">
                                        <small class="text-muted">Akan dikonversi menjadi array</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cara Pakai</label>
                                        <input type="text"
                                               name="usage"
                                               class="form-control @error('usage') is-invalid @enderror"
                                               value="{{ old('usage', $product->usage) }}"
                                               placeholder="Contoh: 1 pack untuk 1 kg daging sapi">
                                        @error('usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Masa Simpan</label>
                                        <input type="text"
                                               name="shelf_life"
                                               class="form-control @error('shelf_life') is-invalid @enderror"
                                               value="{{ old('shelf_life', $product->shelf_life) }}"
                                               placeholder="Contoh: 6 bulan">
                                        @error('shelf_life')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Image Upload -->
                            <div class="card mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">Gambar Produk</h5>
                                </div>
                                <div class="card-body">
                                    @if($product->image)
                                        <div class="mb-3">
                                            <p class="text-muted small mb-1">Gambar saat ini:</p>
                                            <img src="{{ storage_url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <input type="file"
                                               name="image"
                                               class="form-control @error('image') is-invalid @enderror"
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="imagePreview" class="text-center" style="display: none;">
                                        <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card mb-3">
                                <div class="card-header bg-secondary">
                                    <h5 class="mb-0 text-white">Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Produk Aktif
                                        </label>
                                    </div>
                                    <small class="text-muted">Produk aktif akan ditampilkan di katalog customer</small>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary w-100 mb-2">
                                        <i class="ti-save me-2"></i>Perbarui Produk
                                    </button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                                        <i class="ti-close me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
        }
    }
</script>
@endpush
