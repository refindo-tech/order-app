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

                <!-- Here -->

                <!-- Order Summary -->
                <!-- <div class="card mb-4">
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
                </div> -->

                <!-- Payment Instructions -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card me-2"></i>Instruksi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3 text-center">
                            <h6 class="mb-2"><strong>Total Pembayaran:</strong></h6>
                            <h4 class="text-primary mb-0">Rp {{ number_format($order->total, 0, ',', '.') }}</h4>
                        </div>
                        <ol class="mb-0">
                            <li class="mb-2">Lakukan transfer sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></li>
                            <li class="mb-2">Upload bukti pembayaran di bawah ini</li>
                            <li class="mb-2">Admin akan memverifikasi pembayaran Anda</li>
                        </ol>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-cash-coin me-2"></i>Tujuan Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="paymentMethodsAccordion">
                            <!-- QR Code -->
                            @if(config('constants.payment.qr_code.enabled'))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingQR">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQR" aria-expanded="false" aria-controls="collapseQR">
                                        <i class="bi bi-qr-code me-2"></i>QR Code
                                    </button>
                                </h2>
                                <div id="collapseQR" class="accordion-collapse collapse" aria-labelledby="headingQR" data-bs-parent="#paymentMethodsAccordion">
                                    <div class="accordion-body">
                                        <div class="text-center">
                                            @if(file_exists(public_path(config('constants.payment.qr_code.image'))))
                                                <img src="{{ asset(config('constants.payment.qr_code.image')) }}" 
                                                     alt="QR Code Pembayaran" 
                                                     class="img-fluid mb-2" 
                                                     style="max-width: 250px; border: 2px solid #dee2e6; border-radius: 8px;">
                                            @else
                                                <div class="bg-light p-4 d-inline-block mb-2" style="width: 250px; height: 250px; border: 2px dashed #dee2e6; border-radius: 8px;">
                                                    <i class="bi bi-qr-code" style="font-size: 4rem; color: #6c757d;"></i>
                                                    <p class="small text-muted mt-2 mb-0">QR Code akan tersedia</p>
                                                </div>
                                            @endif
                                            <p class="small text-muted mb-0">{{ config('constants.payment.qr_code.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Bank Transfer -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingBank">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBank" aria-expanded="false" aria-controls="collapseBank">
                                        <i class="bi bi-bank me-2"></i>Transfer Bank
                                    </button>
                                </h2>
                                <div id="collapseBank" class="accordion-collapse collapse" aria-labelledby="headingBank" data-bs-parent="#paymentMethodsAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-3">
                                            @foreach(config('constants.payment.banks') as $bank)
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 h-100">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="{{ $bank['icon'] }} me-2 text-primary" style="font-size: 1.5rem;"></i>
                                                        <strong>{{ $bank['name'] }}</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">No. Rekening:</small>
                                                        <code class="fs-6" style="user-select: all; cursor: pointer;" onclick="copyToClipboard('{{ $bank['account_number'] }}', this)">{{ $bank['account_number'] }}</code>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $bank['account_number'] }}', this)" title="Salin">
                                                            <i class="bi bi-clipboard"></i>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Atas Nama:</small>
                                                        <span class="small">{{ $bank['account_name'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- E-Wallet -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEwallet">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEwallet" aria-expanded="false" aria-controls="collapseEwallet">
                                        <i class="bi bi-wallet2 me-2"></i>E-Wallet
                                    </button>
                                </h2>
                                <div id="collapseEwallet" class="accordion-collapse collapse" aria-labelledby="headingEwallet" data-bs-parent="#paymentMethodsAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-3">
                                            @foreach(config('constants.payment.ewallets') as $ewallet)
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 h-100">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="{{ $ewallet['icon'] }} me-2 text-success" style="font-size: 1.5rem;"></i>
                                                        <strong>{{ $ewallet['name'] }}</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">No. {{ $ewallet['name'] }}:</small>
                                                        <code class="fs-6" style="user-select: all; cursor: pointer;" onclick="copyToClipboard('{{ $ewallet['account_number'] }}', this)">{{ $ewallet['account_number'] }}</code>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $ewallet['account_number'] }}', this)" title="Salin">
                                                            <i class="bi bi-clipboard"></i>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Atas Nama:</small>
                                                        <span class="small">{{ $ewallet['account_name'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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
                            <form id="payment-upload-form" action="{{ route('cart.upload-payment', $order->order_code) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                    <input type="file" 
                                           name="payment_proof" 
                                           id="payment_proof_input"
                                           class="form-control @error('payment_proof') is-invalid @enderror" 
                                           accept="image/*,.pdf" 
                                           required>
                                    @error('payment_proof')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPG, PNG, atau PDF (maks. 2MB)</small>
                                    <div id="file-info" class="mt-2 small text-muted d-none"></div>
                                </div>
                                <div id="upload-loading" class="alert alert-info d-none mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border spinner-border-sm me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Mengupload file, harap tunggu...</span>
                                    </div>
                                </div>
                                <button type="submit" id="upload-btn" class="btn btn-success w-100">
                                    <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                                </button>
                            </form>
                        @endif

                        @if($order->payment && $order->payment->payment_proof)
                            <div class="mt-4">
                                <strong>Bukti Pembayaran yang Diupload:</strong>
                                <div class="mt-2">
                                    @php
                                        $filePath = asset('storage/' . $order->payment->payment_proof);
                                        $fileExtension = strtolower(pathinfo($order->payment->payment_proof, PATHINFO_EXTENSION));
                                    @endphp
                                    <a href="{{ $filePath }}" target="_blank" class="d-inline-block">
                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $filePath }}" 
                                                 alt="Bukti Pembayaran" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 200px;">
                                        @else
                                            <div class="border rounded p-3 text-center" style="max-width: 200px;">
                                                <i class="bi bi-file-pdf" style="font-size: 3rem; color: #dc3545;"></i>
                                                <p class="mb-0 mt-2 small">Klik untuk melihat PDF</p>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg me-2">
                        <i class="bi bi-shop me-2"></i>Lanjut Belanja
                    </a>
                    <a href="{{ route('tracking.show', ['order_code' => $order->order_code]) }}" class="btn btn-outline-primary btn-lg me-2">
                        <i class="bi bi-truck me-2"></i>Lihat Status Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function() {
        const icon = button.querySelector('i');
        if (icon) {
            const originalClass = icon.className;
            icon.className = 'bi bi-check';
            setTimeout(function() {
                icon.className = originalClass;
            }, 2000);
        } else {
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i>';
            setTimeout(function() {
                button.innerHTML = originalHtml;
            }, 2000);
        }
    }).catch(function(err) {
        console.error('Failed to copy:', err);
        alert('Gagal menyalin. Silakan salin manual: ' + text);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-upload-form');
    const fileInput = document.getElementById('payment_proof_input');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadLoading = document.getElementById('upload-loading');
    const fileInfo = document.getElementById('file-info');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                const fileName = file.name;
                const fileType = file.type;
                
                fileInfo.classList.remove('d-none');
                fileInfo.innerHTML = `
                    <strong>File dipilih:</strong> ${fileName}<br>
                    <strong>Ukuran:</strong> ${fileSizeMB} MB<br>
                    <strong>Tipe:</strong> ${fileType}
                `;

                // Validate file size
                if (file.size > 2 * 1024 * 1024) {
                    fileInfo.classList.add('text-danger');
                    fileInfo.innerHTML += '<br><span class="text-danger">⚠ Ukuran file melebihi 2MB!</span>';
                    uploadBtn.disabled = true;
                } else {
                    fileInfo.classList.remove('text-danger');
                    uploadBtn.disabled = false;
                }
            } else {
                fileInfo.classList.add('d-none');
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            const file = fileInput?.files[0];
            
            if (!file) {
                e.preventDefault();
                alert('Silakan pilih file terlebih dahulu.');
                return false;
            }

            // Show loading indicator
            if (uploadLoading) {
                uploadLoading.classList.remove('d-none');
            }
            if (uploadBtn) {
                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengupload...';
            }

            // Log to console for debugging
            console.log('[Payment Upload] Form submitted', {
                fileName: file.name,
                fileSize: file.size,
                fileType: file.type,
                orderCode: '{{ $order->order_code }}'
            });
        });
    }
});
</script>
@endpush