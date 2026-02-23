@extends('admin.layouts.app')

@section('title', 'Detail Artikel')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6 d-flex align-items-center">
                        <h4 class="c-grey-900 mB-0">Detail Artikel</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary me-2">
                            <i class="ti-arrow-left me-1"></i>Kembali
                        </a>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning text-black">
                            <i class="ti-pencil me-2"></i>Edit Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Content -->
    <div class="row">
        <div class="col-md-8">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h3 class="mB-10">{{ $article->title }}</h3>
                <div class="text-muted mB-20">
                    <span class="mR-10">
                        <i class="ti-user mR-5"></i>{{ $article->author_name ?: 'Admin' }}
                    </span>
                    @if($article->publish_date)
                        <span class="mR-10">
                            <i class="ti-calendar mR-5"></i>{{ $article->publish_date->format('d M Y H:i') }}
                        </span>
                    @endif
                    <span>
                        @if($article->status === 'published')
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </span>
                </div>

                <hr>

                <div class="article-content">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="mB-15">Info Artikel</h5>
                <p class="mB-5"><strong>Slug:</strong><br>{{ $article->slug }}</p>
                <p class="mB-5"><strong>Status:</strong><br>
                    @if($article->status === 'published')
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </p>
                <p class="mB-5"><strong>Tanggal Publish:</strong><br>
                    {{ $article->publish_date ? $article->publish_date->format('d/m/Y H:i') : '-' }}
                </p>
                <p class="mB-5"><strong>Dibuat:</strong><br>
                    {{ $article->created_at->format('d/m/Y H:i') }}
                </p>
                <p class="mB-5"><strong>Diperbarui:</strong><br>
                    {{ $article->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="bgc-white bd bdrs-3 p-20">
                <h5 class="mB-15">Thumbnail</h5>
                @if($article->thumbnail)
                    <img src="{{ storage_url($article->thumbnail) }}"
                         alt="{{ $article->title }}"
                         class="img-fluid bdrs-3">
                @else
                    <p class="text-muted mB-0">Belum ada thumbnail.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

