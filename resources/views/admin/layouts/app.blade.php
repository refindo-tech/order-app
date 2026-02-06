<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Klee+One:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        #loader {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000;
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
            animation: sk-scaleout 1.0s infinite ease-in-out;
        }

        @-webkit-keyframes sk-scaleout {
            0% { -webkit-transform: scale(0) }
            100% {
                -webkit-transform: scale(1.0);
                opacity: 0;
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0);
            } 
            100% {
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
                opacity: 0;
            }
        }
    </style>
    
    <script defer="defer" src="{{ asset('adminator/main.js') }}"></script>
    @stack('styles')
    <style>
        /* Custom dropdown behavior - allow multiple dropdowns open */
        /* Force dropdown menus to be visible when parent has 'open' class */
        .sidebar-menu .nav-item.dropdown.open .dropdown-menu,
        .sidebar-menu .nav-item.dropdown.open > ul.dropdown-menu,
        ul.sidebar-menu .nav-item.dropdown.open ul.dropdown-menu {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
        }
        
        /* Default: show dropdown menus for items with 'open' class */
        .sidebar-menu .nav-item.dropdown.open ul.dropdown-menu {
            display: block !important;
        }
        
        /* Arrow rotation for open state */
        .sidebar-menu .nav-item.dropdown.open .arrow i {
            transform: rotate(90deg);
        }
        .sidebar-menu .nav-item.dropdown .arrow i {
            transition: transform 0.3s ease;
        }
        
        /* Hide dropdown menus that don't have 'open' class */
        .sidebar-menu .nav-item.dropdown:not(.open) .dropdown-menu {
            display: none !important;
        }
    </style>
</head>
<body class="app">
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <script>
        window.addEventListener('load', function load() {
            const loader = document.getElementById('loader');
            setTimeout(function() {
                loader.classList.add('fadeOut');
            }, 300);
        });
    </script>

    <div>
        <!-- #Left Sidebar ==================== -->
        <div class="sidebar">
            <div class="sidebar-inner">
                <!-- ### $Sidebar Header ### -->
                <div class="sidebar-logo">
                    <div class="peers ai-c fxw-nw">
                        <div class="peer peer-greed">
                            <a class="sidebar-link td-n" href="{{ route('admin.dashboard') }}">
                                <div class="peers ai-c fxw-nw">
                                    <div class="peer">
                                        <div class="logo">
                                            <img src="{{ asset('adminator/assets/static/images/logo.svg') }}" alt="{{ config('app.name') }}" style="max-width: 32px;">
                                        </div>
                                    </div>
                                    <div class="peer peer-greed">
                                        <h5 class="lh-1 mB-0 logo-text">{{ config('app.name') }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="peer">
                            <div class="mobile-toggle sidebar-toggle">
                                <a href="#" class="td-n">
                                    <i class="ti-arrow-circle-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ### $Sidebar Menu ### -->
                <ul class="sidebar-menu scrollable pos-r">
                    <li class="nav-item mT-30 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <span class="icon-holder">
                                <i class="c-blue-500 ti-home"></i>
                            </span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown {{ request()->routeIs('admin.products.*') ? 'active open' : 'open' }}">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                            <span class="icon-holder">
                                <i class="c-orange-500 ti-package"></i>
                            </span>
                            <span class="title">Produk</span>
                            <span class="arrow">
                                <i class="ti-angle-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" style="display: block !important; visibility: visible !important;">
                            <li><a class="sidebar-link" href="{{ route('admin.products.index') }}">Daftar Produk</a></li>
                            <li><a class="sidebar-link" href="{{ route('admin.products.create') }}">Tambah Produk</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('admin.orders.*') ? 'active open' : 'open' }}">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                            <span class="icon-holder">
                                <i class="c-teal-500 ti-shopping-cart"></i>
                            </span>
                            <span class="title">Pesanan</span>
                            <span class="arrow">
                                <i class="ti-angle-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" style="display: block !important; visibility: visible !important;">
                            <li><a class="sidebar-link" href="{{ route('admin.orders.index') }}">Daftar Pesanan</a></li>
                            <li><a class="sidebar-link" href="{{ route('admin.orders.index', ['status' => 'payment_verification']) }}">Verifikasi Pembayaran</a></li>
                        </ul>
                    </li>
                    <!-- 
                    <li class="nav-item">
                        <a class="sidebar-link" href="#">
                            <span class="icon-holder">
                                <i class="c-purple-500 ti-truck"></i>
                            </span>
                            <span class="title">Pengiriman</span>
                        </a>
                    </li> -->

                    <!-- <li class="nav-item">
                        <a class="sidebar-link" href="#">
                            <span class="icon-holder">
                                <i class="c-green-500 ti-comment-alt"></i>
                            </span>
                            <span class="title">WhatsApp</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="sidebar-link" href="#">
                            <span class="icon-holder">
                                <i class="c-brown-500 ti-settings"></i>
                            </span>
                            <span class="title">Pengaturan</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>

        <!-- #Main ============================ -->
        <div class="page-container">
            <!-- ### $Topbar ### -->
            <div class="header navbar">
                <div class="header-container">
                    <ul class="nav-left">
                        <li>
                            <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                        <li class="search-box">
                            <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                                <i class="search-icon ti-search pdd-right-10"></i>
                                <i class="search-icon-close pdd-right-10 ti-close"></i>
                            </a>
                        </li>
                        <li class="search-input">
                            <input class="form-control" type="text" placeholder="Search...">
                        </li>
                    </ul>
                    
                    <ul class="nav-right">
                        <!-- <li class="notifications dropdown">
                            <span class="counter bgc-red">3</span>
                            <a href="" class="dropdown-toggle no-after" data-bs-toggle="dropdown">
                                <i class="ti-bell"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="pX-20 pY-15 bdB">
                                    <i class="ti-bell pR-10"></i>
                                    <span class="fsz-sm fw-600 c-grey-900">Notifikasi</span>
                                </li>
                                <li>
                                    <a href="#" class="td-n pY-15 pX-20 fsz-sm c-grey-700">
                                        <span class="fw-500">Pesanan baru masuk</span>
                                        <br>
                                        <small class="c-grey-500">2 menit yang lalu</small>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-bs-toggle="dropdown">
                                <div class="peer mR-10">
                                    <div class="bgc-light-green-500 c-white bdrs-50p p-15">
                                        <i class="ti-user"></i>
                                    </div>
                                </div>
                                <div class="peer">
                                    <span class="fsz-sm c-grey-900">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu fsz-sm">
                                <!-- <li>
                                    <a href="#" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-user mR-10"></i>
                                        <span>Profil</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                        <i class="ti-settings mR-10"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                </li>
                                <li role="separator" class="divider mY-0"></li> -->
                                <li>
                                    <a href="#" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti-power-off mR-10"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ### $App Screen Content ### -->
            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    @yield('content')
                </div>
            </main>

            <!-- ### $App Screen Footer ### -->
            <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. 
                <!-- <span class="hidden-xs-down">Powered by 
                    <a href="https://laravel.com" target="_blank" title="Laravel">Laravel</a> & 
                    <a href="https://github.com/puikinsh/Adminator-admin-dashboard" target="_blank" title="Adminator">Adminator</a>
                </span> -->
            </footer>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    @stack('scripts')
    <script>
        // Custom dropdown toggle - allow multiple dropdowns open simultaneously
        function showOpenDropdowns() {
            document.querySelectorAll('.sidebar-menu .nav-item.dropdown.open .dropdown-menu').forEach(function(menu) {
                menu.style.setProperty('display', 'block', 'important');
                menu.style.setProperty('visibility', 'visible', 'important');
                menu.style.setProperty('opacity', '1', 'important');
            });
        }
        
        function initCustomDropdowns() {
            showOpenDropdowns();
            
            const dropdownToggles = document.querySelectorAll('.sidebar-menu .dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                if (!toggle.dataset.customHandler) {
                    toggle.dataset.customHandler = 'true';
                    
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        
                        const dropdown = this.closest('.nav-item.dropdown');
                        const menu = dropdown.querySelector('.dropdown-menu');
                        const arrow = dropdown.querySelector('.arrow i');
                        
                        if (dropdown.classList.contains('open')) {
                            dropdown.classList.remove('open');
                            menu.style.setProperty('display', 'none', 'important');
                            arrow.classList.remove('ti-angle-down');
                            arrow.classList.add('ti-angle-right');
                        } else {
                            dropdown.classList.add('open');
                            menu.style.setProperty('display', 'block', 'important');
                            menu.style.setProperty('visibility', 'visible', 'important');
                            arrow.classList.remove('ti-angle-right');
                            arrow.classList.add('ti-angle-down');
                        }
                    }, true);
                }
            });
        }
        
        // Show dropdowns immediately when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                showOpenDropdowns();
                initCustomDropdowns();
            });
        } else {
            showOpenDropdowns();
            initCustomDropdowns();
        }
        
        // Re-apply after load (Adminator may hide them)
        window.addEventListener('load', function() {
            showOpenDropdowns();
            initCustomDropdowns();
            // Run again after short delays to override Adminator
            [50, 150, 350, 600].forEach(function(delay) {
                setTimeout(showOpenDropdowns, delay);
            });
        });
        
        // Keep dropdowns visible (override Adminator if it hides them)
        setInterval(showOpenDropdowns, 400);
    </script>
</body>
</html>