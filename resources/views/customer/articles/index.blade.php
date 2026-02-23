@extends('customer.layouts.app')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('content')
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-dark mb-3">Artikel Kami</h1>
                <p class="lead text-muted mb-0">
                    Baca tips, inspirasi, dan edukasi seputar bumbu, masakan, dan kebutuhan dapur Anda.
                </p>
            </div>
            <div class="col-lg-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Artikel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Search & Filters -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" action="{{ route('articles.index') }}" class="row g-2">
                    <div class="col-sm-6 col-md-7">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari artikel..."
                               value="{{ $currentSearch ?? '' }}">
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category }}" {{ ($currentCategory ?? '') === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($articles->count() === 0)
            <div class="text-center py-5">
                <h3 class="fw-bold mb-3">Belum ada artikel</h3>
                <p class="text-muted mb-0">Nantikan konten menarik dari kami.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($articles as $article)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if($article->thumbnail)
                                <a href="{{ route('articles.show', $article) }}">
                                    <img src="{{ storage_url($article->thumbnail) }}"
                                         class="card-img-top"
                                         alt="{{ $article->title }}"
                                         style="height: 200px; object-fit: cover;">
                                </a>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                                    <span class="badge bg-light text-muted border">
                                        {{ $article->publish_date?->format('d M Y') ?? '' }}
                                    </span>
                                    @if($article->category)
                                        <span class="badge bg-primary text-white">
                                            {{ $article->category }}
                                        </span>
                                    @endif
                                </div>
                                <h5 class="card-title mb-2">
                                    <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                @if($article->excerpt)
                                    <p class="card-text text-muted mb-3" style="min-height: 60px;">
                                        {{ Str::limit($article->excerpt, 150) }}
                                    </p>
                                @endif
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ $article->author_name ?: 'Admin' }}
                                    </small>
                                    <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        Baca <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

