@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Dashboard Overview</h4>
                <p class="mB-0">Selamat datang di Admin Panel <strong>{{ config('app.name') }}</strong> - Rumah Bumbu & Ungkep</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row gap-20 masonry pos-r">
        <!-- Total Products -->
        <div class="masonry-sizer col-md-6 col-xl-3"></div>
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <div class="layers">
                            <div class="layer w-100">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">
                                            <i class="ti-package"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-15">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="fsz-xs fw-600 c-grey-800 tt-u ls-1">Total Produk</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-10">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib fw-600 fsz-lg c-grey-800">0</span>
                                        <small class="fsz-xs c-grey-500 ml-10">items</small>
                                    </div>
                                </div>
                                <span class="fsz-xs c-grey-500">Phase 3: Manajemen Produk</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <div class="layers">
                            <div class="layer w-100">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">
                                            <i class="ti-shopping-cart"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-15">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="fsz-xs fw-600 c-grey-800 tt-u ls-1">Total Pesanan</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-10">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib fw-600 fsz-lg c-grey-800">0</span>
                                        <small class="fsz-xs c-grey-500 ml-10">orders</small>
                                    </div>
                                </div>
                                <span class="fsz-xs c-grey-500">Phase 3: Manajemen Order</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paxel Integration -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <div class="layers">
                            <div class="layer w-100">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">
                                            <i class="ti-truck"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-15">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="fsz-xs fw-600 c-grey-800 tt-u ls-1">Integrasi Paxel</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-10">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib fw-600 fsz-lg c-orange-500">Pending</span>
                                    </div>
                                </div>
                                <span class="fsz-xs c-grey-500">Phase 4: API Integration</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- WhatsApp Notifications -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <div class="layers">
                            <div class="layer w-100">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">
                                            <i class="ti-comment-alt"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-15">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="fsz-xs fw-600 c-grey-800 tt-u ls-1">WhatsApp</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 mT-10">
                                <div class="peers fxw-nw ai-c">
                                    <div class="peer peer-greed">
                                        <span class="d-ib fw-600 fsz-lg c-orange-500">Setup</span>
                                    </div>
                                </div>
                                <span class="fsz-xs c-grey-500">Phase 5: Notifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="row mT-30">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="peers fxw-nw ai-c">
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500 fsz-lg">
                                    🎉
                                </span>
                            </div>
                            <div class="peer peer-greed pL-20">
                                <h5 class="mB-5">Setup Authentication Berhasil!</h5>
                                <p class="mB-0 c-grey-600">Selamat datang di Admin Panel Order App dengan tampilan Adminator yang modern.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Development Progress -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <h4 class="c-grey-900 mB-20">📊 Progress Development</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-green-500"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-800">Phase 1: Project Setup & Foundation</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-green-500" role="progressbar" style="width: 100%"></div>
                                </div>
                                <small class="c-green-600">✅ Complete - Auth, Security, Adminator UI</small>
                            </div>
                        </div>
                        
                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-orange-500"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-800">Phase 2: UI/UX & Frontend Core</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-orange-500" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="c-orange-600">⏳ Next - Landing, Katalog, Checkout</small>
                            </div>
                        </div>

                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-grey-300"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-600">Phase 3: Backend Core & Order Management</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-grey-300" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="c-grey-500">⏳ Pending - Produk, Order, Pembayaran</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-grey-300"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-600">Phase 4: Integrasi Paxel API</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-grey-300" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="c-grey-500">⏳ Pending - Ongkir, Order, Tracking</small>
                            </div>
                        </div>

                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-grey-300"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-600">Phase 5: Notifikasi WhatsApp & Tracking</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-grey-300" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="c-grey-500">⏳ Pending - WhatsApp Gateway</small>
                            </div>
                        </div>

                        <div class="peers fxw-nw ai-c mB-20">
                            <div class="peer mR-15">
                                <span class="d-ib w-2 h-2 bdrs-50p bgc-grey-300"></span>
                            </div>
                            <div class="peer peer-greed">
                                <span class="fw-600 c-grey-600">Phase 6-8: PWA, Testing, Deployment</span>
                                <div class="progress mT-10">
                                    <div class="progress-bar bgc-grey-300" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="c-grey-500">⏳ Pending - Final Stages</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mT-30">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <h4 class="c-grey-900 mB-20">🚀 Quick Actions</h4>
                <div class="peers">
                    <div class="peer mR-20">
                        <a href="#" class="btn btn-primary">
                            <i class="ti-package mR-5"></i>
                            Manajemen Produk
                        </a>
                    </div>
                    <div class="peer mR-20">
                        <a href="#" class="btn btn-success">
                            <i class="ti-shopping-cart mR-5"></i>
                            Lihat Pesanan
                        </a>
                    </div>
                    <div class="peer mR-20">
                        <a href="#" class="btn btn-info">
                            <i class="ti-truck mR-5"></i>
                            Setup Paxel
                        </a>
                    </div>
                    <div class="peer">
                        <a href="#" class="btn btn-warning">
                            <i class="ti-settings mR-5"></i>
                            Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple welcome animation
    document.addEventListener('DOMContentLoaded', function() {
        // Add some basic interactivity for demo
        console.log('🎉 Adminator Admin Dashboard loaded successfully!');
        console.log('📚 Dokumentasi: https://puikinsh.github.io/Adminator-admin-dashboard/');
        console.log('🚀 Ready for Phase 2: UI/UX & Frontend Core');
    });
</script>
@endpush