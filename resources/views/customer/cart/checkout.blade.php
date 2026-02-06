@extends('customer.layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="bg-light py-4">
    <div class="container">
        <h1 class="display-5 fw-bold text-dark">Checkout</h1>
        <p class="lead text-muted">Lengkapi data pengiriman untuk menyelesaikan pesanan</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div id="empty-cart-alert" class="alert alert-warning d-none">
            <i class="bi bi-cart-x me-2"></i>Keranjang kosong. <a href="{{ route('products.index') }}">Mulai belanja</a>
        </div>

        <form id="checkout-form" class="d-none" action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="cart_data" id="cart-data-input">
            <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="0">
            <input type="hidden" name="paxel_service_type" id="paxel-service-type-input" value="REGULAR">

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-person me-2"></i>Data Pemesan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" class="form-control" required>
                                    @error('customer_name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                                    @error('customer_phone')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="customer_email" class="form-control" placeholder="opsional">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Alamat Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="shipping_address" class="form-control" rows="2" required placeholder="Jalan, nomor rumah, RT/RW"></textarea>
                                @error('shipping_address')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <select name="shipping_province" id="shipping-province" class="form-select" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select name="shipping_city" id="shipping-city" class="form-select" required disabled>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan</label>
                                    <select name="shipping_district" id="shipping-district" class="form-select" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="shipping_postal_code" class="form-control" placeholder="Contoh: 12210">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" id="btn-cek-ongkir" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-calculator me-1"></i>Cek Ongkir
                                </button>
                                <span id="ongkir-loading" class="ms-2 d-none">
                                    <span class="spinner-border spinner-border-sm" role="status"></span> Memuat...
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4" id="shipping-options-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Pilih Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small">Isi alamat pengiriman lalu klik "Cek Ongkir"</p>
                            <div id="shipping-options-list"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan Pesanan</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Opsional"></textarea>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card position-sticky" style="top: 2rem;">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div id="checkout-summary">
                                <p class="text-muted">Memuat...</p>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span id="summary-subtotal">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir</span>
                                <span id="summary-shipping">Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span id="summary-total" class="text-primary">Rp 0</span>
                            </div>
                            <button type="submit" id="btn-submit-order" class="btn btn-primary w-100 mt-4" disabled>
                                <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
// API Wilayah Indonesia - via proxy Laravel (bypass CORS)
const WILAYAH_API = '{{ url("/api/wilayah") }}';

document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const uniqueCart = {};
    cart.forEach(item => {
        if (uniqueCart[item.id]) {
            uniqueCart[item.id].quantity += (item.quantity || 1);
        } else {
            uniqueCart[item.id] = { ...item, quantity: item.quantity || 1 };
        }
    });
    const cartItems = Object.values(uniqueCart);

    const emptyAlert = document.getElementById('empty-cart-alert');
    const form = document.getElementById('checkout-form');
    const cartDataInput = document.getElementById('cart-data-input');
    const shippingCostInput = document.getElementById('shipping-cost-input');
    const paxelServiceInput = document.getElementById('paxel-service-type-input');
    const checkoutSummary = document.getElementById('checkout-summary');
    const btnCekOngkir = document.getElementById('btn-cek-ongkir');
    const ongkirLoading = document.getElementById('ongkir-loading');
    const shippingOptionsList = document.getElementById('shipping-options-list');
    const btnSubmit = document.getElementById('btn-submit-order');

    let selectedShipping = { price: 0, service_type: 'REGULAR' };

    if (cartItems.length === 0) {
        emptyAlert.classList.remove('d-none');
    } else {
        form.classList.remove('d-none');
        cartDataInput.value = JSON.stringify(cartItems);
        renderSummary();
        loadProvinces();
    }

    function loadProvinces() {
        const sel = document.getElementById('shipping-province');
        if (!sel) return;
        fetch(WILAYAH_API + '/provinces')
            .then(r => {
                if (!r.ok) throw new Error('Network error');
                return r.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    sel.innerHTML = '<option value="">Pilih Provinsi</option>' +
                        data.map(p => `<option value="${p.name}" data-id="${p.id}">${p.name}</option>`).join('');
                }
            })
            .catch(err => {
                console.error('Gagal memuat provinsi:', err);
                sel.innerHTML = '<option value="">Gagal memuat. Coba refresh halaman.</option>';
            });
    }

    document.getElementById('shipping-province').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const citySel = document.getElementById('shipping-city');
        const districtSel = document.getElementById('shipping-district');
        citySel.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        citySel.disabled = true;
        districtSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districtSel.disabled = true;
        if (!this.value || !opt?.dataset?.id) return;
        fetch(WILAYAH_API + '/regencies/' + opt.dataset.id)
            .then(r => r.json())
            .then(data => {
                citySel.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>' +
                    data.map(c => `<option value="${c.name}" data-id="${c.id}">${c.name}</option>`).join('');
                citySel.disabled = false;
            })
            .catch(() => { citySel.disabled = false; });
    });

    document.getElementById('shipping-city').addEventListener('change', function() {
        const opts = this.options;
        const districtSel = document.getElementById('shipping-district');
        districtSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districtSel.disabled = true;
        if (!this.value) return;
        for (let i = 0; i < opts.length; i++) {
            if (opts[i].value === this.value && opts[i].dataset?.id) {
                fetch(WILAYAH_API + '/districts/' + opts[i].dataset.id)
                    .then(r => r.json())
                    .then(data => {
                        districtSel.innerHTML = '<option value="">Pilih Kecamatan</option>' +
                            data.map(d => `<option value="${d.name}">${d.name}</option>`).join('');
                        districtSel.disabled = false;
                    })
                    .catch(() => { districtSel.disabled = false; });
                break;
            }
        }
    });

    function renderSummary() {
        const subtotal = cartItems.reduce((s, i) => s + ((i.price || 0) * (i.quantity || 1)), 0);
        const shipping = selectedShipping.price || 0;
        const total = subtotal + shipping;

        document.getElementById('summary-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('summary-shipping').textContent = 'Rp ' + shipping.toLocaleString('id-ID');
        document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

        checkoutSummary.innerHTML = cartItems.map(i => `
            <div class="d-flex justify-content-between py-1">
                <span>${i.name || 'Produk'} x${i.quantity || 1}</span>
                <span>Rp ${((i.price || 0) * (i.quantity || 1)).toLocaleString('id-ID')}</span>
            </div>
        `).join('');
    }

    btnCekOngkir.addEventListener('click', async function() {
        const address = form.querySelector('[name="shipping_address"]').value?.trim();
        const province = form.querySelector('[name="shipping_province"]').value?.trim();
        const city = form.querySelector('[name="shipping_city"]').value?.trim();

        if (!address || !province || !city) {
            alert('Mohon isi alamat lengkap, provinsi, dan kota terlebih dahulu.');
            return;
        }

        btnCekOngkir.disabled = true;
        ongkirLoading.classList.remove('d-none');
        shippingOptionsList.innerHTML = '';

        try {
            const res = await fetch('{{ url("/api/shipping/rates") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({
                    address,
                    province,
                    city: city,
                    district: form.querySelector('[name="shipping_district"]')?.value || city,
                    village: form.querySelector('[name="shipping_village"]')?.value || '',
                    zip_code: form.querySelector('[name="shipping_postal_code"]').value || '',
                    cart_data: cartDataInput.value
                })
            });
            const data = await res.json();

            if (data.success && data.rates && data.rates.length > 0) {
                const enabledRates = data.rates.filter(r => r.enabled);
                const firstEnabled = enabledRates[0] || data.rates[0];

                shippingOptionsList.innerHTML = data.rates.map((r, idx) => {
                    const disabled = !r.enabled;
                    const priceText = r.enabled ? `Rp ${(r.price || 0).toLocaleString('id-ID')}` : (r.unavailable_reason || 'Belum tersedia');
                    const checked = !disabled && r.service_type === firstEnabled?.service_type;
                    const disabledAttr = disabled ? 'disabled' : '';
                    const opacityClass = disabled ? 'opacity-75' : '';
                    const badgeHtml = disabled ? `<span class="badge bg-secondary ms-1">Belum tersedia</span>` : '';
                    return `
                    <div class="form-check mb-3 p-3 border rounded ${opacityClass}" style="background: ${disabled ? '#f8f9fa' : 'transparent'};">
                        <input class="form-check-input shipping-option" type="radio" name="shipping_option" 
                            id="opt-${idx}" value="${r.service_type}" data-price="${r.price ?? 0}" data-enabled="${r.enabled}"
                            ${checked ? 'checked' : ''} ${disabledAttr}>
                        <label class="form-check-label w-100" for="opt-${idx}">
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <strong>${r.label || r.service_type}</strong>${badgeHtml}
                                <span class="text-muted ms-auto">${r.etd || ''}</span>
                            </div>
                            <p class="small text-muted mb-1 mt-0">${r.description || ''}</p>
                            <span class="${r.enabled ? 'fw-semibold text-primary' : 'text-muted'}">${priceText}</span>
                        </label>
                    </div>
                `;
                }).join('');

                document.querySelectorAll('.shipping-option').forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.dataset.enabled === 'false') return;
                        selectedShipping = { price: parseFloat(this.dataset.price), service_type: this.value };
                        shippingCostInput.value = selectedShipping.price;
                        paxelServiceInput.value = selectedShipping.service_type;
                        renderSummary();
                        btnSubmit.disabled = false;
                    });
                });

                selectedShipping = { price: parseFloat(firstEnabled?.price ?? 0), service_type: firstEnabled?.service_type ?? 'REGULAR' };
                shippingCostInput.value = selectedShipping.price;
                paxelServiceInput.value = selectedShipping.service_type;
                renderSummary();
                btnSubmit.disabled = false;
            } else {
                selectedShipping = { price: 0, service_type: 'REGULAR' };
                shippingCostInput.value = '0';
                paxelServiceInput.value = 'REGULAR';
                shippingOptionsList.innerHTML = '<p class="text-muted">Gratis ongkir (belum bisa mengecek tarif Paxel)</p>';
                renderSummary();
                btnSubmit.disabled = false;
            }
        } catch (e) {
            console.error(e);
            alert('Gagal mengecek ongkir. Silakan coba lagi atau hubungi kami.');
            selectedShipping = { price: 25000, service_type: 'REGULAR' };
            shippingCostInput.value = '25000';
            renderSummary();
            btnSubmit.disabled = false;
        } finally {
            btnCekOngkir.disabled = false;
            ongkirLoading.classList.add('d-none');
        }
    });

    form.addEventListener('submit', function() {
        if (!selectedShipping && parseInt(shippingCostInput.value) === 0) {
            if (!confirm('Anda belum memilih pengiriman. Lanjutkan dengan ongkir Rp 0?')) {
                return false;
            }
        }
        btnSubmit.disabled = true;
    });
});
</script>
@endpush
