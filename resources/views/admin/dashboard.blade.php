@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Dashboard Overview</h4>
                <p class="mB-0">Selamat datang di Admin Panel <strong>{{ config('app.name') }}</strong></p>
            </div>
        </div>
    </div>

    <!-- Overview Stats Cards -->
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6 col-xl-3"></div>
        
        <!-- Total Products -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd h-100">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">
                            <i class="ti-package"></i>
                        </span>
                    </div>
                    <div class="peer peer-greed pL-20">
                        <span class="fsz-xs fw-600 c-grey-600 tt-u ls-1 d-block mB-5">Total Produk</span>
                        <h3 class="m-0 c-grey-800">{{ \App\Models\Product::count() ?? 0 }}</h3>
                        <small class="fsz-xs c-grey-500">items</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd h-100">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">
                            <i class="ti-shopping-cart"></i>
                        </span>
                    </div>
                    <div class="peer peer-greed pL-20">
                        <span class="fsz-xs fw-600 c-grey-600 tt-u ls-1 d-block mB-5">Total Pesanan</span>
                        <h3 class="m-0 c-grey-800">{{ $stats['total'] ?? 0 }}</h3>
                        <small class="fsz-xs c-grey-500">semua waktu</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Today -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd h-100">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">
                            <i class="ti-calendar"></i>
                        </span>
                    </div>
                    <div class="peer peer-greed pL-20">
                        <span class="fsz-xs fw-600 c-grey-600 tt-u ls-1 d-block mB-5">Pesanan Hari Ini</span>
                        <h3 class="m-0 c-green-500">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</h3>
                        <small class="fsz-xs c-grey-500">pesanan baru</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paxel Shipments -->
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd h-100">
                <div class="peers fxw-nw ai-c">
                    <div class="peer">
                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">
                            <i class="ti-truck"></i>
                        </span>
                    </div>
                    <div class="peer peer-greed pL-20">
                        <span class="fsz-xs fw-600 c-grey-600 tt-u ls-1 d-block mB-5">Total Pengiriman</span>
                        <h3 class="m-0 c-purple-500">{{ $paxelStats['total_shipments'] ?? 0 }}</h3>
                        <small class="fsz-xs c-grey-500">{{ $paxelStats['pending_shipment'] ?? 0 }} perlu resi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row mT-30">
        <!-- Order Statistics -->
        <div class="col-md-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">
                    <i class="ti-shopping-cart mR-5"></i>Statistik Pesanan
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-red-50 bdrs-3 h-100">
                            <i class="ti-time fsz-xl c-red-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Menunggu Pembayaran</span>
                            <h3 class="m-0 c-red-500">{{ $stats['pending_payment'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-orange-50 bdrs-3 h-100">
                            <i class="ti-check-box fsz-xl c-orange-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Verifikasi Pembayaran</span>
                            <h3 class="m-0 c-orange-500">{{ $stats['payment_verification'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-green-50 bdrs-3 h-100">
                            <i class="ti-check fsz-xl c-green-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Pembayaran Diterima</span>
                            <h3 class="m-0 c-green-500">{{ $stats['payment_confirmed'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-blue-50 bdrs-3 h-100">
                            <i class="ti-check-box fsz-xl c-blue-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Selesai</span>
                            <h3 class="m-0 c-blue-500">{{ $stats['delivered'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paxel Statistics -->
        <div class="col-md-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">
                    <i class="ti-truck mR-5"></i>Statistik Pengiriman Paxel
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-purple-50 bdrs-3 h-100">
                            <i class="ti-receipt fsz-xl c-purple-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Total Shipment</span>
                            <h3 class="m-0 c-purple-500">{{ $paxelStats['total_shipments'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-red-50 bdrs-3 h-100">
                            <i class="ti-alert fsz-xl c-red-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Perlu Resi</span>
                            <h3 class="m-0 c-red-500">{{ $paxelStats['pending_shipment'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-blue-50 bdrs-3 h-100">
                            <i class="ti-truck fsz-xl c-blue-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Dalam Perjalanan</span>
                            <h3 class="m-0 c-blue-500">{{ $paxelStats['in_transit'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3 bgc-green-50 bdrs-3 h-100">
                            <i class="ti-check fsz-xl c-green-500 d-block mB-10"></i>
                            <span class="fsz-xs c-grey-600 d-block mB-5">Terkirim</span>
                            <h3 class="m-0 c-green-500">{{ $paxelStats['delivered_via_paxel'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue & Trend Section -->
    <!-- <div class="row">
        <div class="col-md-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">
                    <i class="ti-money mR-5"></i>Detail Pendapatan
                </h5>
                <div class="mb-3 pb-3 bdB">
                    <span class="fsz-xs c-grey-600 d-block mB-5">Hari Ini</span>
                    <h4 class="m-0 c-green-500">Rp {{ number_format($revenueStats['today'] ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="mb-3 pb-3 bdB">
                    <span class="fsz-xs c-grey-600 d-block mB-5">Minggu Ini</span>
                    <h4 class="m-0 c-blue-500">Rp {{ number_format($revenueStats['this_week'] ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="mb-3 pb-3 bdB">
                    <span class="fsz-xs c-grey-600 d-block mB-5">Bulan Ini</span>
                    <h4 class="m-0 c-purple-500">Rp {{ number_format($revenueStats['this_month'] ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div class="mT-15">
                    <span class="fsz-xs c-grey-600 d-block mB-5">Total Semua Waktu</span>
                    <h3 class="m-0 c-grey-800">Rp {{ number_format($revenueStats['all_time'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">
                    <i class="ti-bar-chart mR-5"></i>Trend 7 Hari Terakhir
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th class="fsz-xs">Tanggal</th>
                                <th class="text-end fsz-xs">Pesanan</th>
                                <th class="text-end fsz-xs">Shipment</th>
                                <th class="text-end fsz-xs">Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trendData ?? [] as $date => $data)
                            <tr>
                                <td class="fsz-xs">{{ $data['date'] }}</td>
                                <td class="text-end fw-600">{{ $data['orders'] }}</td>
                                <td class="text-end fw-600 c-blue-500">{{ $data['shipped'] }}</td>
                                <td class="text-end fw-600 c-green-500">{{ $data['delivered'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center c-grey-500">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Recent Orders -->
    @if(isset($recentOrders) && $recentOrders->count() > 0)
    <div class="row mT-20">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <div class="d-flex justify-content-between align-items-center mB-20">
                    <h5 class="c-grey-900 m-0">
                        <i class="ti-list mR-5"></i>Pesanan Terbaru
                    </h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua <i class="ti-arrow-right mL-5"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="fsz-xs">Order Code</th>
                                <th class="fsz-xs">Customer</th>
                                <th class="fsz-xs text-end">Total</th>
                                <th class="fsz-xs">Status</th>
                                <th class="fsz-xs">Tanggal</th>
                                <th class="fsz-xs text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td><strong class="c-grey-800">{{ $order->order_code }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td class="text-end fw-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending_payment' => 'warning',
                                            'payment_verification' => 'info',
                                            'payment_confirmed' => 'success',
                                            'processing' => 'primary',
                                            'shipped' => 'info',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td><small class="c-grey-600">{{ $order->created_at->format('d M Y H:i') }}</small></td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
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