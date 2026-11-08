@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Rincian Detail Penjualan Kasir</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Item Penjualan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Kode Item Struk</th>
                    <th class="text-center">Nomor Struk</th>
                    <th>Nama Barang</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center">Jumlah Beli</th>
                    <th class="text-end">Subtotal Item</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailList as $item)
                    @php
                        $id = $item->{"Kode Item Struk"} ?? $item->iddetail_penjualan ?? null;
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $id }}</td>
                        <td class="text-center font-monospace">#{{ $item->{"Nomor Struk"} ?? $item->idpenjualan }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Barang"} ?? $item->idbarang }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"Harga Satuan"} ?? $item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center fw-bold">{{ $item->{"Jumlah Beli"} ?? $item->jumlah }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($item->{"Subtotal Item"} ?? $item->sub_total ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($id)
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $id }}">Ubah</button>
                                <form action="{{ route('detail-penjualan.destroy', $id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada rincian penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
