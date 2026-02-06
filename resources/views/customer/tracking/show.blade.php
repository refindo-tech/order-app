@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="bg-light py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tracking.index') }}">Cek Pesanan</a></li>
                <li class="breadcrumb-item active">{{ $order->order_code }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Status Pesanan: {{ $order->order_code }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $statusClass = match($order->status) {
                                'pending_payment' => 'alert-warning',
                                'payment_verification' => 'alert-info',
                                'payment_confirmed' => 'alert-primary',
                                'processing' => 'alert-primary',
                                'shipped' => 'alert-info',
                                'delivered' => 'alert-success',
                                'cancelled' => 'alert-danger',
                                default => 'alert-secondary',
                            };
                        @endphp

                        <div class="alert {{ $statusClass }} d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <strong><i class="bi bi-box-seam me-2"></i>Status Pesanan: {{ $order->status_label }}</strong>
                            </div>
                        </div>

                        @if($order->paxel_waybill)
                            <h6>Nomor Resi:</h6>
                            <code id="resiCustomer">{{ $order->paxel_waybill }}</code>
                            <button type="button" class="btn btn-sm btn-outline-dark ms-2" onclick="copyResi('resiCustomer')" title="Salin nomor resi">
                                <i class="bi bi-clipboard"></i> Salin
                            </button>
                            <!-- <a href="{{ config('paxel.tracking_url', 'https://www.paxel.co/track') }}?awb={{ $order->paxel_waybill }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Cek di Paxel
                            </a> -->

                            @if(!empty($order->paxel_tracking))
                                <h6 class="mb-3 mt-3">Riwayat Pengiriman</h6>
                                <div class="timeline">
                                    @foreach(array_reverse($order->paxel_tracking) as $track)
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-circle-fill text-primary" style="font-size: 0.5rem;"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
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
                            @endif
                        @else
                            <p class="text-muted mb-0">
                                Pesanan belum dikirim. Resi akan tersedia setelah admin mengirim ke Paxel.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Item Pesanan</h5>
                    </div>
                    <div class="card-body">
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
                                    <td>{{ $item->product_name }}</td>
                                    <td>Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ringkasan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <p class="small text-muted mb-0">
                            <strong>Alamat:</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}<br>
                            {{ $order->shipping_province }}
                        </p>
                    </div>
                </div>

                @if(in_array($order->status, ['pending_payment', 'payment_verification']) && (!$order->payment || $order->payment->status !== 'verified'))
                    <a href="{{ route('cart.checkout-success', $order->order_code) }}" class="btn btn-success w-100 mt-3">
                        <i class="bi bi-upload me-2"></i>Selesaikan Pembayaran
                    </a>
                @endif

                <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary w-100 mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Cek Pesanan Lain
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function copyResi(id) {
        var el = document.getElementById(id);
        var text = el ? el.textContent.trim() : '';
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            var btn = el.nextElementSibling;
            if (btn) {
                var orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check"></i> Tersalin';
                setTimeout(function() { btn.innerHTML = orig; }, 2000);
            }
        });
    }
</script>
@endpush
@endsection
