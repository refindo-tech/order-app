@extends('customer.layouts.app')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('og')
    <meta property="og:title" content="{{ $article->title }} - {{ config('app.name') }}">
    <meta property="og:description" content="{{ $article->excerpt ?: $article->title }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($article->thumbnail)
        <meta property="og:image" content="{{ storage_url($article->thumbnail) }}">
    @else
        <meta property="og:image" content="{{ asset(config('constants.company.logo', 'images/rumah-bumbu-ungkep.png')) }}">
    @endif
@endsection

@section('content')
<section class="bg-light py-4 py-md-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('articles.index') }}" class="text-decoration-none">Artikel</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $article->title }}
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <article class="bg-white p-3 p-md-4 rounded-3 shadow-sm">
                    <h1 class="h1 fw-bold mb-3">{{ $article->title }}</h1>
                    @if($article->thumbnail)
                        <div class="mb-3 mb-md-4">
                            <img src="{{ storage_url($article->thumbnail) }}"
                                 alt="{{ $article->title }}"
                                 class="img-fluid rounded-3 w-100"
                                 style="max-height: 420px; object-fit: cover;">
                        </div>
                    @endif

                    <header class="mb-3 mb-md-4">
                        <div class="d-flex flex-wrap align-items-center text-muted small gap-2 mb-2">
                            @if($article->category)
                                <span class="badge bg-primary text-white">
                                    {{ $article->category }}
                                </span>
                            @endif
                            <span>
                                <i class="bi bi-person me-1"></i>{{ $article->author_name ?: 'Admin' }}
                            </span>
                            @if($article->publish_date)
                            <span>•</span>
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>{{ $article->publish_date->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                    </header>

                    <hr>

                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                @if($relatedArticles->count() > 0)
                    <div class="bg-white p-3 p-md-4 rounded-3 shadow-sm">
                        <h5 class="fw-bold mb-3">Baca Artikel Kami Lainnya</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach($relatedArticles as $rel)
                                <li class="mb-3">
                                    <a href="{{ route('articles.show', $rel) }}" class="text-decoration-none d-block">
                                        <div class="d-flex">
                                            @if($rel->thumbnail)
                                                <img src="{{ storage_url($rel->thumbnail) }}"
                                                     alt="{{ $rel->title }}"
                                                     class="rounded me-2 align-self-center"
                                                     style="width: 64px; height: 64px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="fw-semibold mb-1 text-dark">
                                                    {{ $rel->title }}
                                                </div>
                                                <div class="mb-1 d-flex flex-wrap gap-1 align-items-center">
                                                    @if($rel->category)
                                                        <span class="badge bg-primary text-white">
                                                            {{ $rel->category }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($rel->excerpt)
                                                    <small class="text-muted">
                                                        {{ Str::limit($rel->excerpt, 40, '...') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

