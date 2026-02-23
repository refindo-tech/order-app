@extends('admin.layouts.app')

@section('title', 'Tambah Voucher')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Tambah Voucher</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary"><i class="ti-arrow-left me-2"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="bgc-white bd bdrs-3 p-20">
                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Voucher <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Diskon <span class="text-danger">*</span></label>
                            <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                                <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Persen (%)</option>
                                <option value="nominal" {{ old('discount_type') === 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('discount_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
                            <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}" min="0" step="0.01" required>
                            @error('discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">
                                - Untuk tipe <strong>Persen</strong>, isi angka 1–100 (mis. 10).</br>
                                - Untuk tipe <strong>Nominal</strong>, isi nilai Rupiah tanpa titik/koma (mis. 20000).
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="ti-save me-2"></i>Simpan Voucher</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
