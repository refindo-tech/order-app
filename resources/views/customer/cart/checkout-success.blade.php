@extends('customer.layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<!-- Success Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Message -->
                <div class="card border-success mb-4">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="text-success mb-3">Pesanan Berhasil Dibuat!</h2>
                        <p class="lead">Terima kasih atas pesanan Anda. Silakan lakukan pembayaran dan upload bukti pembayaran.</p>
                        <div class="bg-light rounded p-4 mb-4">
                            <h4 class="mb-2">Order Code:</h4>
                            <h3 class="text-primary mb-0"><code>{{ $order->order_code }}</code></h3>
                            <small class="text-muted">Simpan kode ini untuk tracking pesanan Anda</small>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
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
                                        <td>{{ $item->product_name }}</td>
                                        <td>Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
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
                </div>

                <!-- Payment Instructions -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card me-2"></i>Instruksi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <ol class="mb-0">
                            <li class="mb-2">Lakukan transfer sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                            <li class="mb-2">Upload bukti pembayaran di bawah ini</li>
                            <li class="mb-2">Admin akan memverifikasi pembayaran Anda</li>
                            <li>Anda akan menerima notifikasi via WhatsApp setelah pembayaran terverifikasi</li>
                        </ol>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($order->payment && $order->payment->status === 'verified')
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Pembayaran sudah diverifikasi!</strong>
                                <p class="mb-0 mt-2">Pesanan Anda sedang diproses.</p>
                            </div>
                        @elseif($order->payment && $order->payment->status === 'rejected')
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle me-2"></i>
                                <strong>Pembayaran ditolak.</strong>
                                @if($order->payment->rejection_reason)
                                    <p class="mb-0 mt-2">Alasan: {{ $order->payment->rejection_reason }}</p>
                                @endif
                            </div>
                        @endif

                        @if(!$order->payment || $order->payment->status !== 'verified')
                            <form action="{{ route('cart.upload-payment', $order->order_code) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                    <input type="file" 
                                           name="payment_proof" 
                                           class="form-control @error('payment_proof') is-invalid @enderror" 
                                           accept="image/*,.pdf" 
                                           required>
                                    @error('payment_proof')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPG, PNG, atau PDF (maks. 2MB)</small>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                                </button>
                            </form>
                        @endif

                        @if($order->payment && $order->payment->payment_proof)
                            <div class="mt-4">
                                <strong>Bukti Pembayaran yang Diupload:</strong>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                                             alt="Bukti Pembayaran" 
                                             class="img-thumbnail" 
                                             style="max-height: 200px;">
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Tracking -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-truck me-2"></i>Status Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Status Saat Ini:</strong>
                            <span class="badge bg-{{ $order->status === 'pending_payment' ? 'warning' : ($order->status === 'payment_confirmed' ? 'success' : 'info') }} ms-2">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <p class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Anda dapat melacak status pesanan menggunakan Order Code: <strong>{{ $order->order_code }}</strong>
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection