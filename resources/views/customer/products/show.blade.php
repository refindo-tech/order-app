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
                        <div class="col-md-6">
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="display-6 fw-bold text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">per pack</small>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex align-items-center text-muted justify-content-md-end">
                                <i class="bi bi-weight me-2"></i>
                                <span>Berat: {{ $product->weight }}g</span>
                            </div>
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

        <!-- Product Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                            <i class="bi bi-info-circle me-2"></i>Deskripsi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ingredients-tab" data-bs-toggle="tab" data-bs-target="#ingredients" type="button">
                            <i class="bi bi-list-ul me-2"></i>Komposisi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="usage-tab" data-bs-toggle="tab" data-bs-target="#usage" type="button">
                            <i class="bi bi-book me-2"></i>Cara Pakai
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content py-4" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
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
                    
                    <!-- Ingredients Tab -->
                    <div class="tab-pane fade" id="ingredients" role="tabpanel">
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
                    
                    <!-- Usage Tab -->
                    <div class="tab-pane fade" id="usage" role="tabpanel">
                        <h4 class="mb-3">Cara Penggunaan</h4>
                        @if($product->usage)
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Takaran:</strong> {{ $product->usage }}
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item">Siapkan bahan utama sesuai kebutuhan</li>
                                    <li class="list-group-item">Tumis bumbu hingga harum dengan sedikit minyak</li>
                                    <li class="list-group-item">Masukkan bahan utama dan aduk rata</li>
                                    <li class="list-group-item">Tambahkan air secukupnya dan masak hingga matang</li>
                                    <li class="list-group-item">Koreksi rasa dan sajikan selagi hangat</li>
                                </ol>
                            </div>
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
            <div class="product-media-lightbox-media w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 1;"></div>
            <button type="button" class="product-media-lightbox-next product-media-lightbox-btn btn position-absolute end-0 top-50 translate-middle-y rounded-circle shadow me-2" style="z-index: 10002; width: 48px; height: 48px;" title="Berikutnya"><i class="bi bi-chevron-right"></i></button>
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
    var lightboxCurrentIndex = 0;

    function openLightbox(index) {
        if (!lightbox || !lightboxMedia || productMediaList.length === 0) return;
        lightboxCurrentIndex = Math.max(0, Math.min(index, productMediaList.length - 1));
        var item = productMediaList[lightboxCurrentIndex];
        lightboxMedia.innerHTML = '';
        if (item.type === 'video') {
            var video = document.createElement('video');
            video.src = item.src;
            video.controls = true;
            video.className = 'w-100 h-100';
            lightboxMedia.appendChild(video);
        } else {
            var img = document.createElement('img');
            img.src = item.src;
            img.alt = 'Tampilan besar';
            img.className = 'w-100 h-100';
            lightboxMedia.appendChild(img);
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
        const quantity = parseInt(document.getElementById('quantity').value);
        const total = productPrice * quantity;
        document.getElementById('totalPrice').textContent = 
            'Rp ' + total.toLocaleString('id-ID');
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
        const quantity = parseInt(document.getElementById('quantity').value);
        
        // Show success feedback
        alert(`Ditambahkan ke keranjang!\n{{ $product->name }}\nJumlah: ${quantity}\nTotal: Rp ${({{ $product->price }} * quantity).toLocaleString('id-ID')}`);
        
        // Add to localStorage
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push({ 
            id: {{ $product->id }}, 
            name: '{{ addslashes($product->name) }}',
            price: {{ $product->price }},
            description: '{{ addslashes($product->description) }}',
            quantity: quantity 
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