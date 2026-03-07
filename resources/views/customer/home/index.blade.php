@extends('customer.layouts.app')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <video class="hero-section__video" autoplay muted loop playsinline aria-hidden="true">
        <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-section__overlay" aria-hidden="true"></div>
    <div class="container w-100 hero-section__content">
        <div class="row align-items-center">
            <div class="align-items-center text-lg-center mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold">
                <span id="hero-title" class="d-block text-warning" style="white-space: pre-line;">{{ $heroTitle }}</span>
            </h1>
                <p id="hero-description" class="lead mb-4" style="white-space: pre-line;">
                    {{ $heroDescription }}
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-lg-center justify-content-sm-center">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-grid me-2"></i>Lihat Produk
                    </a>
                    <a href="#kontak" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-2">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Kenapa Harus Rumah Bumbu?</h2>
                <p class="section-subtitle">
                    Keuntungan Melimpah, Jualan Mudah Tetap Happy walau di Rumah
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="background-color: #ffd3d1; width: 80px; height: 80px;">
                            <i class="bi bi-tag text-danger" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Harga yang Konsisten</h5>
                        <p class="card-text small">Rumah Bumbu & Ungkep berkomitmen untuk memberikan harga terbaik untuk para konsumen kami, ditengah harga bahan baku yang naik turun di pasaran, Rumah Bumbu & Ungkep memberikan komitmen harga yang stabil sehingga para UMKM tidak khawatir tentang harga Pokok Produk usaha yang di jalani.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-award text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Kualitas Produk Sesuai Standard</h5>
                        <p class="card-text small">Rumah Bumbu & Ungkep berkomitmen terhadap Rasa & Ukuran terhadap produk kami untuk menghindari cita rasa yang berubah-ubah. kami memiliki sistem & SOP yang tinggi untuk mempertahankan cita rasa dari produk kami.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Kami Terpercaya!</h5>
                        <p class="card-text small">Kami selalu berkomitmen untuk menjaga hubungan kepada partner-partner kami. Kami sudah bekerjasama dengan beberapa restoran yang sangat kami jaga kepercayaannya, segala bentuk saran&kritik kami selalu terima dan mengusahakan yang terbaik untuk konsumen kami.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-gift text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Bonus dan Point Reward</h5>
                        <p class="card-text small">Setiap transaksi yang dilakukan oleh konsumen kami, akan mendapatkan Point yang dapat ditukarkan menjadi cashback.</p>
                    </div>
                </div>
            </div>
            <!-- Partner Image -->
            <div class="row justify-content-center my-4">
                <div class="col-12 col-md-7">
                    <img src="{{ asset('images/partner.png') }}" alt="Partner Rumah Bumbu & Ungkep" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
<section class="py-5 bg-light" id="tentang">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Tentang Rumah Bumbu & Ungkep</h2>
                <p class="mb-4">
                    Berdiri sejak tahun {{ config('constants.company.founded_year') }}, {{ config('constants.company.full_name') }} telah menjadi supplier terpercaya 
                    untuk kebutuhan bumbu dapur dan ungkep berkualitas tinggi. Kami melayani berbagai 
                    kalangan mulai dari ibu rumah tangga hingga pelaku usaha kuliner.
                </p>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Bahan Berkualitas</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Harga Terjangkau</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Pengiriman Aman</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Stok Lengkap</span>
                        </div>
                    </div>
                </div>
                
                <p class="mb-4">
                    Dengan komitmen pada kualitas dan kepuasan pelanggan, kami terus berinovasi 
                    untuk memberikan pengalaman berbelanja yang mudah dan menyenangkan.
                </p>
                
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-right me-2"></i>Lihat Produk Kami
                </a>
            </div>
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('images/rumah-bumbu-ungkep.png') }}" alt="Rumah Bumbu & Ungkep" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Produk Unggulan Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Produk Unggulan</h2>
                <p class="section-subtitle">
                    Pilihan produk terbaik yang paling banyak diminati pelanggan kami
                </p>
            </div>
        </div>

        <div class="row g-2 g-md-4 product-grid-row">
            <!-- Featured products from database -->
            @forelse($featuredProducts as $product)
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card h-100 product-card position-relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card-link stretched-link" aria-label="Lihat detail {{ $product->name }}"></a>
                    <!-- Product Image -->
                    <div class="position-relative product-card-img-wrap">
                        <img src="{{ $product->image ? storage_url($product->image) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 250\' fill=\'none\'%3E%3Crect width=\'400\' height=\'250\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'200\' y=\'125\' text-anchor=\'middle\' fill=\'%23dc3545\' font-family=\'Arial\' font-size=\'16\'%3ENo Image%3C/text%3E%3C/svg%3E' }}"
                             class="card-img-top product-card-img"
                             alt="{{ $product->name }}">

                        <div class="position-absolute top-0 start-0 product-card-badge d-flex gap-1 flex-wrap">
                            <span class="badge bg-primary">{{ $product->category }}</span>
                            @if($product->vouchers && $product->vouchers->isNotEmpty())
                                <span class="badge bg-danger">Diskon</span>
                            @endif
                            @if(is_array($product->extra_categories) && count($product->extra_categories))
                                @foreach($product->extra_categories as $extraCategory)
                                    <span class="badge bg-success">{{ $extraCategory }}</span>
                                @endforeach
                            @endif
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
                            @if($product->hasGrosir())
                                <div class="mt-1 small text-success">
                                    Grosir: Rp {{ number_format($product->harga_grosir, 0, ',', '.') }} <span class="text-muted">(min. {{ $product->minimal_grosir }})</span>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto product-card-actions-wrap position-relative">
                            <div class="d-flex gap-1 gap-md-2 product-card-actions">
                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="btn btn-outline-primary btn-sm flex-grow-1 product-card-btn">
                                    <i class="bi bi-eye product-card-btn-icon me-2"></i><span class="product-card-btn-text">Detail</span>
                                </a>
                                @php
                                    $productImageUrl = ($product->primary_image ?? $product->image) ? storage_url($product->primary_image ?? $product->image) : '';
                                    $productVouchersJson = $product->vouchers ? $product->vouchers->map(fn($v) => ['id' => $v->id, 'name' => $v->name, 'discount_type' => $v->discount_type, 'discount_value' => (float)$v->discount_value])->values()->toJson() : '[]';
                                @endphp
                                <button type="button" class="btn btn-primary btn-sm flex-grow-1 product-card-btn"
                                        data-image-url="{{ $productImageUrl }}"
                                        data-vouchers="{{ e($productVouchersJson) }}"
                                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->description) }}', {{ $product->minimal_grosir ?? 'null' }}, {{ $product->harga_grosir ?? 'null' }}, this.getAttribute('data-image-url') || '', this.getAttribute('data-vouchers') || '[]')">
                                    <i class="bi bi-cart-plus product-card-btn-icon me-2"></i><span class="product-card-btn-text">Keranjang</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>Belum ada produk tersedia
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-arrow-right me-2"></i>Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Card Instruksi Pemesanan -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-3">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Cara Pemesanan</h2>
                <p class="section-subtitle">
                    Pesan dengan 3 langkah mudah, cepat, dan aman
                </p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
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

<!-- Artikel Kami Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Artikel Kami</h2>
                <p class="section-subtitle">
                    Dapatkan tips, inspirasi, dan informasi terbaru seputar bumbu dan ungkep
                </p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($homeArticles as $article)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        @if($article->thumbnail)
                            <a href="{{ route('articles.show', $article) }}">
                                <img src="{{ storage_url($article->thumbnail) }}"
                                     class="card-img-top"
                                     alt="{{ $article->title }}"
                                     style="height: 200px; object-fit: cover;">
                            </a>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-light text-muted border">
                                    {{ $article->publish_date?->format('d M Y') ?? '' }}
                                </span>
                                @if($article->category)
                                    <span class="badge bg-primary text-white">
                                        {{ $article->category }}
                                    </span>
                                @endif
                            </div>
                            <h5 class="card-title mb-2">
                                <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            @if($article->excerpt)
                                <p class="card-text text-muted mb-3" style="min-height: 60px;">
                                    {{ Str::limit($article->excerpt, 120) }}
                                </p>
                            @endif
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $article->author_name ?: 'Admin' }}
                                </small>
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    Baca <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>Belum ada artikel tersedia.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-journal-text me-2"></i>Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>

<!-- Kontak Section -->
<section class="py-5 bg-danger text-white" id="kontak">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle text-white-50">
                    Kami siap membantu Anda
                </p>
            </div>
        </div>
        
        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5">
            <div class="col text-center">
                <a href="{{ config('constants.social_media.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none d-block">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-whatsapp" style="font-size: 2rem;"></i>
                    </div>
                    <!-- <h5>WhatsApp</h5>
                    <p class="mb-0">{{ config('constants.contact.phone') }}</p> -->
                </a>
            </div>
            <div class="col text-center">
                <a href="https://maps.app.goo.gl/c6dDXWCGuvG74nu89" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none d-block">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-geo-alt" style="font-size: 2rem;"></i>
                    </div>
                    <!-- <h5>Alamat</h5>
                    <p class="mb-0">{{ config('constants.contact.address.street') }}, {{ config('constants.contact.address.city') }}</p> -->
                </a>
            </div>
            <div class="col text-center">
                <a href="https://www.instagram.com/rumahbumbu.ungkep/" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none d-block">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-instagram" style="font-size: 2rem;"></i>
                    </div>
                    <!-- <h5>Instagram</h5>
                    <p class="mb-0">@rumahbumbu.ungkep</p> -->
                </a>
            </div>
            <div class="col text-center">
                <a href="https://www.tiktok.com/@rumahbumbu.id" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none d-block">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-tiktok" style="font-size: 2rem;"></i>
                    </div>
                    <!-- <h5>TikTok</h5>
                    <p class="mb-0">@rumahbumbu.id</p> -->
                </a>
            </div>
            <div class="col text-center">
                <a href="{{ config('constants.social_media.facebook') }}" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none d-block">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-bag" style="font-size: 2rem;"></i>
                    </div>
                    <!-- <h5>Shopee</h5>
                    <p class="mb-0">Rumah Bumbu dan Ungkep</p> -->
                </a>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto text-center">
                <div class="card bg-white bg-opacity-10 border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-3 text-white">Siap Berbelanja?</h4>
                        <p class="mb-4 text-white">Jelajahi koleksi lengkap produk bumbu dan ungkep berkualitas kami</p>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-shop me-2"></i>Mulai Belanja
                            </a>
                            <a href="{{ config('constants.social_media.whatsapp') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<!-- <section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Dapatkan Penawaran Khusus!</h3>
                <p class="mb-0">Berlangganan newsletter kami untuk mendapatkan informasi produk terbaru dan promo menarik</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Masukkan email Anda">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section> -->
@endsection

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .product-card-link { z-index: 1; }
    .product-card-actions-wrap { z-index: 2; }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .product-card-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        white-space: nowrap;
        gap: 0.35rem;
    }
    .product-card-actions .btn .product-card-btn-icon { flex-shrink: 0; }
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
        .product-card { font-size: 0.7rem; }
        .product-card-img-wrap { overflow: hidden; }
        .product-card-img { height: 140px; object-fit: cover; }
        .product-card-badge .badge { font-size: 0.55rem; padding: 0.15em 0.35em; }
        .product-card-body { padding: 0.35rem 0.5rem; }
        .product-card-title {
            font-size: 0.7rem;
            line-height: 1.15;
            margin-bottom: 0.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card-desc { display: none; }
        .product-card-details { margin-bottom: 0.1rem !important; }
        .product-card-body .mt-auto { margin-top: 0.25rem !important; }
        .product-card-price { font-size: 0.65rem; font-weight: 600; }
        .product-card-weight { font-size: 0.6rem; }
        .product-card-actions .btn { padding: 0.2rem 0.3rem; font-size: 0.65rem; display: inline-flex; align-items: center; justify-content: center; }
        .product-card-btn-text { display: none; }
        .product-card-actions .btn .product-card-btn-icon { margin: 0 !important; font-size: 0.8rem; }
    }
    @media (min-width: 768px) {
        .product-card-img { height: 200px; object-fit: cover; }
    }
</style>
@endpush

@push('scripts')
<script>
    function addToCart(productId, productName, productPrice, productDescription, minimalGrosir, hargaGrosir, imageUrl, vouchersJson) {
        var vouchersAvailable = [];
        try { vouchersAvailable = typeof vouchersJson === 'string' ? JSON.parse(vouchersJson || '[]') : (vouchersJson || []); } catch (e) {}
        var cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            minimal_grosir: minimalGrosir ?? null,
            harga_grosir: hargaGrosir ?? null,
            description: productDescription,
            quantity: 1,
            image: imageUrl || '',
            vouchers_available: vouchersAvailable,
            vouchers_selected: []
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Ditambahkan ke keranjang!\n' + productName + '\nRp ' + productPrice.toLocaleString('id-ID'));
        if (typeof window.dispatchEvent === 'function') {
            window.dispatchEvent(new Event('cart-updated'));
        }
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target) {
                setTimeout(function() {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }
    });
</script>
@endpush