@extends('customer.layouts.app')

@section('title', $pageTitle)

@section('content')
<!-- Page Header -->
<section class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-dark">Keranjang Belanja</h1>
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
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
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
        
        // Get cart items (no duplicates by ID)
        getCartItems() {
            const rawCart = JSON.parse(localStorage.getItem('cart') || '[]');
            const uniqueItems = {};
            
            // Consolidate duplicate IDs
            rawCart.forEach(item => {
                if (uniqueItems[item.id]) {
                    uniqueItems[item.id].quantity += (item.quantity || 1);
                } else {
                    uniqueItems[item.id] = {
                        id: item.id,
                        name: item.name || `Produk ${item.id}`,
                        price: item.price || 20000,
                        description: item.description || 'Produk berkualitas premium',
                        quantity: item.quantity || 1
                    };
                }
            });
            
            return Object.values(uniqueItems);
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
            
            // Render cart items (no need to group since cart is already unique)
            cartList.innerHTML = this.cart.map(item => `
                <div class="cart-item border-bottom py-3" data-id="${item.id}">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="ratio ratio-1x1">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 150 150' fill='none'%3E%3Crect width='150' height='150' fill='%23f8f9fa' rx='8'/%3E%3Crect x='25' y='40' width='100' height='70' fill='%23dc3545' fill-opacity='0.2' rx='5'/%3E%3Ctext x='75' y='80' text-anchor='middle' fill='%23dc3545' font-family='Arial' font-size='14' font-weight='bold'%3EImg%3C/text%3E%3C/svg%3E" 
                                     class="img-fluid rounded" alt="${item.name}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">${item.name || 'Produk'}</h6>
                            <p class="text-muted small mb-0">${item.description || 'Produk berkualitas premium'}</p>
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="fw-bold">Rp ${(item.price || 0).toLocaleString('id-ID')}</span>
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
                                <span class="fw-bold text-primary">Rp ${((item.price || 0) * item.quantity).toLocaleString('id-ID')}</span>
                                <button class="btn btn-outline-danger btn-sm mt-1" onclick="cart.removeItem(${item.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            
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
            const subtotal = this.cart.reduce((sum, item) => sum + ((item.price || 0) * item.quantity), 0);
            
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
                // Add new item
                this.cart.push({
                    id: product.id,
                    name: product.name || `Produk ${product.id}`,
                    price: product.price || 20000,
                    description: product.description || 'Produk berkualitas premium',
                    quantity: product.quantity || 1
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
    
    .input-group-sm .form-control {
        font-size: 0.875rem;
    }
    
    .position-sticky {
        top: 2rem !important;
    }
    
    @media (max-width: 768px) {
        .cart-item .row > div {
            margin-bottom: 0.5rem;
        }
        
        .cart-item .col-md-2:last-child {
            text-align: center !important;
        }
    }
</style>
@endpush