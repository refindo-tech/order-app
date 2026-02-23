@extends('admin.layouts.app')

@section('title', 'Banner Beranda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Banner Beranda</h4>
                        <p class="mB-0 c-grey-600">Ubah judul dan deskripsi banner di halaman depan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mB-20" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <form action="{{ route('admin.banner.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Judul Banner<span class="text-danger">*</span></label>
                        <textarea name="hero_title"
                                  id="hero_title"
                                  class="form-control @error('hero_title') is-invalid @enderror"
                                  rows="3"
                                  required
                                  maxlength="500"
                                  placeholder="Contoh: Harga Terjangkau,&#10;Rasa Juara">{{ old('hero_title', $banner->hero_title) }}</textarea>
                        @error('hero_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Teks yang ditampilkan besar di banner. Gunakan Enter untuk baris baru.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Banner</label>
                        <textarea name="hero_description"
                                  id="hero_description"
                                  class="form-control @error('hero_description') is-invalid @enderror"
                                  rows="4"
                                  maxlength="1000"
                                  placeholder="Supplier terpercaya untuk kebutuhan bumbu dapur dan ungkep berkualitas...">{{ old('hero_description', $banner->hero_description) }}</textarea>
                        @error('hero_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Teks di bawah judul banner (maks. 1000 karakter). Gunakan Enter untuk baris baru.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
