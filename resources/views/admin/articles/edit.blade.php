@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-attribute="quote"],
        trix-toolbar [data-trix-action="decreaseNestingLevel"],
        trix-toolbar [data-trix-action="increaseNestingLevel"],
        trix-toolbar [data-trix-action="attachFiles"] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start">
                        <h4 class="c-grey-900 mB-0">Edit Artikel</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-secondary me-2">
                            <i class="ti-arrow-left me-1"></i>Kembali
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
                <form id="articleFormEdit" action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white">Konten Artikel</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="title"
                                               class="form-control @error('title') is-invalid @enderror"
                                               value="{{ old('title', $article->title) }}"
                                               maxlength="200"
                                               required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text"
                                               name="slug"
                                               class="form-control @error('slug') is-invalid @enderror"
                                               value="{{ old('slug', $article->slug) }}"
                                               placeholder="Akan di-generate otomatis jika kosong">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Slug SEO friendly. Mengubah slug setelah artikel tayang bisa mempengaruhi SEO.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Excerpt (Ringkasan)</label>
                                        <textarea name="excerpt"
                                                  class="form-control @error('excerpt') is-invalid @enderror"
                                                  rows="3"
                                                  maxlength="250">{{ old('excerpt', $article->excerpt) }}</textarea>
                                        @error('excerpt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block excerpt-help">
                                            Ringkasan singkat untuk meta description & daftar artikel (maks. 250 karakter).
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <input type="text"
                                               name="category"
                                               class="form-control @error('category') is-invalid @enderror"
                                               value="{{ old('category', $article->category) }}"
                                               maxlength="100"
                                               placeholder="Contoh: Tips, Edukasi, Promo">
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label d-block">Konten</label>
                                        <input id="article-content-input"
                                               type="hidden"
                                               name="content"
                                               value="{{ old('content', $article->content) }}">
                                        <trix-editor input="article-content-input"
                                                     class="@error('content') is-invalid @enderror"></trix-editor>
                                        @error('content')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Publication -->
                            <div class="card mb-3">
                                <div class="card-header bg-success">
                                    <h5 class="mb-0 text-white">Publikasi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Status</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="status"
                                                   id="status-draft"
                                                   value="draft"
                                                   {{ old('status', $article->status) === 'draft' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-draft">Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="status"
                                                   id="status-published"
                                                   value="published"
                                                   {{ old('status', $article->status) === 'published' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-published">Publish</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Publish Date</label>
                                        <input type="datetime-local"
                                               name="publish_date"
                                               class="form-control @error('publish_date') is-invalid @enderror"
                                               value="{{ old('publish_date', optional($article->publish_date)->format('Y-m-d\TH:i')) }}">
                                        @error('publish_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block">
                                            Artikel hanya tampil jika status <strong>Published</strong> dan tanggal publish &le; sekarang.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Author -->
                            <div class="card mb-3">
                                <div class="card-header bg-info">
                                    <h5 class="mb-0 text-white">Author</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Author</label>
                                        <input type="text"
                                               name="author_name"
                                               class="form-control @error('author_name') is-invalid @enderror"
                                               value="{{ old('author_name', $article->author_name) }}"
                                               maxlength="255">
                                        @error('author_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnail -->
                            <div class="card mb-3">
                                <div class="card-header bg-warning">
                                    <h5 class="mb-0 text-white">Thumbnail</h5>
                                </div>
                                <div class="card-body">
                                    @if($article->thumbnail)
                                        <div class="mb-2">
                                            <label class="form-label d-block">Thumbnail Saat Ini</label>
                                            <img src="{{ storage_url($article->thumbnail) }}"
                                                 alt="{{ $article->title }}"
                                                 style="width: 100%; max-width: 260px; height: auto; border-radius: 4px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Ganti Thumbnail (opsional)</label>
                                        <input type="file"
                                               name="thumbnail"
                                               class="form-control @error('thumbnail') is-invalid @enderror"
                                               accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block">
                                            Jika diisi, thumbnail lama akan diganti. Maksimal 2MB.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-save me-2"></i>Simpan Perubahan
                                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        (function () {
            const form = document.getElementById('articleFormEdit');
            if (!form) return;

            const thumbnailInput = form.querySelector('input[name="thumbnail"]');
            const MAX_SIZE = 2 * 1024 * 1024; // 2MB

            if (thumbnailInput) {
                thumbnailInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    const feedbackSelector = '.thumbnail-size-feedback';
                    let feedback = this.closest('.mb-3')?.querySelector(feedbackSelector);

                    if (!file) {
                        this.classList.remove('is-invalid');
                        if (feedback) feedback.remove();
                        return;
                    }

                    if (file.size > MAX_SIZE) {
                        this.value = '';
                        this.classList.add('is-invalid');

                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback d-block thumbnail-size-feedback';
                            this.closest('.mb-3').appendChild(feedback);
                        }

                        feedback.textContent = 'Ukuran file melebihi 2MB. Silakan pilih gambar yang lebih kecil.';
                    } else {
                        this.classList.remove('is-invalid');
                        if (feedback) feedback.remove();
                    }
                });
            }

            const excerptInput = form.querySelector('textarea[name="excerpt"]');
            if (excerptInput) {
                const MAX_EXCERPT = 250;
                const help = excerptInput.closest('.mb-3')?.querySelector('.excerpt-help');

                const updateExcerptState = () => {
                    const length = excerptInput.value.length;
                    if (help) {
                        help.textContent = `Ringkasan singkat untuk meta description & daftar artikel (maks. ${MAX_EXCERPT} karakter). (${length}/${MAX_EXCERPT})`;
                    }

                    if (length > MAX_EXCERPT) {
                        excerptInput.value = excerptInput.value.slice(0, MAX_EXCERPT);
                    }
                };

                excerptInput.addEventListener('input', updateExcerptState);
                updateExcerptState();
            }
        })();
    </script>
@endpush

