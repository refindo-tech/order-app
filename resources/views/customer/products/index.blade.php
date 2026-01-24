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
                <div class="card">
                    <div class="card-header bg-primary text-white">
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
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sort-down me-1"></i>Urutkan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Nama A-Z</a></li>
                            <li><a class="dropdown-item" href="#">Harga Terendah</a></li>
                            <li><a class="dropdown-item" href="#">Harga Tertinggi</a></li>
                        </ul>
                    </div>
                </div>

                @if($products->isNotEmpty())
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 product-card">
                                    <!-- Product Image -->
                                    <div class="position-relative">
                                        <img src="{{ $product['image'] }}" 
                                             class="card-img-top" 
                                             alt="{{ $product['name'] }}"
                                             style="height: 200px; object-fit: cover;">
                                        
                                        @if($product['stock'] < 10)
                                            <span class="position-absolute top-0 end-0 badge bg-warning m-2">
                                                Stok Terbatas
                                            </span>
                                        @endif
                                        
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-primary">{{ $product['category'] }}</span>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product['name'] }}</h5>
                                        <p class="card-text text-muted flex-grow-1">
                                            {{ \Str::limit($product['description'], 80) }}
                                        </p>
                                        
                                        <!-- Product Details -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="h5 text-primary mb-0">
                                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                                </span>
                                                <small class="text-muted">{{ $product['weight'] }}g</small>
                                            </div>
                                            
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bi bi-box me-1"></i>
                                                <span>Stok: {{ $product['stock'] }}</span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-auto">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('products.show', $product['slug']) }}" 
                                                   class="btn btn-outline-primary flex-grow-1">
                                                    <i class="bi bi-eye me-1"></i>Detail
                                                </a>
                                                <button class="btn btn-primary flex-grow-1" 
                                                        onclick="addToCart({{ $product['id'] }})">
                                                    <i class="bi bi-cart-plus me-1"></i>Keranjang
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
            <a href="tel:{{ config('constants.contact.phone') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-telephone me-2"></i>Telepon Kami
            </a>
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
</style>
@endpush

@push('scripts')
<script>
    // Product data for demo (akan diganti dengan database di Phase 3)
    const productData = {
        1: { name: 'Bumbu Rendang Padang', price: 25000, description: 'Bumbu rendang khas Padang dengan rasa autentik' },
        2: { name: 'Bumbu Gulai Ayam', price: 20000, description: 'Bumbu gulai dengan santan gurih untuk ayam' },
        3: { name: 'Bumbu Opor Lebaran', price: 18000, description: 'Bumbu opor spesial untuk masakan lebaran' },
        4: { name: 'Bumbu Rawon Jawa Timur', price: 22000, description: 'Bumbu rawon asli Jawa Timur dengan kluwek pilihan' },
        5: { name: 'Ungkep Ayam Kampung', price: 85000, description: 'Ayam kampung ungkep siap masak bumbu meresap' },
        6: { name: 'Ungkep Bebek Rica', price: 95000, description: 'Bebek ungkep bumbu rica-rica pedas dan gurih' }
    };

    // Add to cart function (temporary)
    function addToCart(productId) {
        const product = productData[productId] || { 
            name: `Produk ${productId}`, 
            price: 20000, 
            description: 'Produk berkualitas premium'
        };
        
        // For now, just show alert
        alert(`Ditambahkan ke keranjang!\n${product.name}\nRp ${product.price.toLocaleString('id-ID')}`);
        
        // Add to localStorage with proper structure including description
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push({ 
            id: productId, 
            name: product.name,
            price: product.price,
            description: product.description,
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