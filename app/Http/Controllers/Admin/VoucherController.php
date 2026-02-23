<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $vouchers = $query->orderBy('start_date', 'desc')->paginate(15);

        return view('admin.vouchers.index', [
            'vouchers' => $vouchers,
            'currentSearch' => $request->search,
        ]);
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(VoucherRequest $request)
    {
        Voucher::create($request->validated());

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function show(Voucher $voucher)
    {
        $voucher->load('products');

        return view('admin.vouchers.show', ['voucher' => $voucher]);
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', ['voucher' => $voucher]);
    }

    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('admin.vouchers.show', $voucher)
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dihapus.');
    }
}
