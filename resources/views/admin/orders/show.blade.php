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
                        <p class="mT-5 mB-5">
                            <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
                        </p>
                        @php
                            $rawPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                            if ($rawPhone && substr($rawPhone, 0, 1) === '0') {
                                $waNumber = '62' . substr($rawPhone, 1);
                            } else {
                                $waNumber = $rawPhone;
                            }
                            $waText = urlencode("Halo, saya admin *".config('app.name')."*. Terkait pesanan dengan kode *{$order->order_code}*.");
                        @endphp
                        @if(!empty($waNumber))
                            <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}"
                               target="_blank"
                               class="btn btn-sm btn-success">
                                <i class="ti-comments-smiley mR-5"></i>Chat via WhatsApp
                            </a>
                        @endif
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
                            <a href="{{ storage_url($order->payment->payment_proof) }}" target="_blank">
                                <img src="{{ storage_url($order->payment->payment_proof) }}" 
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
                        <strong>Nomor Resi:</strong>
                        <p class="mT-5 d-flex align-items-center gap-2">
                            <code id="resiAdmin" class="fs-5" style="font-size: 1.2rem;">{{ $order->paxel_waybill }}</code>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyResi('resiAdmin')" title="Salin nomor resi">
                                <div class="p-4">
                                    <i class="ti-files"></i> Copy
                                </div>
                            </button>
                        </p>
                    @if($order->shipped_at)
                        <strong>Tanggal Pengiriman:</strong>
                        <p class="mT-5">{{ $order->shipped_at->format('d M Y H:i') }}</p>
                    @endif
                @if(session('tracking_error'))
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <i class="ti-alert me-2"></i>
                        <strong>Gagal refresh tracking:</strong><br>
                        <small>{{ session('tracking_error') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex flex-wrap mb-3">
                    <form id="refresh-tracking-form" action="{{ route('admin.orders.refresh-paxel-tracking', $order) }}" method="POST" class="d-inline">
                        @csrf
                        <div id="tracking-loading" class="alert alert-info d-none mb-2" style="font-size: 0.875rem;">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Memperbarui tracking...</span>
                            </div>
                        </div>
                        <button type="submit" id="btn-refresh-tracking" class="btn btn-success btn-sm mR-10 d-inline-flex ai-c">
                            <i class="ti-reload mR-5"></i><span>Refresh Tracking</span>
                        </button>
                    </form>
                    <a href="{{ config('paxel.tracking_url', 'https://www.paxel.co/track') }}?awb={{ $order->paxel_waybill }}"
                       target="_blank"
                       class="btn btn-primary btn-sm d-inline-flex ai-c">
                        <i class="ti-link mR-5"></i><span>Cek di Paxel</span>
                    </a>
                </div>
                @if(!empty($order->paxel_tracking))
                <div class="mt-3">
                    <strong>Riwayat Tracking</strong>
                    <div class="mT-10">
                        @foreach(array_reverse($order->paxel_tracking) as $track)
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="ti-more-alt" style="font-size: 0.6rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <strong>{{ $track['status_label'] ?? $track['status'] ?? '-' }}</strong>
                                @if(!empty($track['description']))
                                    <p class="text-muted small mb-0">{{ $track['description'] }}</p>
                                @endif
                                @if(!empty($track['datetime']))
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($track['datetime'])->format('d M Y H:i') }}</small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
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

            <!-- Kirim ke Paxel -->
            @if($order->canBeShipped() && !$order->paxel_waybill)
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Integrasi Paxel</h5>
                @if(session('paxel_error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="ti-alert me-2"></i>
                        <strong>Gagal membuat shipment Paxel:</strong><br>
                        <small>{{ session('paxel_error') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form id="create-paxel-form" action="{{ route('admin.orders.create-paxel-shipment', $order) }}" method="POST" onsubmit="return confirm('Kirim pesanan ini ke Paxel dan generate resi?');">
                    @csrf
                    <div id="paxel-loading" class="alert alert-info d-none mb-3">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Membuat shipment di Paxel, harap tunggu...</span>
                        </div>
                    </div>
                    <button type="submit" id="btn-create-paxel" class="btn btn-primary w-100">
                        <i class="ti-truck me-2"></i>Kirim ke Paxel
                    </button>
                </form>
                <p class="text-muted small mT-10 mb-0">Akan membuat shipment di Paxel dan mendapatkan nomor resi.</p>
            </div>
            @endif

            <!-- Payment Verification -->
            @if($order->payment && $order->payment->status === 'pending')
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Verifikasi Pembayaran</h5>
                <form id="payment-verify-form" action="{{ route('admin.orders.verify-payment', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <button type="submit" name="action" value="verify" class="btn btn-success w-100 mb-2" id="btn-verify">
                            <i class="ti-check me-2"></i>Verifikasi Pembayaran
                        </button>
                        <button type="button" class="btn btn-danger w-100" onclick="showRejectForm()">
                            <i class="ti-close me-2"></i>Tolak Pembayaran
                        </button>
                    </div>
                    <div id="rejectForm" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan: <span class="text-danger">*</span></label>
                            <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3"></textarea>
                            <small class="text-muted">Wajib diisi jika menolak pembayaran</small>
                        </div>
                        <button type="submit" name="action" value="reject" class="btn btn-danger w-100" id="btn-reject">
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
                <div class="d-flex justify-content-between mb-3">
                    <span>Total:</span>
                    <strong class="text-primary h5">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('cart.checkout-success', $order->order_code) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                        <i class="ti-layout-media-center-alt mR-5"></i>Lihat Halaman Checkout Customer
                    </a>
                    <a href="{{ route('tracking.show', ['order_code' => $order->order_code]) }}"
                       target="_blank"
                       class="btn btn-info btn-sm">
                        <i class="ti-search mR-5"></i>Lihat Halaman Tracking Customer
                    </a>
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
        document.getElementById('rejection_reason').focus();
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('payment-verify-form');
        const btnVerify = document.getElementById('btn-verify');
        const btnReject = document.getElementById('btn-reject');
        const rejectionReason = document.getElementById('rejection_reason');

        if (form && btnReject) {
            btnReject.addEventListener('click', function(e) {
                const reason = rejectionReason ? rejectionReason.value.trim() : '';
                if (!reason) {
                    e.preventDefault();
                    alert('Mohon isi alasan penolakan terlebih dahulu.');
                    if (rejectionReason) {
                        rejectionReason.focus();
                    }
                    return false;
                }
            });
        }

        if (form && btnVerify) {
            btnVerify.addEventListener('click', function(e) {
                // Ensure rejection_reason is not required when verifying
                if (rejectionReason) {
                    rejectionReason.removeAttribute('required');
                }
            });
        }
    });
    function copyResi(id) {
        var el = document.getElementById(id);
        var text = el ? el.textContent.trim() : '';
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            var btn = el.nextElementSibling;
            if (btn) {
                var orig = btn.innerHTML;
                btn.innerHTML = '<i class="ti-check"></i>';
                setTimeout(function() { btn.innerHTML = orig; }, 1500);
            }
        });
    }

    // Handle Paxel form submissions with loading indicators
    document.addEventListener('DOMContentLoaded', function() {
        const createPaxelForm = document.getElementById('create-paxel-form');
        const refreshTrackingForm = document.getElementById('refresh-tracking-form');
        const paxelLoading = document.getElementById('paxel-loading');
        const trackingLoading = document.getElementById('tracking-loading');
        const btnCreatePaxel = document.getElementById('btn-create-paxel');
        const btnRefreshTracking = document.getElementById('btn-refresh-tracking');

        if (createPaxelForm && btnCreatePaxel) {
            createPaxelForm.addEventListener('submit', function() {
                if (paxelLoading) paxelLoading.classList.remove('d-none');
                if (btnCreatePaxel) {
                    btnCreatePaxel.disabled = true;
                    btnCreatePaxel.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                }
            });
        }

        if (refreshTrackingForm && btnRefreshTracking) {
            refreshTrackingForm.addEventListener('submit', function() {
                if (trackingLoading) trackingLoading.classList.remove('d-none');
                if (btnRefreshTracking) {
                    btnRefreshTracking.disabled = true;
                    btnRefreshTracking.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
                }
            });
        }
    });
</script>
@endpush