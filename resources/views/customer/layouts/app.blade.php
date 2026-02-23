<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', config('constants.company.full_name') . ' - ' . config('constants.company.tagline'))">
    @hasSection('og')
        @yield('og')
    @else
        <meta property="og:title" content="@yield('title', 'Beranda') - {{ config('app.name') }}">
        <meta property="og:description" content="@yield('description', config('constants.company.full_name') . ' - ' . config('constants.company.tagline'))">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset(config('constants.company.logo', 'images/rumah-bumbu-ungkep.png')) }}">
    @endif
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#dc3545">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Rumah Bumbu">
    <link rel="apple-touch-icon" href="{{ asset('images/rumah-bumbu-ungkep.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #fd7e14;
            --info-color: #0dcaf0;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }
        
        body {
            line-height: 1.6;
            color: #333;
        }
        
        .navbar-brand {
            font-weight: 400;
            font-size: 1.5rem;
            color: var(--dark-color);
        }
        
        .navbar-nav .nav-item {
            margin-right: 0.75rem;
        }
        
        .navbar-nav .nav-item:last-child {
            margin-right: 0;
        }
        
        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 1rem;
            }
            .navbar-nav .nav-item {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #b02a2a;
            border-color: #b02a2a;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            color: white;
            margin-top: -100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 76px;
            padding-bottom: 76px;
        }
        .hero-section__video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .hero-section__overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-section__content {
            position: relative;
            z-index: 2;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-radius: 15px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            z-index: 1030;
        }
        
        .footer {
            background-color: #212529;
            color: white;
            padding: 50px 0 20px 0;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p {
                font-size: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('/images/rumah-bumbu-ungkep.png') }}" alt="" width="auto" height="60" class="me-2">
                {{ config('app.name') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-grid me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                            <i class="bi bi-journal-text me-1"></i>Artikel
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('tentang.*') ? 'active' : '' }}" href="{{ route('tentang.index') }}">
                            <i class="bi bi-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('home') }}#kontak">
                            <i class="bi bi-telephone me-1"></i>Kontak
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.index') }}">
                            <i class="bi bi-search me-1"></i>Cek Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 me-1"></i>Keranjang
                            <span class="cart-badge d-none" id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast: PWA install success (hidden by default) -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3 pb-5">
        <div id="pwa-install-success-toast" class="toast align-items-center border-0 bg-success text-white" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>Aplikasi berhasil dipasang. Anda bisa membukanya dari layar utama.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="text-center">
                        @if(file_exists(public_path(config('constants.company.logo', 'images/rumah-bumbu-ungkep.png'))))
                            <a href="{{ route('home') }}" class="d-inline-block">
                                <img src="{{ asset(config('constants.company.logo', 'images/rumah-bumbu-ungkep.png')) }}" 
                                     alt="{{ config('constants.company.full_name') }}" 
                                     class="img-fluid" 
                                     style="width: 75%;">
                            </a>
                        @else
                            <h5 class="text-primary mb-0">
                                <i class="bi bi-shop me-2"></i>{{ config('constants.company.full_name') }}
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="mb-3">Tentang Kami</h6>
                    <p class="text-white-50">{{ config('constants.company.description') }}</p>
                    <div class="d-flex gap-3">
                        <a href="{{ config('constants.social_media.facebook') }}" target="_blank" rel="noopener" class="text-light" aria-label="Shopee">
                            <i class="bi bi-bag fs-5"></i>
                        </a>
                        <a href="{{ config('constants.social_media.instagram') }}" target="_blank" rel="noopener" class="text-light" aria-label="Instagram">
                            <i class="bi bi-instagram fs-5"></i></a>
                        <a href="{{ config('constants.social_media.whatsapp') }}" target="_blank" rel="noopener" class="text-light" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp fs-5"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            {{ config('constants.contact.address.street') }}, {{ config('constants.contact.address.city') }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            {{ config('constants.contact.phone') }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            {{ config('constants.contact.email') }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-clock me-2"></i>
                            {{ config('constants.contact.business_hours') }}
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-12 mb-4">
                    <h6 class="mb-3">Pengiriman</h6>
                    <p>Kami bekerja sama dengan Paxel untuk pengiriman yang cepat dan aman.</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck fs-4 text-danger me-2"></i>
                        <span>Paxel Delivery</span>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <button type="button" id="pwa-install-btn" class="btn btn-outline-light btn-sm" aria-label="Pasang aplikasi">
                        <i class="bi bi-phone me-1"></i>Pasang ke Layar Utama
                    </button>
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Portal Admin
                    </a>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Cart Management -->
    <script>
        // Simple cart count management (consolidate duplicates)
        function updateCartCount() {
            const rawCart = JSON.parse(localStorage.getItem('cart') || '[]');
            const uniqueItems = {};
            
            // Consolidate duplicate IDs
            rawCart.forEach(item => {
                if (uniqueItems[item.id]) {
                    uniqueItems[item.id].quantity += (item.quantity || 1);
                } else {
                    uniqueItems[item.id] = {
                        id: item.id,
                        quantity: item.quantity || 1
                    };
                }
            });
            
            const totalItems = Object.values(uniqueItems).reduce((sum, item) => sum + item.quantity, 0);
            const cartBadge = document.getElementById('cart-count');
            
            if (totalItems > 0) {
                cartBadge.textContent = totalItems;
                cartBadge.classList.remove('d-none');
            } else {
                cartBadge.classList.add('d-none');
            }
        }
        
        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', updateCartCount);
        
        // Listen for cart updates
        window.addEventListener('storage', updateCartCount);
        window.addEventListener('cart-updated', updateCartCount);
    </script>
    
    <!-- PWA: Install / Add to Home Screen button -->
    <script>
        (function() {
            var installBtn = document.getElementById('pwa-install-btn');
            if (!installBtn) return;
            var standalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            if (standalone) {
                installBtn.classList.add('d-none');
                return;
            }
            var deferredPrompt;
            window.addEventListener('beforeinstallprompt', function(e) {
                e.preventDefault();
                deferredPrompt = e;
            });
            installBtn.addEventListener('click', function() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(function() { deferredPrompt = null; });
                } else {
                    alert('Untuk menambah ke layar utama: buka menu Bagikan (↑) lalu pilih "Tambahkan ke Layar Utama".');
                }
            });
            window.addEventListener('appinstalled', function() {
                deferredPrompt = null;
                var toastEl = document.getElementById('pwa-install-success-toast');
                if (toastEl && typeof bootstrap !== 'undefined') {
                    var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
                    toast.show();
                } else {
                    alert('Aplikasi berhasil dipasang. Anda bisa membukanya dari layar utama.');
                }
            });
        })();
    </script>
    
    <!-- PWA: Register Service Worker (HTTPS or localhost only) -->
    <script>
        if ('serviceWorker' in navigator && (location.protocol === 'https:' || location.hostname === 'localhost')) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('{{ asset('sw.js') }}', { scope: '/' })
                    .then(function(reg) { console.log('PWA: Service Worker registered', reg.scope); })
                    .catch(function(err) { console.warn('PWA: Service Worker registration failed', err); });
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>