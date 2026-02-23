@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}" class="text-decoration-none">Produk</a>
                </li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Media (Foto/Video) -->
            <div class="col-lg-6">
                <div class="position-sticky" style="top: 2rem;">
                    @php
                        $mainMedia = $product->media->first();
                        $primaryUrl = $product->primary_image ? storage_url($product->primary_image) : null;
                        $placeholder = 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\' fill=\'none\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23f8f9fa\'/%3E%3Crect x=\'50\' y=\'75\' width=\'300\' height=\'150\' fill=\'%23dc3545\' fill-opacity=\'0.2\' rx=\'15\'/%3E%3Ctext x=\'200\' y=\'155\' text-anchor=\'middle\' fill=\'%23dc3545\' font-family=\'Arial\' font-size=\'24\' font-weight=\'bold\'%3E' . e(urlencode($product->name)) . '%3C/text%3E%3C/svg%3E';
                    @endphp
                    <div class="card border-0 shadow position-relative">
                        <div id="productMainMedia" class="position-relative product-media-clickable" style="height: 450px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer;">
                            @if($product->media->isNotEmpty())
                                @foreach($product->media as $idx => $m)
                                    <div class="product-media-item {{ $idx === 0 ? '' : 'd-none' }}" data-index="{{ $idx }}" data-src="{{ storage_url($m->path) }}" data-type="{{ $m->isImage() ? 'image' : 'video' }}">
                                        @if($m->isImage())
                                            <img src="{{ storage_url($m->path) }}" alt="{{ $product->name }}" class="w-100" style="height: 450px; object-fit: cover;">
                                        @else
                                            <video src="{{ storage_url($m->path) }}" controls class="w-100" style="height: 450px; object-fit: contain;"></video>
                                        @endif
                                    </div>
                                @endforeach
                                <button type="button" class="btn product-media-nav-btn product-media-prev position-absolute start-0 top-50 translate-middle-y ms-2 rounded-circle p-2" style="z-index: 10; width: 44px; height: 44px;" title="Sebelumnya" aria-label="Sebelumnya">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn product-media-nav-btn product-media-next position-absolute end-0 top-50 translate-middle-y me-2 rounded-circle p-2" style="z-index: 10; width: 44px; height: 44px;" title="Berikutnya" aria-label="Berikutnya">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @else
                                <img src="{{ $primaryUrl ?? $placeholder }}" class="card-img single-product-img" alt="{{ $product->name }}" style="height: 450px; object-fit: cover;" data-src="{{ $primaryUrl ?? '' }}">
                            @endif
                        </div>
                        @if($product->media->count() > 1)
                            <div class="card-body p-2 d-none d-md-flex flex-wrap gap-2">
                                @foreach($product->media as $idx => $m)
                                    <button type="button" class="btn btn-outline-secondary p-0 border rounded overflow-hidden product-media-thumb {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}" style="width: 60px; height: 60px;">
                                        @if($m->isImage())
                                            <img src="{{ storage_url($m->path) }}" alt="" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <span class="d-flex align-items-center justify-content-center w-100 h-100"><i class="bi bi-play-circle"></i></span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="mb-3">
                    <span class="badge bg-primary fs-6">{{ $product->category }}</span>
                </div>
                
                <h1 class="display-5 fw-bold text-dark mb-3">{{ $product->name }}</h1>
                
                <p class="lead text-muted mb-4">{{ $product->description }}</p>
                
                <!-- Price -->
                <div class="bg-light rounded p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            @if($product->normal_price)
                                <div class="mb-1">
                                    <span class="text-danger text-decoration-line-through fs-5">
                                        Rp {{ number_format($product->normal_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="display-6 fw-bold text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                    <small class="text-muted">/pack</small>
                                </span>
                            </div>
                            @if($product->hasGrosir())
                                <div class="mt-2">
                                    <span class="text-success fw-semibold">Harga grosir: Rp {{ number_format($product->harga_grosir, 0, ',', '.') }}</span>
                                    <span class="text-muted">(pembelian minimal {{ $product->minimal_grosir }} packs)</span>
                                </div>
                                <!-- <small class="text-muted d-block mt-1">Harga grosir otomatis saat beli ≥ {{ $product->minimal_grosir }} packs</small> -->
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <div class="card border-primary mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                        </h5>
                        
                        <form id="addToCartForm">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" 
                                               class="form-control text-center" 
                                               id="quantity" 
                                               value="1" 
                                               min="1">
                                        <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-muted small mb-1">Total Harga</div>
                                    <div class="h5 text-primary" id="totalPrice">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    @if($product->hasGrosir())
                                        <small class="text-muted" id="grosirHint"></small>
                                    @endif
                                </div>
                                
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="d-flex gap-2 mb-4">
                    <!-- <button class="btn btn-outline-danger flex-fill" onclick="addToWishlist()">
                        <i class="bi bi-heart me-1"></i>Wishlist
                    </button> -->
                    <button class="btn btn-outline-info flex-fill" onclick="shareProduct()">
                        <i class="bi bi-share me-1"></i>Bagikan
                    </button>
                    <a href="{{ config('constants.social_media.whatsapp') }}?text=Halo, saya tertarik dengan {{ urlencode($product->name) }}" 
                       class="btn btn-success flex-fill">
                        <i class="bi bi-whatsapp me-1"></i>Tanya Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Accordion -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="accordion" id="productAccordion">
                    <!-- Deskripsi -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDescription">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="true" aria-controls="collapseDescription">
                                <i class="bi bi-info-circle me-2"></i>Deskripsi
                            </button>
                        </h2>
                        <div id="collapseDescription" class="accordion-collapse collapse show" aria-labelledby="headingDescription">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mb-3">Deskripsi Produk</h4>
                                        <div class="lead" style="white-space: pre-line;">{{ $product->long_description ?? $product->description }}</div>
                                        
                                        <h5 class="mt-4 mb-3">Keunggulan Produk</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                Terbuat dari rempah-rempah pilihan berkualitas tinggi
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                Proses pengolahan higienis dan terjamin
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                Cita rasa autentik dan tahan lama
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                Kemasan praktis dan mudah disimpan
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3">Informasi Produk</h6>
                                                <div class="mb-2">
                                                    <small class="text-muted">Berat:</small>
                                                    <span class="ms-2">{{ $product->weight }} gram</span>
                                                </div>
                                                <div class="mb-2">
                                                    <small class="text-muted">Kategori:</small>
                                                    <span class="ms-2">{{ $product->category }}</span>
                                                </div>
                                                @if($product->shelf_life)
                                                    <div class="mb-2">
                                                        <small class="text-muted">Masa Simpan:</small>
                                                        <span class="ms-2">{{ $product->shelf_life }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Komposisi -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingIngredients">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredients" aria-expanded="true" aria-controls="collapseIngredients">
                                <i class="bi bi-list-ul me-2"></i>Komposisi
                            </button>
                        </h2>
                        <div id="collapseIngredients" class="accordion-collapse collapse show" aria-labelledby="headingIngredients">
                            <div class="accordion-body">
                                <h4 class="mb-3">Komposisi</h4>
                                @if($product->ingredients && is_array($product->ingredients) && count($product->ingredients) > 0)
                                    <div class="row">
                                        @foreach(array_chunk($product->ingredients, 3) as $chunk)
                                            <div class="col-md-4">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($chunk as $ingredient)
                                                        <li class="list-group-item d-flex align-items-center">
                                                            <i class="bi bi-dot text-primary me-2" style="font-size: 1.5rem;"></i>
                                                            {{ $ingredient }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Informasi komposisi akan segera tersedia.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Cara Pakai -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUsage">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsage" aria-expanded="true" aria-controls="collapseUsage">
                                <i class="bi bi-book me-2"></i>Cara Pakai
                            </button>
                        </h2>
                        <div id="collapseUsage" class="accordion-collapse collapse show" aria-labelledby="headingUsage">
                            <div class="accordion-body">
                                <h4 class="mb-3">Cara Penggunaan</h4>
                                @php
                                    $usageSteps = $product->usage
                                        ? array_filter(array_map('trim', explode(';', $product->usage)))
                                        : [];
                                @endphp
                                @if(count($usageSteps) > 0)
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <ol class="list-group list-group-numbered">
                                                @foreach($usageSteps as $step)
                                                    <li class="list-group-item">{{ $step }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">Informasi cara penggunaan akan segera tersedia.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Instruksi -->
        <div class="card shadow-sm mb-4 border-0 mt-4">
            <div class="card-header bg-light border-0 py-3">
                <h5 class="mb-0"><i class="bi bi-list-ol me-2"></i>Cara Pemesanan</h5>
            </div>
            <div class="card-body py-4">
                <div class="row align-items-stretch g-0 flex-md-nowrap">
                    <!-- Step 1: Masuk Keranjang -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold">1</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Masuk Keranjang</h6>
                            <p class="small text-muted mb-0">Tambahkan produk ke keranjang belanja dari halaman produk yang Anda inginkan.</p>
                        </div>
                    </div>
                    <div class="col-auto d-none d-md-flex align-items-center text-muted">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <!-- Step 2: Checkout -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold">2</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Checkout</h6>
                            <p class="small text-muted mb-0">Lengkapi data pemesan dan alamat pengiriman untuk melanjutkan pesanan.</p>
                        </div>
                    </div>
                    <div class="col-auto d-none d-md-flex align-items-center text-muted">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <!-- Step 3: Bayar -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold">3</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Bayar</h6>
                            <p class="small text-muted mb-0">Lakukan pembayaran sesuai metode yang dipilih untuk menyelesaikan pesanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Produk Terkait</h2>
                <p class="section-subtitle">Produk lainnya yang mungkin Anda suka</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Related products from database -->
            @forelse($relatedProducts as $related)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <img src="{{ $related->image ? storage_url($related->image) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 250\' fill=\'none\'%3E%3Crect width=\'400\' height=\'250\' fill=\'%23f8f9fa\'/%3E%3Crect x=\'50\' y=\'50\' width=\'300\' height=\'150\' fill=\'%23dc3545\' fill-opacity=\'0.2\' rx=\'10\'/%3E%3Ctext x=\'200\' y=\'125\' text-anchor=\'middle\' fill=\'%23dc3545\' font-family=\'Arial\' font-size=\'16\' font-weight=\'bold\'%3E' . e(urlencode($related->name)) . '%3C/text%3E%3C/svg%3E' }}" 
                         class="card-img-top" 
                         alt="{{ $related->name }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $related->name }}</h5>
                        <p class="card-text">{{ \Str::limit($related->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted text-center">Tidak ada produk terkait</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Lightbox popup (di luar kolom agar selalu di atas) -->
    <div id="productMediaLightbox" class="product-media-lightbox" role="dialog" aria-modal="true" aria-label="Tampilan besar foto/video" style="display: none;">
        <div class="product-media-lightbox-backdrop"></div>
        <button type="button" class="product-media-lightbox-close product-media-lightbox-btn btn position-absolute top-0 end-0 m-3 rounded-circle shadow" style="z-index: 10002; width: 48px; height: 48px;" title="Tutup" aria-label="Tutup">
            <i class="bi bi-x-lg fs-4"></i>
        </button>
        <div class="product-media-lightbox-content position-relative d-flex align-items-center justify-content-center w-100 h-100 p-2 p-md-4" style="z-index: 10001;">
            <button type="button" class="product-media-lightbox-prev product-media-lightbox-btn btn position-absolute start-0 top-50 translate-middle-y rounded-circle shadow ms-2" style="z-index: 10002; width: 48px; height: 48px;" title="Sebelumnya"><i class="bi bi-chevron-left"></i></button>
            <div class="product-media-lightbox-media w-100 h-100 d-flex align-items-center justify-content-center overflow-hidden" style="z-index: 1;"></div>
            <button type="button" class="product-media-lightbox-next product-media-lightbox-btn btn position-absolute end-0 top-50 translate-middle-y rounded-circle shadow me-2" style="z-index: 10002; width: 48px; height: 48px;" title="Berikutnya"><i class="bi bi-chevron-right"></i></button>
            <!-- Zoom controls (hanya untuk gambar) -->
            <div class="product-media-lightbox-zoom-controls position-absolute bottom-0 start-50 translate-middle-x d-flex align-items-center gap-1 rounded-pill shadow p-1 bg-dark bg-opacity-50" style="z-index: 10002; display: none !important;">
                <button type="button" class="product-media-lightbox-zoom-out product-media-lightbox-btn btn rounded-circle p-0" style="width: 40px; height: 40px;" title="Perkecil" aria-label="Perkecil"><i class="bi bi-dash-lg"></i></button>
                <button type="button" class="product-media-lightbox-zoom-reset product-media-lightbox-btn btn rounded-circle p-0 small" style="width: 40px; height: 40px;" title="Reset zoom" aria-label="Reset">1:1</button>
                <button type="button" class="product-media-lightbox-zoom-in product-media-lightbox-btn btn rounded-circle p-0" style="width: 40px; height: 40px;" title="Perbesar" aria-label="Perbesar"><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .product-media-lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.92);
    }
    .product-media-lightbox-backdrop {
        position: absolute;
        inset: 0;
        cursor: pointer;
    }
    .product-media-lightbox-media {
        width: 100%;
        touch-action: none;
    }
    .product-media-lightbox-zoom-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transform-origin: center center;
        transition: transform 0.2s ease-out;
        cursor: grab;
        user-select: none;
    }
    .product-media-lightbox-zoom-wrap.dragging {
        cursor: grabbing;
    }
    .product-media-lightbox-zoom-wrap img,
    .product-media-lightbox-zoom-wrap video {
        max-width: 100%;
        max-height: 100vh;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 4px;
        pointer-events: none;
    }
    .product-media-lightbox-media img,
    .product-media-lightbox-media video {
        width: 100%;
        max-height: 100vh;
        object-fit: contain;
        border-radius: 4px;
    }
    .product-media-lightbox-media video {
        background: #000;
    }
    .product-media-lightbox-zoom-controls.show {
        display: flex !important;
    }
    .product-media-lightbox-btn {
        background: rgba(255, 255, 255, 0.25) !important;
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #fff;
    }
    .product-media-lightbox-btn:hover {
        background: rgba(255, 255, 255, 0.4) !important;
        color: #fff;
        border-color: rgba(255, 255, 255, 0.6);
    }
    .product-media-nav-btn {
        background: rgba(255, 255, 255, 0.3) !important;
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: #333;
    }
    .product-media-nav-btn:hover {
        background: rgba(255, 255, 255, 0.6) !important;
        border-color: rgba(0, 0, 0, 0.15);
        color: #333;
    }
    /* Mobile optimizations for product detail */
    @media (max-width: 991.98px) {
        .position-sticky {
            position: static !important;
        }
        
        .col-lg-6:first-child {
            margin-bottom: 2rem;
        }
        
        .card-img {
            height: auto !important;
            max-height: 400px;
        }
    }
    
    @media (max-width: 767.98px) {
        .display-5 {
            font-size: 1.75rem;
        }
        
        .lead {
            font-size: 1rem;
        }
        
        .row.g-3 > .col-md-4 {
            margin-bottom: 1rem;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
        }
        
        .d-flex.gap-2 > * {
            width: 100%;
        }
        
        .nav-tabs {
            flex-wrap: wrap;
        }
        
        .nav-tabs .nav-item {
            flex: 1;
            min-width: 120px;
        }
        
        .nav-tabs .nav-link {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const productPrice = {{ $product->price }};
    const productMinimalGrosir = {{ $product->minimal_grosir ?? 'null' }};
    const productHargaGrosir = {{ $product->harga_grosir ?? 'null' }};
    const productImageUrl = {!! json_encode($product->primary_image ? storage_url($product->primary_image) : '') !!};

    function getUnitPrice(quantity) {
        if (quantity <= 0) return productPrice;
        if (productMinimalGrosir != null && productHargaGrosir != null && quantity >= productMinimalGrosir)
            return productHargaGrosir;
        return productPrice;
    }

    // Product media gallery: show item by index
    function showProductMediaIndex(idx) {
        document.querySelectorAll('.product-media-item').forEach(function(el) {
            el.classList.toggle('d-none', el.getAttribute('data-index') !== String(idx));
        });
        document.querySelectorAll('.product-media-thumb').forEach(function(b) {
            b.classList.remove('active');
            if (b.getAttribute('data-index') === String(idx)) b.classList.add('active');
        });
    }
    var productMediaCount = document.querySelectorAll('.product-media-item').length;
    document.querySelectorAll('.product-media-thumb').forEach(function(btn) {
        btn.addEventListener('click', function() {
            showProductMediaIndex(this.getAttribute('data-index'));
        });
    });
    var prevBtn = document.querySelector('.product-media-prev');
    var nextBtn = document.querySelector('.product-media-next');
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            var current = document.querySelector('.product-media-item:not(.d-none)');
            if (!current) return;
            var idx = parseInt(current.getAttribute('data-index'), 10);
            var prev = idx <= 0 ? productMediaCount - 1 : idx - 1;
            showProductMediaIndex(prev);
        });
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            var current = document.querySelector('.product-media-item:not(.d-none)');
            if (!current) return;
            var idx = parseInt(current.getAttribute('data-index'), 10);
            var next = idx >= productMediaCount - 1 ? 0 : idx + 1;
            showProductMediaIndex(next);
        });
    }

    // Lightbox popup: build media list from DOM
    var productMediaList = [];
    var items = document.querySelectorAll('.product-media-item');
    if (items.length) {
        items.forEach(function(el) {
            productMediaList.push({ src: el.getAttribute('data-src'), type: el.getAttribute('data-type') || 'image' });
        });
    } else {
        var singleImg = document.querySelector('.single-product-img');
        if (singleImg && singleImg.getAttribute('data-src')) {
            productMediaList.push({ src: singleImg.getAttribute('data-src'), type: 'image' });
        }
    }
    var lightbox = document.getElementById('productMediaLightbox');
    var lightboxMedia = lightbox ? lightbox.querySelector('.product-media-lightbox-media') : null;
    var lightboxBackdrop = lightbox ? lightbox.querySelector('.product-media-lightbox-backdrop') : null;
    var lightboxClose = lightbox ? lightbox.querySelector('.product-media-lightbox-close') : null;
    var lightboxPrev = lightbox ? lightbox.querySelector('.product-media-lightbox-prev') : null;
    var lightboxNext = lightbox ? lightbox.querySelector('.product-media-lightbox-next') : null;
    var lightboxZoomControls = lightbox ? lightbox.querySelector('.product-media-lightbox-zoom-controls') : null;
    var lightboxZoomIn = lightbox ? lightbox.querySelector('.product-media-lightbox-zoom-in') : null;
    var lightboxZoomOut = lightbox ? lightbox.querySelector('.product-media-lightbox-zoom-out') : null;
    var lightboxZoomReset = lightbox ? lightbox.querySelector('.product-media-lightbox-zoom-reset') : null;
    var lightboxCurrentIndex = 0;

    var lightboxZoom = { scale: 1, x: 0, y: 0 };
    var lightboxZoomWrap = null;
    var lightboxDrag = { active: false, startX: 0, startY: 0, startTx: 0, startTy: 0 };

    function applyLightboxZoom() {
        if (!lightboxZoomWrap) return;
        var t = lightboxZoom;
        lightboxZoomWrap.style.transform = 'translate(' + t.x + 'px, ' + t.y + 'px) scale(' + t.scale + ')';
    }
    function resetLightboxZoom() {
        lightboxZoom.scale = 1;
        lightboxZoom.x = 0;
        lightboxZoom.y = 0;
        applyLightboxZoom();
    }
    function lightboxZoomInClick() {
        if (!lightboxZoomWrap) return;
        lightboxZoom.scale = Math.min(4, lightboxZoom.scale + 0.5);
        applyLightboxZoom();
    }
    function lightboxZoomOutClick() {
        if (!lightboxZoomWrap) return;
        lightboxZoom.scale = Math.max(0.5, lightboxZoom.scale - 0.5);
        if (lightboxZoom.scale === 1) { lightboxZoom.x = 0; lightboxZoom.y = 0; }
        applyLightboxZoom();
    }

    function openLightbox(index) {
        if (!lightbox || !lightboxMedia || productMediaList.length === 0) return;
        lightboxCurrentIndex = Math.max(0, Math.min(index, productMediaList.length - 1));
        var item = productMediaList[lightboxCurrentIndex];
        lightboxMedia.innerHTML = '';
        resetLightboxZoom();
        lightboxZoomWrap = null;
        if (lightboxZoomControls) lightboxZoomControls.classList.remove('show');

        if (item.type === 'video') {
            var video = document.createElement('video');
            video.src = item.src;
            video.controls = true;
            video.className = 'w-100 h-100';
            lightboxMedia.appendChild(video);
        } else {
            var wrap = document.createElement('div');
            wrap.className = 'product-media-lightbox-zoom-wrap';
            var img = document.createElement('img');
            img.src = item.src;
            img.alt = 'Tampilan besar';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100vh';
            img.style.width = 'auto';
            img.style.height = 'auto';
            wrap.appendChild(img);
            lightboxMedia.appendChild(wrap);
            lightboxZoomWrap = wrap;
            if (lightboxZoomControls) lightboxZoomControls.classList.add('show');

            wrap.addEventListener('dblclick', function(e) {
                e.preventDefault();
                if (lightboxZoom.scale > 1) { resetLightboxZoom(); } else { lightboxZoom.scale = 2; applyLightboxZoom(); }
            });
            wrap.addEventListener('mousedown', function(e) {
                if (lightboxZoom.scale <= 1 || e.button !== 0) return;
                lightboxDrag.active = true;
                lightboxDrag.startX = e.clientX;
                lightboxDrag.startY = e.clientY;
                lightboxDrag.startTx = lightboxZoom.x;
                lightboxDrag.startTy = lightboxZoom.y;
                wrap.classList.add('dragging');
            });
            wrap.addEventListener('touchstart', function(e) {
                if (lightboxZoom.scale <= 1 || e.touches.length !== 1) return;
                e.preventDefault();
                lightboxDrag.active = true;
                lightboxDrag.startX = e.touches[0].clientX;
                lightboxDrag.startY = e.touches[0].clientY;
                lightboxDrag.startTx = lightboxZoom.x;
                lightboxDrag.startTy = lightboxZoom.y;
                wrap.classList.add('dragging');
            }, { passive: false });
            wrap.addEventListener('touchmove', function(e) {
                if (!lightboxDrag.active || e.touches.length !== 1) return;
                e.preventDefault();
                lightboxZoom.x = lightboxDrag.startTx + (e.touches[0].clientX - lightboxDrag.startX);
                lightboxZoom.y = lightboxDrag.startTy + (e.touches[0].clientY - lightboxDrag.startY);
                applyLightboxZoom();
            }, { passive: false });
            wrap.addEventListener('touchend', function() {
                if (lightboxZoomWrap) lightboxZoomWrap.classList.remove('dragging');
                lightboxDrag.active = false;
            });
        }
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        if (lightboxPrev) lightboxPrev.style.display = productMediaList.length > 1 ? '' : 'none';
        if (lightboxNext) lightboxNext.style.display = productMediaList.length > 1 ? '' : 'none';
    }
    function closeLightbox() {
        if (!lightbox) return;
        lightbox.style.display = 'none';
        document.body.style.overflow = '';
        lightboxZoomWrap = null;
        if (lightboxMedia) {
            var v = lightboxMedia.querySelector('video');
            if (v) v.pause();
        }
    }
    function lightboxShowPrev() {
        if (productMediaList.length <= 1) return;
        lightboxCurrentIndex = lightboxCurrentIndex <= 0 ? productMediaList.length - 1 : lightboxCurrentIndex - 1;
        openLightbox(lightboxCurrentIndex);
    }
    function lightboxShowNext() {
        if (productMediaList.length <= 1) return;
        lightboxCurrentIndex = lightboxCurrentIndex >= productMediaList.length - 1 ? 0 : lightboxCurrentIndex + 1;
        openLightbox(lightboxCurrentIndex);
    }

    var clickableArea = document.querySelector('.product-media-clickable');
    if (clickableArea) {
        clickableArea.addEventListener('click', function(e) {
            if (e.target.closest('.product-media-prev') || e.target.closest('.product-media-next')) return;
            var idx = 0;
            var visible = document.querySelector('.product-media-item:not(.d-none)');
            if (visible) idx = parseInt(visible.getAttribute('data-index'), 10);
            else if (document.querySelector('.single-product-img')) idx = 0;
            openLightbox(idx);
        });
    }
    if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);
    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxPrev) lightboxPrev.addEventListener('click', function(e) { e.stopPropagation(); lightboxShowPrev(); });
    if (lightboxNext) lightboxNext.addEventListener('click', function(e) { e.stopPropagation(); lightboxShowNext(); });
    if (lightboxZoomIn) lightboxZoomIn.addEventListener('click', function(e) { e.stopPropagation(); lightboxZoomInClick(); });
    if (lightboxZoomOut) lightboxZoomOut.addEventListener('click', function(e) { e.stopPropagation(); lightboxZoomOutClick(); });
    if (lightboxZoomReset) lightboxZoomReset.addEventListener('click', function(e) { e.stopPropagation(); resetLightboxZoom(); });
    document.addEventListener('mousemove', function(e) {
        if (!lightboxDrag.active || !lightboxZoomWrap) return;
        lightboxZoom.x = lightboxDrag.startTx + (e.clientX - lightboxDrag.startX);
        lightboxZoom.y = lightboxDrag.startTy + (e.clientY - lightboxDrag.startY);
        applyLightboxZoom();
    });
    document.addEventListener('mouseup', function() {
        if (lightboxZoomWrap) lightboxZoomWrap.classList.remove('dragging');
        lightboxDrag.active = false;
    });
    document.addEventListener('keydown', function(e) {
        if (!lightbox || lightbox.style.display !== 'flex') return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') lightboxShowPrev();
        if (e.key === 'ArrowRight') lightboxShowNext();
    });

    // Update quantity and total price
    function changeQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let currentQuantity = parseInt(quantityInput.value);
        const newQuantity = currentQuantity + change;
        
        if (newQuantity >= 1) {
            quantityInput.value = newQuantity;
            updateTotalPrice();
        }
    }
    
    // Update total price display
    function updateTotalPrice() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const unitPrice = getUnitPrice(quantity);
        const total = unitPrice * quantity;
        document.getElementById('totalPrice').textContent = 
            'Rp ' + total.toLocaleString('id-ID');
        var hint = document.getElementById('grosirHint');
        if (hint) {
            if (productMinimalGrosir != null && quantity >= productMinimalGrosir)
                hint.textContent = 'Harga grosir diterapkan';
            else
                hint.textContent = '';
        }
    }
    
    // Handle quantity input change
    document.getElementById('quantity').addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value < 1) this.value = 1;
        updateTotalPrice();
    });
    
    // Handle add to cart form
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const unitPrice = getUnitPrice(quantity);
        const total = unitPrice * quantity;
        
        alert('Ditambahkan ke keranjang!\n{{ $product->name }}\nJumlah: ' + quantity + '\nTotal: Rp ' + total.toLocaleString('id-ID'));
        
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push({ 
            id: {{ $product->id }}, 
            name: '{{ addslashes($product->name) }}',
            price: {{ $product->price }},
            minimal_grosir: productMinimalGrosir,
            harga_grosir: productHargaGrosir,
            description: '{{ addslashes($product->description) }}',
            quantity: quantity,
            image: productImageUrl || ''
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Trigger cart update
        window.dispatchEvent(new Event('cart-updated'));
        
        // Show success feedback
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check me-2"></i>Ditambahkan!';
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
        }, 2000);
    });
    
    // Wishlist function (temporary)
    // function addToWishlist() {
    //     alert('Fitur wishlist akan tersedia di update mendatang!');
    // }
    
    // Share function
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ addslashes($product->name) }}',
                text: '{{ addslashes($product->description) }}',
                url: window.location.href
            });
        } else {
            // Fallback - copy to clipboard
            navigator.clipboard.writeText(window.location.href);
            alert('Link produk telah disalin ke clipboard!');
        }
    }
</script>
@endpush