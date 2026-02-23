@extends('admin.layouts.app')

@section('title', 'Detail Voucher')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-0">Detail Voucher: {{ $voucher->name }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="btn btn-primary me-2"><i class="ti-pencil me-2"></i>Edit</a>
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary"><i class="ti-arrow-left me-2"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h5 class="c-grey-900 mB-20">Informasi Voucher</h5>
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Nama</th>
                        <td>{{ $voucher->name }}</td>
                    </tr>
                    <tr>
                        <th>Tipe</th>
                        <td>{{ $voucher->discount_type === 'percent' ? 'Persen' : 'Nominal' }}</td>
                    </tr>
                    <tr>
                        <th>Nilai</th>
                        <td>
                            @if($voucher->discount_type === 'percent')
                                {{ number_format($voucher->discount_value, 0) }}%
                            @else
                                Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $voucher->start_date->format('d/m/Y H:i') }} - {{ $voucher->end_date->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @php $now = now(); @endphp
                            @if($now->between($voucher->start_date, $voucher->end_date))
                                <span class="badge bg-success">Aktif</span>
                            @elseif($voucher->start_date > $now)
                                <span class="badge bg-info">Belum mulai</span>
                            @else
                                <span class="badge bg-secondary">Kadaluarsa</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="bgc-white bd bdrs-3 p-20">
                <h5 class="c-grey-900 mB-20">Produk yang Memakai Voucher ini</h5>
                @if($voucher->products->isEmpty())
                    <p class="text-muted">Belum ada produk yang di-assign.</p>
                    <p class="small text-muted">Assign voucher di form edit produk (multi select voucher).</p>
                @else
                    <ul class="list-group">
                        @foreach($voucher->products as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.products.show', $p) }}">{{ $p->name }}</a>
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Edit Produk</a>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
