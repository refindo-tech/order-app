@extends('customer.layouts.app')

@section('title', 'Tentang Kami')
@section('description', 'Visi dan Misi Rumah Bumbu dan Ungkep - Produk bumbu dan ungkep berkualitas dengan cita rasa khas dan autentik.')

@section('content')
<!-- Hero Section Tentang Kami -->
<section class="tentang-hero py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="tentang-hero__logo mb-4">
                    <img src="{{ asset('images/rumah-bumbu-ungkep.png') }}" alt="{{ config('app.name') }}" class="img-fluid" style="max-height: 220px; width: auto;">
                </div>
                <h1 class="display-5 fw-bold text-dark mb-2">Tentang Kami</h1>
                <p class="lead text-muted mb-0">{{ config('constants.company.full_name') }}</p>
                <p class="text-muted mb-0">
                    Berdiri sejak tahun {{ config('constants.company.founded_year') }}, kami berkomitmen menghadirkan produk bumbu dan ungkep 
                    berkualitas untuk keluarga dan pelaku usaha kuliner. Berikut visi dan misi yang menjadi fondasi perjalanan kami.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Visi & Misi</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm visi-misi-card">
                    <div class="card-body p-4 d-flex">
                        <div class="visi-misi-icon flex-shrink-0 me-3">
                            <span class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-star-fill"></i></span>
                        </div>
                        <div>
                            <h5 class="card-title text-primary mb-2">Cita Rasa Khas & Konsisten</h5>
                            <p class="card-text text-muted mb-0">Menghadirkan produk bumbu dan ungkep berkualitas dengan cita rasa khas, autentik, dan konsisten di setiap masakan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm visi-misi-card">
                    <div class="card-body p-4 d-flex">
                        <div class="visi-misi-icon flex-shrink-0 me-3 visi-misi-icon--success">
                            <span class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-heart-fill"></i></span>
                        </div>
                        <div>
                            <h5 class="card-title text-success mb-2">Solusi untuk Ibu Rumah Tangga</h5>
                            <p class="card-text text-muted mb-0">Membantu para ibu memasak lebih mudah, cepat, dan hemat tanpa mengurangi kelezatan dan nilai gizi makanan keluarga.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm visi-misi-card">
                    <div class="card-body p-4 d-flex">
                        <div class="visi-misi-icon flex-shrink-0 me-3 visi-misi-icon--warning">
                            <span class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-shop-window"></i></span>
                        </div>
                        <div>
                            <h5 class="card-title text-warning mb-2">Solusi untuk UMKM Kuliner</h5>
                            <p class="card-text text-muted mb-0">Menjadi solusi praktis bagi UMKM kuliner dengan menyediakan produk siap pakai yang efisien, terjangkau, dan menguntungkan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm visi-misi-card">
                    <div class="card-body p-4 d-flex">
                        <div class="visi-misi-icon flex-shrink-0 me-3 visi-misi-icon--info">
                            <span class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-shield-check"></i></span>
                        </div>
                        <div>
                            <h5 class="card-title text-info mb-2">Kualitas & Kehalalan</h5>
                            <p class="card-text text-muted mb-0">Mengutamakan kualitas bahan, kebersihan, dan kehalalan produk demi keamanan dan kenyamanan konsumen.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm visi-misi-card">
                    <div class="card-body p-4 d-flex">
                        <div class="visi-misi-icon flex-shrink-0 me-3 visi-misi-icon--purple">
                            <span class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-globe2"></i></span>
                        </div>
                        <div>
                            <h5 class="card-title text-purple mb-2">Dampak Positif untuk Masyarakat</h5>
                            <p class="card-text text-muted mb-0">Membangun usaha yang bermanfaat dan berdampak positif, membuka peluang ekonomi, serta menebar kebaikan bagi masyarakat luas.</p>
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
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h3 class="section-title mb-3">Tertarik dengan Produk Kami?</h3>
                <p class="text-muted mb-4">Jelajahi koleksi bumbu dan ungkep berkualitas atau hubungi kami untuk informasi lebih lanjut.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-grid me-2"></i>Lihat Produk
                    </a>
                    <a href="{{ route('home') }}#kontak" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .tentang-hero {
        background: linear-gradient(180deg, rgba(220, 53, 69, 0.06) 0%, transparent 100%);
        margin-top: -100px;
        padding-top: 140px !important;
    }
    .tentang-hero__logo img {
        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.08));
    }
    .visi-misi-card {
        border-radius: 16px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .visi-misi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12) !important;
    }
    .visi-misi-card .card-title.text-primary { color: var(--primary-color) !important; }
    .visi-misi-icon span {
        width: 52px;
        height: 52px;
        font-size: 1.35rem;
        background: rgba(220, 53, 69, 0.12);
        color: var(--primary-color);
    }
    .visi-misi-icon--success span {
        background: rgba(25, 135, 84, 0.12);
        color: var(--success-color);
    }
    .visi-misi-icon--warning span {
        background: rgba(253, 126, 20, 0.12);
        color: var(--warning-color);
    }
    .visi-misi-icon--info span {
        background: rgba(13, 202, 240, 0.12);
        color: var(--info-color);
    }
    .visi-misi-icon--purple span {
        background: rgba(111, 66, 193, 0.15);
        color: #6f42c1;
    }
    .visi-misi-card .card-title.text-purple { color: #6f42c1 !important; }
</style>
@endpush
@endsection
