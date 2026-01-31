<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', config('constants.company.full_name') . ' - ' . config('constants.company.tagline'))">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Klee+One:wght@300;400;600&display=swap" rel="stylesheet">
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
            margin-top: -80px;
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
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shop me-2"></i>{{ config('app.name') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-grid me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">
                            <i class="bi bi-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">
                            <i class="bi bi-telephone me-1"></i>Kontak
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-shop me-2"></i>{{ config('app.name') }}
                    </h5>
                    <p>{{ config('constants.company.description') }}</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-whatsapp fs-5"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-light text-decoration-none">Produk</a></li>
                        <li class="mb-2"><a href="#tentang" class="text-light text-decoration-none">Tentang</a></li>
                        <li class="mb-2"><a href="#kontak" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            {{ config('constants.contact.address.city') }}, {{ config('constants.contact.address.country') }}
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
                    <p>Kami bekerja sama dengan Paxel untuk pengiriman yang cepat dan aman ke seluruh Indonesia.</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck fs-4 text-primary me-2"></i>
                        <span>Powered by Paxel</span>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Built with <i class="bi bi-heart-fill text-danger"></i> using Laravel & Bootstrap
                    </small>
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
    
    @stack('scripts')
</body>
</html>