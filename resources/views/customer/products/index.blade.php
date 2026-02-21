@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<!-- Page Header -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-dark">Katalog Produk</h1>
                <p class="lead text-muted">
                    Jelajahi koleksi lengkap bumbu dan ungkep berkualitas premium kami
                </p>
            </div>
            <div class="col-lg-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4">
                <!-- Mobile Filter Toggle Button -->
                <button class="btn btn-primary w-100 d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-expanded="false" aria-controls="filterSidebar">
                    <i class="bi bi-funnel me-2"></i>Filter Produk
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                
                <div class="collapse d-lg-block" id="filterSidebar">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-none d-lg-block">
                            <h5 class="mb-0">
                                <i class="bi bi-funnel me-2"></i>Filter Produk
                            </h5>
                        </div>
                        <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       placeholder="Cari produk..." 
                                       value="{{ $currentSearch }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            @if($currentCategory)
                                <input type="hidden" name="category" value="{{ $currentCategory }}">
                            @endif
                        </form>

                        <!-- Category Filter -->
                        <h6 class="fw-bold mb-3">Kategori</h6>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('products.index') }}" 
                               class="list-group-item list-group-item-action {{ !$currentCategory ? 'active' : '' }}">
                                <i class="bi bi-grid me-2"></i>Semua Produk
                                <span class="badge bg-secondary rounded-pill float-end">{{ $products->count() }}</span>
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category]) }}" 
                                   class="list-group-item list-group-item-action {{ $currentCategory === $category ? 'active' : '' }}">
                                    <i class="bi bi-tag me-2"></i>{{ $category }}
                                    <span class="badge bg-secondary rounded-pill float-end">
                                        {{ $products->where('category', $category)->count() }}
                                    </span>
                                </a>
                            @endforeach
                        </div>

                        @if($currentSearch || $currentCategory)
                            <div class="mt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="bi bi-x-circle me-1"></i>Reset Filter
                                </a>
                            </div>
                        @endif
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="card mt-4">
                        <div class="card-body text-center">
                            <i class="bi bi-info-circle text-info" style="font-size: 2rem;"></i>
                            <h6 class="mt-2">Butuh Bantuan?</h6>
                            <p class="small text-muted mb-3">
                                Tim kami siap membantu Anda memilih produk yang tepat
                            </p>
                            <a href="{{ config('constants.social_media.whatsapp') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp me-1"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Results Info -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">
                            @if($currentSearch)
                                Hasil pencarian "{{ $currentSearch }}"
                            @elseif($currentCategory)
                                Kategori: {{ $currentCategory }}
                            @else
                                Semua Produk
                            @endif
                        </h5>
                        <p class="text-muted mb-0">
                            Menampilkan {{ $products->count() }} produk
                        </p>
                    </div>
                    
                    <!-- Sort Options (for future) -->
                    <!-- <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sort-down me-1"></i>Urutkan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Nama A-Z</a></li>
                            <li><a class="dropdown-item" href="#">Harga Terendah</a></li>
                            <li><a class="dropdown-item" href="#">Harga Tertinggi</a></li>
                        </ul>
                    </div> -->
                </div>

                @if($products->isNotEmpty())
                    <div class="row g-2 g-md-4 product-grid-row">
                        @foreach($products as $product)
                            <div class="col-6 col-md-6 col-lg-4">
                                <div class="card h-100 product-card position-relative">
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-card-link stretched-link" aria-label="Lihat detail {{ $product->name }}"></a>
                                    <!-- Product Image -->
                                    <div class="position-relative product-card-img-wrap">
                                        <img src="{{ $product->image ? storage_url($product->image) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 250\' fill=\'none\'%3E%3Crect width=\'400\' height=\'250\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'200\' y=\'125\' text-anchor=\'middle\' fill=\'%23dc3545\' font-family=\'Arial\' font-size=\'16\'%3ENo Image%3C/text%3E%3C/svg%3E' }}" 
                                             class="card-img-top product-card-img" 
                                             alt="{{ $product->name }}">
                                        
                                        <div class="position-absolute top-0 start-0 product-card-badge">
                                            <span class="badge bg-primary">{{ $product->category }}</span>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="card-body d-flex flex-column product-card-body">
                                        <h5 class="card-title product-card-title">{{ $product->name }}</h5>
                                        <p class="card-text text-muted flex-grow-1 product-card-desc">
                                            {{ \Str::limit($product->description, 80) }}
                                        </p>
                                        
                                        <!-- Product Details -->
                                        <div class="mb-2 mb-md-3 product-card-details">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                                <span class="product-card-price text-primary">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                                <small class="text-muted product-card-weight d-none d-md-inline">{{ $product->weight }}g</small>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-auto product-card-actions-wrap position-relative">
                                            <div class="d-flex gap-1 gap-md-2 product-card-actions">
                                                <a href="{{ route('products.show', $product->slug) }}" 
                                                   class="btn btn-outline-primary btn-sm flex-grow-1 product-card-btn">
                                                    <i class="bi bi-eye product-card-btn-icon me-2"></i><span class="product-card-btn-text">Detail</span>
                                                </a>
                                                <button type="button" class="btn btn-primary btn-sm flex-grow-1 product-card-btn" 
                                                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->description) }}')">
                                                    <i class="bi bi-cart-plus product-card-btn-icon me-2"></i><span class="product-card-btn-text">Keranjang</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">Produk Tidak Ditemukan</h4>
                        <p class="text-muted mb-4">
                            @if($currentSearch)
                                Tidak ada produk yang sesuai dengan pencarian "{{ $currentSearch }}"
                            @else
                                Tidak ada produk dalam kategori ini
                            @endif
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h3 class="mb-3">Tidak Menemukan yang Anda Cari?</h3>
        <p class="lead mb-4">Hubungi kami untuk kebutuhan khusus atau pertanyaan produk</p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="{{ config('constants.social_media.whatsapp') }}" class="btn btn-light btn-lg">
                <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
            </a>
            <!-- <a href="tel:{{ config('constants.contact.phone') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-telephone me-2"></i>Telepon Kami
            </a> -->
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    
    /* Seluruh card bisa diklik ke halaman detail; tombol tetap di atas */
    .product-card-link {
        z-index: 1;
    }
    
    .product-card-actions-wrap {
        z-index: 2;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .list-group-item.active {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
    }
    
    /* Tombol: ikon dan teks selalu satu baris (kiri-kanan) */
    .product-card-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        white-space: nowrap;
        gap: 0.35rem;
    }
    
    .product-card-actions .btn .product-card-btn-icon {
        flex-shrink: 0;
    }
    
    /* Mobile optimizations */
    @media (max-width: 991.98px) {
        #filterSidebar {
            margin-bottom: 1.5rem;
        }
        
        .product-card {
            margin-bottom: 1rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between > .dropdown {
            width: 100%;
        }
        
        .d-flex.justify-content-between > .dropdown > button {
            width: 100%;
        }
    }
    
    @media (max-width: 767.98px) {
        .display-5 {
            font-size: 2rem;
        }
        
        .lead {
            font-size: 1rem;
        }
    }
    
    /* Mobile: 2 kolom, card lebih kecil */
    @media (max-width: 767.98px) {
        .product-grid-row {
            gap: 0.5rem;
            display: flex;
            flex-wrap: wrap;
        }
        
        .product-grid-row > [class*="col-"] {
            flex: 0 0 calc(50% - 0.25rem) !important;
            max-width: calc(50% - 0.25rem) !important;
        }
        
        .product-card {
            font-size: 0.7rem;
        }
        
        .product-card-img-wrap {
            overflow: hidden;
        }
        
        .product-card-img {
            height: 140px;
            object-fit: cover;
        }
        
        .product-card-badge .badge {
            font-size: 0.55rem;
            padding: 0.15em 0.35em;
        }
        
        .product-card-body {
            padding: 0.35rem 0.5rem;
        }
        
        .product-card-title {
            font-size: 0.7rem;
            line-height: 1.15;
            margin-bottom: 0.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-card-desc {
            display: none;
        }
        
        .product-card-details {
            margin-bottom: 0.1rem !important;
        }
        
        .product-card-body .mt-auto {
            margin-top: 0.25rem !important;
        }
        
        .product-card-price {
            font-size: 0.65rem;
            font-weight: 600;
        }
        
        .product-card-weight {
            font-size: 0.6rem;
        }
        
        .product-card-actions .btn {
            padding: 0.2rem 0.3rem;
            font-size: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .product-card-btn-text {
            display: none;
        }
        
        .product-card-actions .btn .product-card-btn-icon {
            margin: 0 !important;
            font-size: 0.8rem;
        }
    }
    
    /* Tablet ke atas: tampilan normal */
    @media (min-width: 768px) {
        .product-card-img {
            height: 200px;
            object-fit: cover;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Product data now comes from database via Blade

    // Add to cart function
    function addToCart(productId, productName, productPrice, productDescription) {
        alert(`Ditambahkan ke keranjang!\n${productName}\nRp ${productPrice.toLocaleString('id-ID')}`);
        
        // Add to localStorage with proper structure
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push({ 
            id: productId, 
            name: productName,
            price: productPrice,
            description: productDescription,
            quantity: 1 
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Trigger cart update
        window.dispatchEvent(new Event('cart-updated'));
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush