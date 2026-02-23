@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
@push('styles')
    <style>
        /* .btn-article-action {
            font-size: 11px;
            padding: 2px 6px;
        }

        .btn-article-action i {
            font-size: 11px;
        } */
    </style>
@endpush

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-20">Manajemen Artikel</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                            <i class="ti-plus me-2"></i>Tambah Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <form method="GET" action="{{ route('admin.articles.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari judul..."
                               value="{{ $currentSearch }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category }}" {{ ($currentCategory ?? '') === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <!-- <div class="col-md-2">
                        <input type="text"
                               name="author"
                               class="form-control"
                               placeholder="Author..."
                               value="{{ $currentAuthor }}">
                    </div> -->
                    <div class="col-md-2">
                        <input type="date"
                               name="date_from"
                               class="form-control"
                               value="{{ $currentDateFrom }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date"
                               name="date_to"
                               class="form-control"
                               value="{{ $currentDateTo }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Articles Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Thumbnail</th>
                                <th class="text-center">Judul</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Author</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal Publish</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td>
                                    @if($article->thumbnail)
                                        <img src="{{ storage_url($article->thumbnail) }}"
                                             alt="{{ $article->title }}"
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width:60px;height:60px;border-radius:4px;background:#f8f9fa;display:flex;align-items:center;justify-content:center;color:#dc3545;font-size:11px;">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $article->title }}</strong>
                                    <div class="text-muted small">
                                        {{ $article->slug }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ $article->category ?? '-' }}
                                </td>
                                <td>{{ $article->author_name ?? '-' }}</td>
                                <td>
                                    @if($article->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($article->publish_date)
                                        <span class="d-block">{{ $article->publish_date->format('d/m/Y H:i') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $article->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                                        <div class="me-2">
                                            <a href="{{ route('admin.articles.show', $article) }}"
                                            class="btn btn-sm btn-primary btn-article-action"
                                            title="Detail">
                                                <i class="ti-eye me-1"></i><span>Detail</span>
                                            </a>
                                        </div>
                                        <div class="me-2">
                                            <a href="{{ route('admin.articles.edit', $article) }}"
                                            class="btn btn-sm btn-warning btn-article-action text-black"
                                            title="Edit">
                                                <i class="ti-pencil me-1"></i><span>Edit</span>
                                            </a>
                                        </div>
                                        <form action="{{ route('admin.articles.destroy', $article) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <div class="me-2">
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger btn-article-action"
                                                        title="Hapus">
                                                    <i class="ti-trash me-1"></i><span>Hapus</span>
                                                </button>
                                            </div>
                                        </form>
                                        @if($article->status === 'draft')
                                            <form action="{{ route('admin.articles.publish', $article) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Publish artikel ini sekarang?');">
                                                @csrf
                                                <div class="me-2">
                                                    <button type="submit"
                                                            class="btn btn-sm btn-success btn-article-action"
                                                            title="Go Publish">
                                                        <i class="ti-check me-1"></i><span>Go Publish</span>
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.articles.draft', $article) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Ubah artikel ini menjadi draft? Artikel tidak akan tampil di website.');">
                                                @csrf
                                                <div class="me-2">
                                                    <button type="submit"
                                                            class="btn btn-sm btn-secondary btn-article-action"
                                                            title="Set Draft">
                                                        <i class="ti-close me-1"></i><span>Set Draft</span>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada artikel.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

