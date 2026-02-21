@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Edit Produk: {{ $product->name }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
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
                <form id="productFormEdit" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
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
                                               value="{{ old('name', $product->name) }}"
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
                                               value="{{ old('slug', $product->slug) }}"
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
                                                  rows="3">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Lengkap</label>
                                        <textarea name="long_description"
                                                  class="form-control @error('long_description') is-invalid @enderror"
                                                  rows="5">{{ old('long_description', $product->long_description) }}</textarea>
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
                                                   value="{{ old('price', $product->price) }}"
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
                                                   value="{{ old('normal_price', $product->normal_price) }}"
                                                   min="0"
                                                   step="100"
                                                   placeholder="Opsional, untuk tampilan coret di customer">
                                            @error('normal_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Berat (gram) <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   name="weight"
                                                   class="form-control @error('weight') is-invalid @enderror"
                                                   value="{{ old('weight', $product->weight) }}"
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
                                                   value="{{ old('category', $product->category) }}"
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
                                               value="{{ old('ingredients_input', is_array($product->ingredients) ? implode(', ', $product->ingredients) : $product->ingredients) }}"
                                               placeholder="Contoh: Cabai merah, Bawang merah, Bawang putih">
                                        <small class="text-muted">Akan dikonversi menjadi array</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cara Pakai</label>
                                        <input type="text"
                                               name="usage"
                                               class="form-control @error('usage') is-invalid @enderror"
                                               value="{{ old('usage', $product->usage) }}"
                                               placeholder="Contoh: 1 pack untuk 1 kg daging sapi">
                                        @error('usage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Masa Simpan</label>
                                        <input type="text"
                                               name="shelf_life"
                                               class="form-control @error('shelf_life') is-invalid @enderror"
                                               value="{{ old('shelf_life', $product->shelf_life) }}"
                                               placeholder="Contoh: 6 bulan">
                                        @error('shelf_life')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                    <span id="mediaCount" class="badge bg-dark">{{ $product->media->count() }}/4</span>
                                </div>
                                <div class="card-body">
                                    <div id="mediaOrderInputs">
                                        @foreach($product->media as $m)
                                            <input type="hidden" name="media_order[]" value="{{ $m->id }}">
                                        @endforeach
                                    </div>
                                    <div id="mediaList" class="row g-2 mb-2">
                                        @forelse($product->media as $m)
                                            <div class="col-6 existing-media-item" data-media-id="{{ $m->id }}">
                                                <div class="rounded border overflow-hidden bg-dark position-relative media-card" style="max-height: 160px;">
                                                    <input type="checkbox" name="remove_media[]" value="{{ $m->id }}" class="d-none remove-media-cb" id="remove_{{ $m->id }}">
                                                    <div class="position-absolute top-0 start-0 d-flex gap-1 m-1" style="z-index: 5;">
                                                        <button type="button" class="btn btn-danger btn-remove-existing py-2 px-2" data-media-id="{{ $m->id }}" title="Hapus" style="min-width: 36px; font-size: 1.1rem;">×</button>
                                                        <button type="button" class="btn btn-light btn-media-up py-2 px-2" title="Pindah ke atas" style="min-width: 36px; font-size: 1.1rem;">↑</button>
                                                        <button type="button" class="btn btn-light btn-media-down py-2 px-2" title="Pindah ke bawah" style="min-width: 36px; font-size: 1.1rem;">↓</button>
                                                    </div>
                                                    @if($m->isImage())
                                                        <img src="{{ storage_url($m->path) }}" alt="" class="img-fluid d-block w-100" style="max-height: 140px; object-fit: cover;">
                                                    @else
                                                        <video src="{{ storage_url($m->path) }}" class="img-fluid d-block w-100" style="max-height: 140px; object-fit: cover;" muted></video>
                                                    @endif
                                                    <span class="position-absolute bottom-0 end-0 badge bg-secondary m-1">Tersimpan</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div id="mediaListEmpty" class="col-12 text-center py-4 bg-light rounded border text-muted small">Belum ada media. Klik "Tambah Foto/Video" untuk menambah.</div>
                                        @endforelse
                                    </div>
                                    <div class="mb-0">
                                        <input type="file"
                                               name="media[]"
                                               id="mediaInput"
                                               class="d-none @error('media') is-invalid @enderror @error('media.*') is-invalid @enderror"
                                               accept="image/*,video/mp4,video/webm,video/ogg,video/quicktime"
                                               multiple>
                                        <button type="button" class="btn btn-warning w-100" id="btnAddMedia" @if($product->media->count() >= 4) disabled @endif>
                                            <i class="ti-plus me-2"></i>Tambah Foto/Video
                                        </button>
                                        @error('media')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @error('media.*')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">Klik "Tambah Foto/Video" untuk menambah. Gunakan ↑↓ untuk mengatur urutan dan × untuk menghapus. Maksimal 4 file.</small>
                                    </div>
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
                                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
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
                                        <i class="ti-save me-2"></i>Perbarui Produk
                                    </button>
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary w-100">
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
        var newFilesMap = {};
        var nextNewId = 0;
        var input = document.getElementById('mediaInput');
        var mediaList = document.getElementById('mediaList');
        var mediaListEmpty = document.getElementById('mediaListEmpty');
        var countBadge = document.getElementById('mediaCount');
        var orderContainer = document.getElementById('mediaOrderInputs');
        var btnAdd = document.getElementById('btnAddMedia');

        function getMediaItems() {
            if (!mediaList) return [];
            return Array.from(mediaList.children).filter(function(el) {
                return el.classList.contains('existing-media-item') || el.classList.contains('media-item-new');
            });
        }

        function rebuildMediaOrderInputs() {
            if (!orderContainer) return;
            var items = getMediaItems();
            var ids = [];
            items.forEach(function(el) {
                if (!el.classList.contains('existing-media-item')) return;
                var id = el.getAttribute('data-media-id');
                var cb = document.getElementById('remove_' + id);
                if (cb && !cb.checked) ids.push(id);
            });
            orderContainer.innerHTML = '';
            ids.forEach(function(id) {
                var inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'media_order[]';
                inp.value = id;
                orderContainer.appendChild(inp);
            });
        }

        function updateEditMediaCount() {
            if (!countBadge) return;
            var items = getMediaItems();
            var total = 0;
            items.forEach(function(el) {
                if (el.classList.contains('existing-media-item')) {
                    var cb = document.getElementById('remove_' + el.getAttribute('data-media-id'));
                    if (!cb || !cb.checked) total++;
                } else if (el.classList.contains('media-item-new')) total++;
            });
            countBadge.textContent = total + '/4';
            if (btnAdd) btnAdd.disabled = total >= 4;
            if (mediaListEmpty) mediaListEmpty.style.display = total > 0 ? 'none' : '';
        }

        function moveItem(item, direction) {
            if (!mediaList || !item) return;
            var items = getMediaItems();
            var idx = items.indexOf(item);
            if (idx < 0) return;
            var next = direction === 'up' ? idx - 1 : idx + 1;
            if (next < 0 || next >= items.length) return;
            if (direction === 'up') {
                mediaList.insertBefore(item, items[next]);
            } else {
                mediaList.insertBefore(item, items[next].nextSibling);
            }
            rebuildMediaOrderInputs();
        }

        function addNewFiles(files) {
            var items = getMediaItems();
            var kept = 0;
            items.forEach(function(el) {
                if (el.classList.contains('existing-media-item')) {
                    var cb = document.getElementById('remove_' + el.getAttribute('data-media-id'));
                    if (!cb || !cb.checked) kept++;
                } else if (el.classList.contains('media-item-new')) kept++;
            });
            var maxAdd = 4 - kept;
            if (maxAdd <= 0) return;
            var toAdd = Array.from(files).slice(0, maxAdd);
            toAdd.forEach(function(file) {
                var id = 'new_' + (nextNewId++);
                newFilesMap[id] = file;
                var col = document.createElement('div');
                col.className = 'col-6 media-item-new';
                col.setAttribute('data-new-id', id);
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
                    var reader = new FileReader();
                    reader.onload = function(e) { img.src = e.target.result; };
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
                btnDel.innerHTML = '&times;';
                btnDel.title = 'Hapus';
                btnDel.onclick = function() {
                    col.remove();
                    delete newFilesMap[id];
                    updateEditMediaCount();
                };
                var btnUp = document.createElement('button');
                btnUp.type = 'button';
                btnUp.className = 'btn btn-outline-light btn-media-up py-2 px-2';
                btnUp.style.minWidth = '36px';
                btnUp.style.fontSize = '1.1rem';
                btnUp.innerHTML = '&uarr;';
                btnUp.onclick = function() { moveItem(col, 'up'); };
                var btnDown = document.createElement('button');
                btnDown.type = 'button';
                btnDown.className = 'btn btn-outline-light btn-media-down py-2 px-2';
                btnDown.style.minWidth = '36px';
                btnDown.style.fontSize = '1.1rem';
                btnDown.innerHTML = '&darr;';
                btnDown.onclick = function() { moveItem(col, 'down'); };
                ctrls.appendChild(btnDel);
                ctrls.appendChild(btnUp);
                ctrls.appendChild(btnDown);
                wrap.appendChild(ctrls);
                var badge = document.createElement('span');
                badge.className = 'position-absolute top-0 end-0 badge bg-primary m-1';
                badge.textContent = 'Baru';
                wrap.appendChild(badge);
                col.appendChild(wrap);
                mediaList.appendChild(col);
            });
            if (mediaListEmpty) mediaListEmpty.style.display = 'none';
            updateEditMediaCount();
        }

        if (btnAdd) {
            btnAdd.addEventListener('click', function() {
                if (this.disabled) return;
                var total = getMediaItems().filter(function(el) {
                    if (el.classList.contains('existing-media-item')) {
                        var cb = document.getElementById('remove_' + el.getAttribute('data-media-id'));
                        return !cb || !cb.checked;
                    }
                    return true;
                }).length;
                if (total >= 4) { alert('Maksimal 4 file.'); return; }
                input.click();
            });
        }
        if (input) input.addEventListener('change', function() {
            if (!input.files || input.files.length === 0) return;
            addNewFiles(input.files);
            input.value = '';
        });

        document.querySelectorAll('.btn-remove-existing').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-media-id');
                var cb = document.getElementById('remove_' + id);
                var card = this.closest('.existing-media-item');
                if (cb && card) {
                    cb.checked = !cb.checked;
                    if (cb.checked) {
                        card.classList.add('opacity-50');
                        card.querySelector('.media-card').classList.add('border-danger');
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-secondary');
                        this.innerHTML = 'Batal';
                    } else {
                        card.classList.remove('opacity-50');
                        card.querySelector('.media-card').classList.remove('border-danger');
                        this.classList.add('btn-danger');
                        this.innerHTML = '×';
                    }
                    rebuildMediaOrderInputs();
                    updateEditMediaCount();
                }
            });
        });

        if (mediaList) {
            mediaList.addEventListener('click', function(e) {
                var up = e.target.closest('.btn-media-up');
                var down = e.target.closest('.btn-media-down');
                if (up) {
                    e.preventDefault();
                    e.stopPropagation();
                    var item = up.closest('.existing-media-item') || up.closest('.media-item-new');
                    if (item) moveItem(item, 'up');
                } else if (down) {
                    e.preventDefault();
                    e.stopPropagation();
                    var item = down.closest('.existing-media-item') || down.closest('.media-item-new');
                    if (item) moveItem(item, 'down');
                }
            });
        }

        var form = input && input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!form.reportValidity()) return;
                rebuildMediaOrderInputs();
                var formData = new FormData();
                for (var i = 0; i < form.elements.length; i++) {
                    var el = form.elements[i];
                    if (!el.name || el.name === 'media[]') continue;
                    if (el.type === 'file') continue;
                    if (el.type === 'checkbox' && !el.checked) continue;
                    if (el.type === 'radio' && !el.checked) continue;
                    formData.append(el.name, el.value);
                }
                var items = getMediaItems();
                items.forEach(function(el) {
                    if (el.classList.contains('media-item-new')) {
                        var fid = el.getAttribute('data-new-id');
                        if (newFilesMap[fid]) formData.append('media[]', newFilesMap[fid]);
                    }
                });
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'; }
                fetch(form.action, { method: 'POST', body: formData, credentials: 'same-origin', redirect: 'follow' })
                    .then(function(r) {
                        if (r.redirected) { window.location = r.url; return; }
                        if (r.status === 422) return r.json().then(function(data) {
                            if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = '<i class="ti-save me-2"></i>Perbarui Produk'; }
                            var msg = (data.errors && Object.values(data.errors).flat()) ? Object.values(data.errors).flat().join('\n') : 'Validasi gagal';
                            alert(msg);
                        });
                        return r.text().then(function(html) { document.open(); document.write(html); document.close(); });
                    })
                    .catch(function(err) {
                        if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = '<i class="ti-save me-2"></i>Perbarui Produk'; }
                        alert('Gagal menyimpan: ' + (err && err.message ? err.message : 'Unknown error'));
                    });
            });
        }
    })();
</script>
@endpush
