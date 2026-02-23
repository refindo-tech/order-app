@extends('admin.layouts.app')

@section('title', 'Produk Unggulan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Atur Produk Unggulan</h4>
                        <small class="text-muted">Pilih maksimal 4 produk untuk tampil di beranda sebagai produk unggulan.</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="ti-arrow-left me-2"></i>Kembali ke Manajemen Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Featured Products -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                @if($errors->has('featured_products'))
                    <div class="alert alert-danger">
                        <i class="ti-alert me-2"></i>{{ $errors->first('featured_products') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.products.featured.update') }}" method="POST" id="featuredProductsForm">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">Pilih</th>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="featured_products[]"
                                                   value="{{ $product->id }}"
                                                   class="form-check-input featured-checkbox"
                                                   {{ in_array($product->id, $featuredIds, true) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            <img src="{{ $product->image ? storage_url($product->image) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\' fill=\'none\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50\' y=\'55\' text-anchor=\'middle\' fill=\'%23dc3545\' font-family=\'Arial\' font-size=\'12\'%3ENo Image%3C/text%3E%3C/svg%3E' }}"
                                                 alt="{{ $product->name }}"
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td><strong>{{ $product->name }}</strong></td>
                                        <td>{{ $product->category ?: '-' }}</td>
                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            Belum ada produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Dipilih: <span id="featuredCount">{{ count($featuredIds) }}</span> / 4 produk.
                        </small>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti-save me-2"></i>Simpan Produk Unggulan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const checkboxes = document.querySelectorAll('.featured-checkbox');
        const counterEl = document.getElementById('featuredCount');
        const MAX_FEATURED = 4;

        function updateCount() {
            const count = Array.from(checkboxes).filter(cb => cb.checked).length;
            if (counterEl) {
                counterEl.textContent = count + ' / ' + MAX_FEATURED + ' produk.';
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const selected = Array.from(checkboxes).filter(x => x.checked);
                if (selected.length > MAX_FEATURED) {
                    this.checked = false;
                    alert('Maksimal hanya boleh memilih 4 produk unggulan.');
                }
                updateCount();
            });
        });

        updateCount();
    })();
</script>
@endpush

