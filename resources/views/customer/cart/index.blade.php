@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<!-- Page Header -->
<section class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-dark">1. Keranjang Belanja</h1>
                <p class="lead text-muted">Review produk yang akan Anda beli</p>
            </div>
            <div class="col-lg-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Keranjang</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="py-5">
    <div class="container">
        <!-- Card Instruksi -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body py-4">
                <div class="row align-items-stretch g-0 flex-md-nowrap">
                    <!-- Step 1: Masuk Keranjang -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold">1</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Masuk Keranjang</h6>
                            <p class="small text-muted mb-0">Tambahkan produk ke keranjang belanja dari halaman produk yang Anda inginkan.</p>
                        </div>
                    </div>
                    <div class="col-auto d-none d-md-flex align-items-center text-muted">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <!-- Step 2: Checkout -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle border border-2 border-success d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold text-success">2</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Checkout</h6>
                            <p class="small text-muted mb-0">Lengkapi data pemesan dan alamat pengiriman untuk melanjutkan pesanan.</p>
                        </div>
                    </div>
                    <div class="col-auto d-none d-md-flex align-items-center text-muted">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <!-- Step 3: Bayar -->
                    <div class="col-12 col-md-4 d-flex">
                        <div class="d-flex flex-column flex-grow-1 text-center px-3 py-2">
                            <div class="rounded-circle border border-2 border-success d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 48px; height: 48px;">
                                <span class="fw-bold text-success">3</span>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Bayar</h6>
                            <p class="small text-muted mb-0">Lakukan pembayaran sesuai metode yang dipilih untuk menyelesaikan pesanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-cart3 me-2"></i>Item dalam Keranjang
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Cart will be populated by JavaScript -->
                        <div id="cart-items">
                            <!-- Loading state -->
                            <div class="text-center py-5" id="cart-loading">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Memuat keranjang...</p>
                            </div>
                            
                            <!-- Empty cart state -->
                            <div class="text-center py-5 d-none" id="empty-cart">
                                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                                <h4 class="mt-3 text-muted">Keranjang Kosong</h4>
                                <p class="text-muted mb-4">Belum ada produk yang ditambahkan ke keranjang</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Mulai Belanja
                                </a>
                            </div>
                            
                            <!-- Cart items will be inserted here -->
                            <div id="cart-list"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Continue Shopping -->
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Produk Lainnya
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal (<span id="total-items">0</span> item)</span>
                                <span id="subtotal">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Kirim</span>
                                <span class="text-info">Akan dihitung</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span id="total" class="text-primary">Rp 0</span>
                            </div>
                            
                            <div class="mt-4">
                                <button id="checkout-btn" class="btn btn-primary w-100 btn-lg" disabled>
                                    <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                                </button>
                            </div>
                            
                            <!-- Shipping Info -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-truck me-2"></i>Info Pengiriman
                                </h6>
                                <small class="text-muted">
                                    • Gratis ongkir untuk pembelian di atas Rp {{ number_format(config('constants.shipping.free_shipping_threshold'), 0, ',', '.') }}<br>
                                    • Estimasi pengiriman {{ config('constants.shipping.estimated_delivery') }}<br>
                                    • Pengiriman menggunakan {{ config('constants.shipping.provider') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Service -->
                    <div class="card mt-4">
                        <div class="card-body text-center">
                            <i class="bi bi-headset text-success" style="font-size: 2rem;"></i>
                            <h6 class="mt-2">Butuh Bantuan?</h6>
                            <p class="small text-muted mb-3">
                                Tim customer service kami siap membantu
                            </p>
                            <a href="{{ config('constants.social_media.whatsapp') }}" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-whatsapp me-1"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Cart management using localStorage (temporary for Phase 2)
    class CartManager {
        constructor() {
            this.cart = this.getCartItems();
            this.init();
        }
        
        init() {
            this.renderCart();
            this.bindEvents();
        }
        
        // Get unit price for item (grosir if qty >= minimal_grosir)
        getUnitPrice(item) {
            const qty = Number(item.quantity) || 1;
            const minG = item.minimal_grosir != null ? Number(item.minimal_grosir) : null;
            const hG = item.harga_grosir != null ? parseFloat(item.harga_grosir) : null;
            if (minG != null && hG != null && qty >= minG) return hG;
            return parseFloat(item.price) || 0;
        }
        
        // Get cart items (no duplicates by ID)
        getCartItems() {
            const rawCart = JSON.parse(localStorage.getItem('cart') || '[]');
            const uniqueItems = {};
            
            rawCart.forEach(item => {
                if (uniqueItems[item.id]) {
                    uniqueItems[item.id].quantity += (item.quantity || 1);
                    if (item.minimal_grosir != null && item.harga_grosir != null) {
                        uniqueItems[item.id].minimal_grosir = item.minimal_grosir;
                        uniqueItems[item.id].harga_grosir = item.harga_grosir;
                    }
                    if (item.image) uniqueItems[item.id].image = item.image;
                    if (item.vouchers_available && item.vouchers_available.length) uniqueItems[item.id].vouchers_available = item.vouchers_available;
                    if (item.vouchers_selected && item.vouchers_selected.length) {
                        var existing = uniqueItems[item.id].vouchers_selected || [];
                        item.vouchers_selected.forEach(function(id) { if (existing.indexOf(id) === -1) existing.push(id); });
                        uniqueItems[item.id].vouchers_selected = existing;
                    }
                } else {
                    uniqueItems[item.id] = {
                        id: item.id,
                        name: item.name || `Produk ${item.id}`,
                        price: parseFloat(item.price) || 20000,
                        minimal_grosir: item.minimal_grosir != null ? Number(item.minimal_grosir) : null,
                        harga_grosir: item.harga_grosir != null ? parseFloat(item.harga_grosir) : null,
                        description: item.description || 'Produk berkualitas premium',
                        quantity: item.quantity || 1,
                        image: item.image || '',
                        vouchers_available: item.vouchers_available || [],
                        vouchers_selected: item.vouchers_selected || []
                    };
                }
            });
            
            return Object.values(uniqueItems);
        }
        
        // Calculate voucher discount for one item. Returns { totalDiscount, finalPrice }
        getDiscountForItem(item) {
            var subtotal = this.getUnitPrice(item) * (Number(item.quantity) || 1);
            var available = item.vouchers_available || [];
            var selected = item.vouchers_selected || [];
            var sumPercent = 0, sumNominal = 0;
            selected.forEach(function(vid) {
                var v = available.find(function(x) { return x.id === vid || x.id === parseInt(vid, 10); });
                if (!v) return;
                if (v.discount_type === 'percent') sumPercent += subtotal * (Number(v.discount_value) / 100);
                else sumNominal += Number(v.discount_value) || 0;
            });
            var totalDiscount = Math.min(subtotal, sumPercent + sumNominal);
            return { totalDiscount: totalDiscount, finalPrice: Math.max(0, subtotal - totalDiscount), subtotal: subtotal };
        }
        
        toggleVoucher(productId, voucherId) {
            this.cart = this.cart.map(function(item) {
                if (item.id !== productId) return item;
                var sel = item.vouchers_selected || [];
                var idx = sel.indexOf(voucherId);
                if (idx === -1) sel.push(voucherId);
                else sel.splice(idx, 1);
                return { ...item, vouchers_selected: sel };
            });
            this.saveCart();
            this.renderCart();
        }
        
        renderCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            const cartList = document.getElementById('cart-list');
            const emptyCart = document.getElementById('empty-cart');
            const cartLoading = document.getElementById('cart-loading');
            
            // Hide loading
            cartLoading.classList.add('d-none');
            
            if (this.cart.length === 0) {
                emptyCart.classList.remove('d-none');
                cartList.innerHTML = '';
                this.updateSummary();
                return;
            }
            
            emptyCart.classList.add('d-none');
            
            // Render cart items (unit price, voucher discount)
            const placeholderImg = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 150 150' fill='none'%3E%3Crect width='150' height='150' fill='%23f8f9fa' rx='8'/%3E%3Crect x='25' y='40' width='100' height='70' fill='%23dee2e6' rx='5'/%3E%3Ctext x='75' y='80' text-anchor='middle' fill='%236c757d' font-family='Arial' font-size='12'%3ENo Image%3C/text%3E%3C/svg%3E";
            const self = this;
            cartList.innerHTML = this.cart.map(item => {
                const unitPrice = this.getUnitPrice(item);
                const qty = Number(item.quantity) || 1;
                const minG = item.minimal_grosir != null ? Number(item.minimal_grosir) : null;
                const isGrosir = minG != null && item.harga_grosir != null && qty >= minG;
                const disc = this.getDiscountForItem(item);
                const imgSrc = (item.image && item.image.trim()) ? item.image : placeholderImg;
                const vouchersAvailable = item.vouchers_available || [];
                const vouchersSelected = item.vouchers_selected || [];
                let voucherHtml = '';
                if (vouchersAvailable.length > 0) {
                    voucherHtml = ''
                        + '<div class="mt-2">'
                        + '  <div class="card border border-primary bg-primary bg-opacity-10 shadow-sm">'
                        + '    <div class="card-body py-2 px-3 small">'
                        + '      <div class="d-flex justify-content-between align-items-center mb-1 text-primary">'
                        + '        <strong>Pilih Voucher Diskon</strong>'
                        + '      </div>';
                    vouchersAvailable.forEach(function(v) {
                        const discountText = v.discount_type === 'percent'
                            ? 'Diskon ' + (v.discount_value || 0) + '%'
                            : 'Diskon Rp ' + (v.discount_value || 0).toLocaleString('id-ID');
                        const label = (v.name ? v.name + ': ' : '') + discountText;
                        const checked = vouchersSelected.indexOf(v.id) !== -1 || vouchersSelected.indexOf(parseInt(v.id, 10)) !== -1;
                        const cbId = 'voucher-cb-' + item.id + '-' + v.id;
                        voucherHtml += ''
                            + '<div class="form-check mb-1">'
                            + '  <input class="form-check-input cart-voucher-cb" type="checkbox" id="' + cbId + '"'
                            + '         data-product-id="' + item.id + '" data-voucher-id="' + v.id + '"'
                            +           (checked ? ' checked' : '')
                            + '         onchange="cart.toggleVoucher(' + item.id + ', ' + v.id + ')">'
                            + '  <label class="form-check-label cursor-pointer" for="' + cbId + '">' + label + '</label>'
                            + '</div>';
                    });
                    if (disc.totalDiscount > 0) {
                        voucherHtml += '<div class="mt-1 text-success fw-semibold">Total Potongan: Rp ' + disc.totalDiscount.toLocaleString('id-ID') + '</div>';
                    }
                    voucherHtml += '    </div></div></div>';
                }
                return `
                <div class="cart-item border-bottom py-3" data-id="${item.id}">
                    <div class="row align-items-start">
                        <div class="col-md-2">
                            <div class="ratio ratio-1x1">
                                <img src="${imgSrc.replace(/"/g, '&quot;')}" class="img-fluid rounded" alt="${(item.name || 'Produk').replace(/"/g, '&quot;')}" onerror="this.src='${placeholderImg}'">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">${item.name || 'Produk'} ${isGrosir ? '<span class="badge bg-success ms-1">Harga Grosir</span>' : ''}</h6>
                            <p class="text-muted small mb-0">${item.description || 'Produk berkualitas premium'}</p>
                            <div class="small mt-1">Rp ${unitPrice.toLocaleString('id-ID')} × ${qty} = Rp ${disc.subtotal.toLocaleString('id-ID')}</div>
                            ${voucherHtml}
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="fw-bold">Rp ${unitPrice.toLocaleString('id-ID')}</span>
                            ${isGrosir ? '<br><small class="text-success">grosir</small>' : ''}
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary" onclick="cart.updateQuantity(${item.id}, ${item.quantity - 1})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                                <button class="btn btn-outline-secondary" onclick="cart.updateQuantity(${item.id}, ${item.quantity + 1})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-primary">Rp ${disc.finalPrice.toLocaleString('id-ID')}</span>
                                ${disc.totalDiscount > 0 ? '<small class="text-success">- Rp ' + disc.totalDiscount.toLocaleString('id-ID') + '</small>' : ''}
                                <button class="btn btn-outline-danger btn-sm mt-1" onclick="cart.removeItem(${item.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
            
            this.updateSummary();
        }
        
        updateQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                this.removeItem(productId);
                return;
            }
            
            // Update specific item quantity (no duplicates in cart)
            this.cart = this.cart.map(item => {
                if (item.id === productId) {
                    return { ...item, quantity: newQuantity };
                }
                return item;
            });
            
            this.saveCart();
            this.renderCart();
        }
        
        removeItem(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
            this.saveCart();
            this.renderCart();
        }
        
        updateSummary() {
            const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = this.cart.reduce((sum, item) => {
                const d = this.getDiscountForItem(item);
                return sum + d.finalPrice;
            }, 0);
            
            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            
            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            if (totalItems > 0) {
                checkoutBtn.disabled = false;
                checkoutBtn.onclick = () => this.proceedToCheckout();
            } else {
                checkoutBtn.disabled = true;
            }
            
            // Update navbar cart count
            window.dispatchEvent(new Event('cart-updated'));
        }
        
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        }
        
        // Add item to cart (prevent duplicates)
        addItem(product) {
            const existingIndex = this.cart.findIndex(item => item.id === product.id);
            
            if (existingIndex >= 0) {
                // Update quantity if item exists
                this.cart[existingIndex].quantity += (product.quantity || 1);
            } else {
                // Add new item (include grosir, image, vouchers)
                this.cart.push({
                    id: product.id,
                    name: product.name || `Produk ${product.id}`,
                    price: product.price || 20000,
                    minimal_grosir: product.minimal_grosir ?? null,
                    harga_grosir: product.harga_grosir ?? null,
                    description: product.description || 'Produk berkualitas premium',
                    quantity: product.quantity || 1,
                    image: product.image || '',
                    vouchers_available: product.vouchers_available || [],
                    vouchers_selected: product.vouchers_selected || []
                });
            }
            
            this.saveCart();
            this.renderCart();
        }
        
        bindEvents() {
            // Listen for cart updates from other pages
            window.addEventListener('storage', () => {
                this.cart = JSON.parse(localStorage.getItem('cart') || '[]');
                this.renderCart();
            });
        }
        
        proceedToCheckout() {
            window.location.href = '{{ route("cart.checkout") }}';
        }
        
        clearCart() {
            if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                this.cart = [];
                this.saveCart();
                this.renderCart();
            }
        }
    }
    
    // Initialize cart when page loads
    let cart;
    document.addEventListener('DOMContentLoaded', function() {
        cart = new CartManager();
    });
    
    // Add clear cart button functionality
    function clearCart() {
        cart.clearCart();
    }
</script>
@endpush

@push('styles')
<style>
    .cart-item:last-child {
        border-bottom: none !important;
    }
    .cart-item .form-check-label {
        cursor: pointer;
    }
    
    .input-group-sm .form-control {
        font-size: 0.875rem;
    }
    
    .position-sticky {
        top: 2rem !important;
    }
    
    @media (max-width: 991.98px) {
        .position-sticky {
            position: static !important;
            margin-top: 2rem;
        }
        
        .col-lg-8 {
            order: 1;
        }
        
        .col-lg-4 {
            order: 2;
        }
    }
    
    @media (max-width: 767.98px) {
        .cart-item .row > div {
            margin-bottom: 0.5rem;
        }
        
        .cart-item .col-md-2:last-child {
            text-align: center !important;
        }
        
        .cart-item .col-md-2 {
            margin-bottom: 0.75rem;
        }
        
        .cart-item .col-md-4 {
            margin-bottom: 0.5rem;
        }
        
        .input-group-sm {
            width: 100%;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .display-5 {
            font-size: 1.75rem;
        }
        
        .lead {
            font-size: 1rem;
        }
    }
</style>
@endpush