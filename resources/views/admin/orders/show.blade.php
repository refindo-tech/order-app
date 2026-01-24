@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Detail Pesanan: {{ $order->order_code }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti-alert me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Item Pesanan</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong>
                                    @if($item->product)
                                        <br><small class="text-muted">ID: {{ $item->product_id }}</small>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                <td><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Customer</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nama:</strong>
                        <p class="mT-5">{{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Telepon:</strong>
                        <p class="mT-5">
                            <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
                        </p>
                    </div>
                    @if($order->customer_email)
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <p class="mT-5">{{ $order->customer_email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Alamat Pengiriman</h5>
                <p>{{ $order->shipping_address }}</p>
                @if($order->shipping_city || $order->shipping_postal_code || $order->shipping_province)
                    <p class="text-muted">
                        {{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}
                        @if($order->shipping_province)
                            <br>{{ $order->shipping_province }}
                        @endif
                    </p>
                @endif
            </div>

            <!-- Payment Information -->
            @if($order->payment)
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Pembayaran</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p class="mT-5">
                            @php
                                $paymentStatusColors = [
                                    'pending' => 'warning',
                                    'verified' => 'success',
                                    'rejected' => 'danger',
                                ];
                            @endphp
                            <span class="badge bg-{{ $paymentStatusColors[$order->payment->status] ?? 'secondary' }}">
                                {{ $order->payment->status_label }}
                            </span>
                        </p>
                    </div>
                    @if($order->payment->verified_at)
                    <div class="col-md-6 mb-3">
                        <strong>Diverifikasi:</strong>
                        <p class="mT-5">
                            {{ $order->payment->verified_at->format('d M Y H:i') }}
                            @if($order->payment->verifier)
                                <br><small>oleh {{ $order->payment->verifier->name }}</small>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($order->payment->payment_proof)
                    <div class="col-12 mb-3">
                        <strong>Bukti Pembayaran:</strong>
                        <div class="mT-10">
                            <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px;">
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($order->payment->rejection_reason)
                    <div class="col-12 mb-3">
                        <strong>Alasan Penolakan:</strong>
                        <p class="mT-5 text-danger">{{ $order->payment->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Paxel Information -->
            @if($order->paxel_waybill)
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Pengiriman Paxel</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nomor Resi:</strong>
                        <p class="mT-5"><code>{{ $order->paxel_waybill }}</code></p>
                    </div>
                    @if($order->shipped_at)
                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Pengiriman:</strong>
                        <p class="mT-5">{{ $order->shipped_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Order Status -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Status Pesanan</h5>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="pending_payment" {{ $order->status === 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="payment_verification" {{ $order->status === 'payment_verification' ? 'selected' : '' }}>Verifikasi Pembayaran</option>
                            <option value="payment_confirmed" {{ $order->status === 'payment_confirmed' ? 'selected' : '' }}>Pembayaran Diterima</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Sedang Dikirim</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Payment Verification -->
            @if($order->payment && $order->payment->status === 'pending')
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Verifikasi Pembayaran</h5>
                <form action="{{ route('admin.orders.verify-payment', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <button type="submit" name="action" value="verify" class="btn btn-success w-100 mb-2">
                            <i class="ti-check me-2"></i>Verifikasi Pembayaran
                        </button>
                        <button type="button" class="btn btn-danger w-100" onclick="showRejectForm()">
                            <i class="ti-close me-2"></i>Tolak Pembayaran
                        </button>
                    </div>
                    <div id="rejectForm" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan:</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" name="action" value="reject" class="btn btn-danger w-100">
                            <i class="ti-close me-2"></i>Konfirmasi Tolak
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Order Summary -->
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Ringkasan</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Order Code:</span>
                    <strong>{{ $order->order_code }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tanggal:</span>
                    <strong>{{ $order->created_at->format('d M Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Waktu:</span>
                    <strong>{{ $order->created_at->format('H:i') }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total:</span>
                    <strong class="text-primary h5">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes || $order->admin_notes)
            <div class="bgc-white bd bdrs-3 p-20">
                <h5 class="c-grey-900 mB-20">Catatan</h5>
                @if($order->notes)
                    <div class="mb-3">
                        <strong>Catatan Customer:</strong>
                        <p class="mT-5">{{ $order->notes }}</p>
                    </div>
                @endif
                @if($order->admin_notes)
                    <div>
                        <strong>Catatan Admin:</strong>
                        <p class="mT-5">{{ $order->admin_notes }}</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showRejectForm() {
        document.getElementById('rejectForm').style.display = 'block';
    }
</script>
@endpush