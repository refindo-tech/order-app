@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Detail Produk: {{ $product->name }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                            <i class="ti-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="row">
        <div class="col-md-8">
            <!-- Basic Info -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Produk</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nama Produk:</strong>
                        <p class="mT-5">{{ $product->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Slug:</strong>
                        <p class="mT-5"><code>{{ $product->slug }}</code></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Kategori:</strong>
                        <p class="mT-5"><span class="badge bg-primary">{{ $product->category }}</span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p class="mT-5">
                            @if($product->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Deskripsi Singkat:</strong>
                        <p class="mT-5">{{ $product->description ?? '-' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Deskripsi Lengkap:</strong>
                        <p class="mT-5">{{ $product->long_description ?? $product->description ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Harga</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Harga:</strong>
                        <p class="mT-5 h4 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Berat:</strong>
                        <p class="mT-5">{{ $product->weight }} gram</p>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            @if($product->ingredients || $product->usage || $product->shelf_life)
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Tambahan</h5>
                @if($product->ingredients && count($product->ingredients) > 0)
                    <div class="mb-3">
                        <strong>Komposisi:</strong>
                        <ul class="mT-5">
                            @foreach($product->ingredients as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($product->usage)
                    <div class="mb-3">
                        <strong>Cara Pakai:</strong>
                        <p class="mT-5">{{ $product->usage }}</p>
                    </div>
                @endif
                @if($product->shelf_life)
                    <div class="mb-3">
                        <strong>Masa Simpan:</strong>
                        <p class="mT-5">{{ $product->shelf_life }}</p>
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Product Image -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Gambar Produk</h5>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded">
                @else
                    <div class="text-center p-4 bg-light rounded">
                        <i class="ti-image" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mT-10">Tidak ada gambar</p>
                    </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Statistik</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Dibuat:</span>
                    <strong>{{ $product->created_at->format('d M Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Diupdate:</span>
                    <strong>{{ $product->updated_at->format('d M Y') }}</strong>
                </div>
                @if($product->orderItems()->count() > 0)
                    <div class="d-flex justify-content-between">
                        <span>Total Order:</span>
                        <strong>{{ $product->orderItems()->count() }}</strong>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="bgc-white bd bdrs-3 p-20">
                <h5 class="c-grey-900 mB-20">Aksi</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="ti-pencil me-2"></i>Edit Produk
                    </a>
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-info">
                        <i class="ti-eye me-2"></i>Lihat di Website
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="ti-trash me-2"></i>Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection