@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Manajemen Pesanan</h4>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6 col-xl-3"></div>
        
        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="peers fxw-nw ai-c">
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">
                                    <i class="ti-shopping-cart"></i>
                                </span>
                            </div>
                            <div class="peer peer-greed pL-20">
                                <h6 class="mB-5">Total Pesanan</h6>
                                <h3 class="m-0">{{ $stats['total'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="peers fxw-nw ai-c">
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-orange-50 c-orange-500">
                                    <i class="ti-time"></i>
                                </span>
                            </div>
                            <div class="peer peer-greed pL-20">
                                <h6 class="mB-5">Menunggu Pembayaran</h6>
                                <h3 class="m-0">{{ $stats['pending_payment'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="peers fxw-nw ai-c">
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-yellow-50 c-yellow-500">
                                    <i class="ti-check-box"></i>
                                </span>
                            </div>
                            <div class="peer peer-greed pL-20">
                                <h6 class="mB-5">Verifikasi Pembayaran</h6>
                                <h3 class="m-0">{{ $stats['payment_verification'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-md-6 col-xl-3">
            <div class="bdrs-3 p-20 bgc-white bd">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="peers fxw-nw ai-c">
                            <div class="peer">
                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">
                                    <i class="ti-truck"></i>
                                </span>
                            </div>
                            <div class="peer peer-greed pL-20">
                                <h6 class="mB-5">Sedang Dikirim</h6>
                                <h3 class="m-0">{{ $stats['shipped'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari order code, nama, atau telepon..." 
                               value="{{ $currentSearch }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending_payment" {{ $currentStatus === 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="payment_verification" {{ $currentStatus === 'payment_verification' ? 'selected' : '' }}>Verifikasi Pembayaran</option>
                            <option value="payment_confirmed" {{ $currentStatus === 'payment_confirmed' ? 'selected' : '' }}>Pembayaran Diterima</option>
                            <option value="processing" {{ $currentStatus === 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="shipped" {{ $currentStatus === 'shipped' ? 'selected' : '' }}>Sedang Dikirim</option>
                            <option value="delivered" {{ $currentStatus === 'delivered' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $currentStatus === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti-search me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">
                            <i class="ti-reload me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_code }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $order->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $order->customer_phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $order->items->sum('quantity') }} item(s)</span>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                </td>
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
                                <td>
                                    <small>{{ $order->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Detail">
                                        <i class="ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="ti-shopping-cart" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-3 text-muted">Tidak ada pesanan ditemukan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection