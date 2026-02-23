@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Tambah Produk Baru</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <form id="productFormCreate" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white">Informasi Dasar</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" 
                                               name="slug" 
                                               class="form-control @error('slug') is-invalid @enderror" 
                                               value="{{ old('slug') }}"
                                               placeholder="Akan di-generate otomatis jika kosong">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">URL-friendly identifier (opsional)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Singkat</label>
                                        <textarea name="description" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Lengkap</label>
                                        <textarea name="long_description" 
                                                  class="form-control @error('long_description') is-invalid @enderror" 
                                                  rows="5">{{ old('long_description') }}</textarea>
                                        @error('long_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mb-3">
                                <div class="card-header bg-success">
                                    <h5 class="mb-0 text-white">Harga</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   name="price" 
                                                   class="form-control @error('price') is-invalid @enderror" 
                                                   value="{{ old('price') }}" 
                                                   min="0" 
                                                   step="100" 
                                                   required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga Normal (Rp)</label>
                                            <input type="number"
                                                   name="normal_price"
                                                   class="form-control @error('normal_price') is-invalid @enderror"
                                                   value="{{ old('normal_price') }}"
                                                   min="0"
                                                   step="100"
                                                   placeholder="Opsional, untuk tampilan coret di customer">
                                            @error('normal_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12"><hr class="my-2"><small class="text-muted">Harga Grosir (opsional)</small></div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Minimal Grosir (qty)</label>
                                            <input type="number"
                                                   name="minimal_grosir"
                                                   class="form-control @error('minimal_grosir') is-invalid @enderror"
                                                   value="{{ old('minimal_grosir') }}"
                                                   min="2"
                                                   step="1"
                                                   placeholder="Contoh: 5">
                                            @error('minimal_grosir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Min. 2. Kosongkan untuk non-grosir.</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga Grosir (Rp/unit)</label>
                                            <input type="number"
                                                   name="harga_grosir"
                                                   class="form-control @error('harga_grosir') is-invalid @enderror"
                                                   value="{{ old('harga_grosir') }}"
                                                   min="0"
                                                   step="100"
                                                   placeholder="Harus &lt; Harga">
                                            @error('harga_grosir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Harus lebih rendah dari Harga. Kosongkan untuk non-grosir.</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Berat (gram) <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   name="weight" 
                                                   class="form-control @error('weight') is-invalid @enderror" 
                                                   value="{{ old('weight', 0) }}" 
                                                   min="0" 
                                                   required>
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="category" 
                                                   class="form-control @error('category') is-invalid @enderror" 
                                                   value="{{ old('category', 'Bumbu Masak') }}" 
                                                   list="categories" 
                                                   required>
                                            <datalist id="categories">
                                                <option value="Bumbu Masak">
                                                <option value="Ungkep">
                                                <option value="Bumbu Instan">
                                            </datalist>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-info">
                                    <h5 class="mb-0 text-white">Informasi Tambahan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Komposisi (pisahkan dengan koma)</label>
                                        <input type="text" 
                                               name="ingredients_input" 
                                               class="form-control" 
                                               value="{{ old('ingredients_input') }}"
                                               placeholder="Contoh: Cabai merah; Bawang merah; Bawang putih">
                                        <small class="text-muted">Pisahkan tiap komposisi dengan titik koma (;)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cara Pakai</label>
                                        <textarea name="usage"
                                                  rows="4"
                                                  class="form-control @error('usage') is-invalid @enderror"
                                                  placeholder="Pisahkan tiap langkah dengan titik koma (;)">{{ old('usage') }}</textarea>
                                        <small class="text-muted">Pisahkan tiap langkah dengan titik koma (;)</small>
                                        @error('usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Masa Simpan</label>
                                        <input type="text" 
                                               name="shelf_life" 
                                               class="form-control @error('shelf_life') is-invalid @enderror" 
                                               value="{{ old('shelf_life') }}"
                                               placeholder="Contoh: 6 bulan">
                                        @error('shelf_life')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kategori Tambahan (opsional)</label>
                                        <input type="text" 
                                               name="extra_categories_input" 
                                               class="form-control"
                                               value="{{ old('extra_categories_input') }}"
                                               placeholder="Contoh: Pedas; Premium; Best Seller">
                                        <small class="text-muted">Pisahkan tiap kategori tambahan dengan titik koma (;)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Kelola Foto/Video (maks. 4) -->
                            <div class="card mb-3">
                                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Kelola Foto/Video</h5>
                                    <span id="mediaCount" class="badge bg-dark">0/4</span>
                                </div>
                                <div class="card-body">
                                    <div id="mediaPreview" class="row g-2 mb-3">
                                        <div id="mediaPreviewEmpty" class="col-12 text-center py-4 bg-light rounded border text-muted small">
                                            Belum ada file. Klik "Tambah Foto/Video" untuk menambah.
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <input type="file"
                                               name="media[]"
                                               id="mediaInput"
                                               class="d-none @error('media') is-invalid @enderror @error('media.*') is-invalid @enderror"
                                               accept="image/*,video/mp4,video/webm,video/ogg,video/quicktime"
                                               multiple>
                                        <button type="button" class="btn btn-warning w-100" id="btnAddMedia">
                                            <i class="ti-plus me-2"></i>Tambah Foto/Video
                                        </button>
                                        @error('media')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @error('media.*')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">Format: gambar (JPG, PNG, GIF, WebP) atau video (MP4, WebM). Maksimal 4 file. Gunakan tombol ↑ dan ↓ di bawah untuk mengatur urutan tampilan.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Voucher (multi select) -->
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Voucher Diskon</h5>
                                </div>
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Pilih voucher yang berlaku untuk produk ini (bisa lebih dari satu).</small>
                                    @forelse($vouchers ?? [] as $v)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="voucher_ids[]" value="{{ $v->id }}" id="voucher_{{ $v->id }}" {{ in_array($v->id, old('voucher_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="voucher_{{ $v->id }}">
                                            <strong>{{ $v->name }}:</strong> {{ $v->discount_label }} ({{ $v->start_date->format('d/m/y') }}-{{ $v->end_date->format('d/m/y') }})
                                        </label>
                                    </div>
                                    @empty
                                    <p class="text-muted small mb-0">Belum ada voucher. <a href="{{ route('admin.vouchers.create') }}">Buat voucher</a> dulu.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="card mb-3">
                                <div class="card-header bg-secondary">
                                    <h5 class="mb-0 text-white">Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="is_active" 
                                               id="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Produk Aktif
                                        </label>
                                    </div>
                                    <small class="text-muted">Produk aktif akan ditampilkan di katalog customer</small>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary w-100 mb-2">
                                        <i class="ti-save me-2"></i>Simpan Produk
                                    </button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                                        <i class="ti-close me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        var selectedMediaFiles = [];
        var input = document.getElementById('mediaInput');
        var container = document.getElementById('mediaPreview');
        var emptyEl = document.getElementById('mediaPreviewEmpty');
        var countBadge = document.getElementById('mediaCount');

        function setInputFromArray() {
            if (!input) return;
            var dt = new DataTransfer();
            for (var i = 0; i < selectedMediaFiles.length; i++) dt.items.add(selectedMediaFiles[i]);
            input.files = dt.files;
        }

        function renderPreview() {
            if (!container) return;
            if (selectedMediaFiles.length === 0) {
                if (emptyEl) { emptyEl.style.display = ''; emptyEl.textContent = 'Belum ada file. Klik "Tambah Foto/Video Lain" untuk menambah.'; }
                container.querySelectorAll('.media-preview-item').forEach(function(el) { el.remove(); });
                if (countBadge) countBadge.textContent = '0/4';
                return;
            }
            if (emptyEl) emptyEl.style.display = 'none';
            container.querySelectorAll('.media-preview-item').forEach(function(el) { el.remove(); });
            if (countBadge) countBadge.textContent = selectedMediaFiles.length + '/4';
            var n = selectedMediaFiles.length;
            selectedMediaFiles.forEach(function(file, i) {
                var col = document.createElement('div');
                col.className = 'col-6 media-preview-item';
                var wrap = document.createElement('div');
                wrap.className = 'rounded border overflow-hidden bg-dark position-relative';
                wrap.style.maxHeight = '160px';
                if (file.type.startsWith('video/')) {
                    var video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.muted = true;
                    video.className = 'img-fluid w-100';
                    video.style.maxHeight = '140px'; video.style.objectFit = 'cover';
                    wrap.appendChild(video);
                } else {
                    var img = document.createElement('img');
                    img.className = 'img-fluid w-100';
                    img.style.maxHeight = '140px'; img.style.objectFit = 'cover';
                    img.alt = 'Preview ' + (i + 1);
                    var reader = new FileReader();
                    reader.onload = (function(idx) { return function(e) { img.src = e.target.result; }; })(i);
                    reader.readAsDataURL(file);
                    wrap.appendChild(img);
                }
                var ctrls = document.createElement('div');
                ctrls.className = 'position-absolute top-0 start-0 d-flex gap-1 m-1';
                ctrls.style.zIndex = '5';
                var btnDel = document.createElement('button');
                btnDel.type = 'button';
                btnDel.className = 'btn btn-danger py-2 px-2';
                btnDel.style.minWidth = '36px';
                btnDel.style.fontSize = '1.1rem';
                btnDel.title = 'Hapus';
                btnDel.innerHTML = '&times;';
                btnDel.onclick = (function(idx) { return function() { removeAt(idx); }; })(i);
                var btnUp = document.createElement('button');
                btnUp.type = 'button';
                btnUp.className = 'btn btn-light py-2 px-2';
                btnUp.style.minWidth = '36px';
                btnUp.style.fontSize = '1.1rem';
                btnUp.title = 'Pindah ke atas';
                btnUp.innerHTML = '&uarr;';
                btnUp.onclick = (function(idx) { return function() { moveUp(idx); }; })(i);
                var btnDown = document.createElement('button');
                btnDown.type = 'button';
                btnDown.className = 'btn btn-light py-2 px-2';
                btnDown.style.minWidth = '36px';
                btnDown.style.fontSize = '1.1rem';
                btnDown.title = 'Pindah ke bawah';
                btnDown.innerHTML = '&darr;';
                btnDown.onclick = (function(idx) { return function() { moveDown(idx); }; })(i);
                ctrls.appendChild(btnDel);
                ctrls.appendChild(btnUp);
                ctrls.appendChild(btnDown);
                wrap.appendChild(ctrls);
                var badge = document.createElement('span');
                badge.className = 'position-absolute top-0 end-0 badge bg-secondary m-1';
                badge.textContent = (i + 1) + '/' + n;
                wrap.appendChild(badge);
                col.appendChild(wrap);
                container.appendChild(col);
            });
        }

        function removeAt(index) {
            if (index < 0 || index >= selectedMediaFiles.length) return;
            selectedMediaFiles.splice(index, 1);
            setInputFromArray();
            renderPreview();
        }

        function moveUp(index) {
            if (index <= 0) return;
            var t = selectedMediaFiles[index];
            selectedMediaFiles[index] = selectedMediaFiles[index - 1];
            selectedMediaFiles[index - 1] = t;
            setInputFromArray();
            renderPreview();
        }

        function moveDown(index) {
            if (index >= selectedMediaFiles.length - 1) return;
            var t = selectedMediaFiles[index];
            selectedMediaFiles[index] = selectedMediaFiles[index + 1];
            selectedMediaFiles[index + 1] = t;
            setInputFromArray();
            renderPreview();
        }

        function onInputChange() {
            if (!input.files || input.files.length === 0) return;
            var newFiles = Array.from(input.files);
            selectedMediaFiles = selectedMediaFiles.concat(newFiles).slice(0, 4);
            setInputFromArray();
            renderPreview();
            input.value = '';
        }

        document.getElementById('btnAddMedia').addEventListener('click', function() {
            if (selectedMediaFiles.length >= 4) { alert('Maksimal 4 file.'); return; }
            input.click();
        });
        input.addEventListener('change', onInputChange);

        var form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!form.reportValidity()) return;
                var formData = new FormData();
                for (var i = 0; i < form.elements.length; i++) {
                    var el = form.elements[i];
                    if (!el.name || el.name === 'media[]') continue;
                    if (el.type === 'file') continue;
                    if (el.type === 'checkbox' && !el.checked) continue;
                    if (el.type === 'radio' && !el.checked) continue;
                    formData.append(el.name, el.value);
                }
                selectedMediaFiles.forEach(function(f) { formData.append('media[]', f); });
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'; }
                fetch(form.action, { method: 'POST', body: formData, credentials: 'same-origin', redirect: 'follow' })
                    .then(function(r) {
                        if (r.redirected) { window.location = r.url; return; }
                        if (r.status === 422) return r.json().then(function(data) {
                            if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = '<i class="ti-save me-2"></i>Simpan Produk'; }
                            var msg = (data.errors && Object.values(data.errors).flat()) ? Object.values(data.errors).flat().join('\n') : 'Validasi gagal';
                            alert(msg);
                        });
                        return r.text().then(function(html) { document.open(); document.write(html); document.close(); });
                    })
                    .catch(function(err) {
                        if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = '<i class="ti-save me-2"></i>Simpan Produk'; }
                        alert('Gagal menyimpan: ' + (err && err.message ? err.message : 'Unknown error'));
                    });
            });
        }
    })();
</script>
@endpush