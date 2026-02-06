@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-truck text-primary" style="font-size: 3rem;"></i>
                            <h2 class="mt-3">Cek Status Pesanan</h2>
                            <p class="text-muted">Masukkan kode order dan nomor WhatsApp untuk melihat status pengiriman</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('tracking.show') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Kode Order</label>
                                <input type="text" name="order_code" class="form-control form-control-lg" 
                                    value="{{ old('order_code') }}" 
                                    placeholder="Contoh: ORD-XXXXXXXX" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nomor WhatsApp (opsional)</label>
                                <input type="text" name="phone" class="form-control" 
                                    value="{{ old('phone') }}" 
                                    placeholder="08xxxxxxxxxx">
                                <small class="text-muted">Untuk memastikan hanya pemilik pesanan yang bisa melihat</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-search me-2"></i>Cek Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
