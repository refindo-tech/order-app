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
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-blue-50 c-blue-500 me-3">
                    <i class="ti-shopping-cart fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Total Pesanan</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-orange-50 c-orange-500 me-3">
                    <i class="ti-time fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Menunggu Pembayaran</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['pending_payment'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-yellow-50 c-yellow-500 me-3">
                    <i class="ti-check-box fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Verifikasi Pembayaran</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['payment_verification'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-green-50 c-green-500 me-3">
                    <i class="ti-truck fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Sedang Dikirim</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['shipped'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-purple-50 c-purple-500 me-3">
                    <i class="ti-receipt fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Sudah Ada Resi</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['has_waybill'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="bgc-white bd bdrs-3 p-20 h-100 d-flex align-items-center">
                <span class="d-inline-flex lh-0 fw-600 bdrs-10em p-3 bgc-red-50 c-red-500 me-3">
                    <i class="ti-alert fs-5"></i>
                </span>
                <div>
                    <div class="text-muted small">Perlu Resi</div>
                    <div class="h4 mb-0 fw-600">{{ $stats['no_waybill'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h6 class="c-grey-900 mB-15">Filter Pesanan</h6>
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <!-- Baris filter: field pencarian & filter -->
            <div class="row g-3 align-items-end mB-15">
                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label small text-muted mb-1">Cari</label>
                    <input type="text"
                           name="search"
                           class="form-control form-control-sm"
                           placeholder="Order code, nama, telepon, resi..."
                           value="{{ $currentSearch }}">
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">Status</label>
                    <select name="status" class="form-control form-control-sm">
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
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">Resi Paxel</label>
                    <select name="paxel_status" class="form-control form-control-sm">
                        <option value="">Semua</option>
                        <option value="has_waybill" {{ $currentPaxelStatus === 'has_waybill' ? 'selected' : '' }}>Sudah Ada Resi</option>
                        <option value="no_waybill" {{ $currentPaxelStatus === 'no_waybill' ? 'selected' : '' }}>Belum Ada Resi</option>
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
                </div>
            </div>
            <!-- Baris tombol aksi -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 align-items-center pt-1">
                        <div class="px-1 py-1">
                            <button type="submit" class="btn btn-primary btn-sm px-3 py-2" title="Terapkan filter">
                                <i class="ti-search mR-5"></i>Terapkan Filter
                            </button>
                        </div>
                        <div class="px-1 py-1">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm px-3 py-2" title="Reset filter">
                                <i class="ti-reload mR-5"></i>Reset Filter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                                    @if($order->paxel_waybill)
                                        <br><small class="text-muted">
                                            <i class="ti-receipt"></i> Resi: {{ substr($order->paxel_waybill, 0, 10) }}...
                                        </small>
                                    @endif
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