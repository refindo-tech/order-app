@extends('admin.layouts.app')

@section('title', 'Manajemen Voucher')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-20">Manajemen Voucher</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">
                            <i class="ti-plus me-2"></i>Tambah Voucher
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <form method="GET" action="{{ route('admin.vouchers.index') }}" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama voucher..." value="{{ $currentSearch }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti-search me-2"></i>Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vouchers as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td><strong>{{ $v->name }}</strong></td>
                                <td>{{ $v->discount_type === 'percent' ? 'Persen' : 'Nominal' }}</td>
                                <td>
                                    @if($v->discount_type === 'percent')
                                        {{ number_format($v->discount_value, 0) }}%
                                    @else
                                        Rp {{ number_format($v->discount_value, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $v->start_date->format('d/m/Y') }} - {{ $v->end_date->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    @php $now = now(); @endphp
                                    @if($now->between($v->start_date, $v->end_date))
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($v->start_date > $now)
                                        <span class="badge bg-info">Belum mulai</span>
                                    @else
                                        <span class="badge bg-secondary">Kadaluarsa</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.vouchers.show', $v) }}" class="btn btn-sm btn-primary">Detail</a>
                                    <a href="{{ route('admin.vouchers.edit', $v) }}" class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.vouchers.destroy', $v) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus voucher ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada voucher.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
