@extends('customer.layouts.app')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-lg-start mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-4">
                    Rumah Bumbu & Ungkep
                    <span class="d-block text-warning">Berkualitas Tinggi</span>
                </h1>
                <p class="lead mb-4">
                    Supplier terpercaya untuk kebutuhan bumbu dapur dan ungkep berkualitas. 
                    Melayani pengiriman ke seluruh Indonesia dengan jaminan kualitas terbaik.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-grid me-2"></i>Lihat Produk
                    </a>
                    <a href="#kontak" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 400' fill='none'%3E%3Crect width='600' height='400' fill='%23ffffff' fill-opacity='0.1' rx='20'/%3E%3Cpath d='M150 200c0-55.228 44.772-100 100-100s100 44.772 100 100-44.772 100-100 100-100-44.772-100-100z' fill='%23ffffff' fill-opacity='0.2'/%3E%3Cpath d='M200 150h100v100H200z' fill='%23ffffff' fill-opacity='0.3'/%3E%3Ctext x='300' y='210' text-anchor='middle' fill='%23ffffff' font-family='Arial' font-size='24' font-weight='bold'%3EBumbu%3C/text%3E%3Ctext x='300' y='240' text-anchor='middle' fill='%23ffffff' font-family='Arial' font-size='24' font-weight='bold'%3E%26 Ungkep%3C/text%3E%3C/svg%3E" 
                         alt="Rumah Bumbu & Ungkep" 
                         class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Mengapa Memilih Kami?</h2>
                <p class="section-subtitle">
                    Kami berkomitmen memberikan produk berkualitas tinggi dengan pelayanan terbaik
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Kualitas Terjamin</h5>
                        <p class="card-text">Produk bumbu dan ungkep dengan kualitas premium yang telah terpercaya</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-truck text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Pengiriman Cepat</h5>
                        <p class="card-text">Bekerja sama dengan Paxel untuk pengiriman yang cepat dan aman</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-headset text-info" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Pelayanan 24/7</h5>
                        <p class="card-text">Tim customer service siap membantu Anda kapan saja</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-geo-alt text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">Jangkauan Luas</h5>
                        <p class="card-text">Melayani pengiriman ke seluruh Indonesia dengan coverage yang luas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
<section class="py-5 bg-light" id="tentang">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 500 350' fill='none'%3E%3Crect width='500' height='350' fill='%23f8f9fa' rx='15'/%3E%3Crect x='50' y='50' width='400' height='250' fill='%23e9ecef' rx='10'/%3E%3Ccircle cx='150' cy='150' r='50' fill='%23dc3545' fill-opacity='0.8'/%3E%3Crect x='220' y='120' width='180' height='60' fill='%23fd7e14' fill-opacity='0.8' rx='5'/%3E%3Ctext x='250' y='225' fill='%23495057' font-family='Arial' font-size='16' font-weight='bold'%3ERumah Bumbu%3C/text%3E%3Ctext x='250' y='250' fill='%23495057' font-family='Arial' font-size='14'%3ESejak 2020%3C/text%3E%3C/svg%3E" 
                     alt="Tentang Rumah Bumbu & Ungkep" 
                     class="img-fluid rounded shadow">
            </div>
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
        
        <div class="row g-4">
            <!-- Featured products from database -->
            @forelse($featuredProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200' fill='none'%3E%3Crect width='300' height='200' fill='%23f8f9fa'/%3E%3Crect x='50' y='50' width='200' height='100' fill='%23dc3545' fill-opacity='0.2' rx='10'/%3E%3Ctext x='150' y='105' text-anchor='middle' fill='%23dc3545' font-family='Arial' font-size='14' font-weight='bold'%3E{{ \Str::limit($product->name, 20) }}%3C/text%3E%3C/svg%3E" 
                         class="card-img-top" 
                         alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ \Str::limit($product->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <small class="text-muted">Per pack</small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </a>
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

<!-- Kontak Section -->
<section class="py-5 bg-primary text-white" id="kontak">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle text-white-50">
                    Tim kami siap membantu Anda dengan pelayanan terbaik
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-geo-alt" style="font-size: 2rem;"></i>
                </div>
                <h5>Alamat</h5>
                <p class="mb-0">{{ config('constants.contact.address.street') }}<br>{{ config('constants.contact.address.country') }}</p>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-telephone" style="font-size: 2rem;"></i>
                </div>
                <h5>Telepon</h5>
                <p class="mb-0">{{ config('constants.contact.phone') }}</p>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-whatsapp" style="font-size: 2rem;"></i>
                </div>
                <h5>WhatsApp</h5>
                <p class="mb-0">
                    <a href="{{ config('constants.social_media.whatsapp') }}" class="text-white text-decoration-none">
                        {{ config('constants.contact.phone') }}
                    </a>
                </p>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-clock" style="font-size: 2rem;"></i>
                </div>
                <h5>Jam Operasional</h5>
                <p class="mb-0">{{ config('constants.contact.business_hours') }}</p>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto text-center">
                <div class="card bg-white bg-opacity-10 border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Siap Berbelanja?</h4>
                        <p class="mb-4">Jelajahi koleksi lengkap produk bumbu dan ungkep berkualitas kami</p>
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
<section class="py-5 bg-light">
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
</section>
@endsection

@push('scripts')
<script>
    // Smooth scrolling for anchor links
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
    
    // Note: Add to cart functionality will be handled in product detail page
</script>
@endpush