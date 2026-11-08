@extends('layouts.app')

@section('title', 'Kartu Stok Gudang')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Stok Gudang</h4>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">No. Riwayat</th>
                    <th>Nama Barang</th>
                    <th class="text-center">No. Transaksi</th>
                    <th class="text-center">Sumber Mutasi</th>
                    <th class="text-center text-success">Stok Masuk</th>
                    <th class="text-center text-danger">Stok Keluar</th>
                    <th class="text-center">Sisa Stok Akhir</th>
                    <th class="text-center">Waktu Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kartuStokList as $item)
                    <tr>
                        <td class="text-center fw-bold">{{ $item->{"Nomor Riwayat Stok"} ?? '-' }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Barang"} ?? '-' }}</td>
                        <td class="text-center text-muted">{{ $item->{"Nomor Transaksi"} ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1">
                                {{ $item->{"Sumber Mutasi"} ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center fw-bold text-success">{{ $item->{"Stok Masuk"} ?? 0 }}</td>
                        <td class="text-center fw-bold text-danger">{{ $item->{"Stok Keluar"} ?? 0 }}</td>
                        <td class="text-center fw-bold">{{ $item->{"Sisa Stok Akhir Gudang"} ?? '-' }}</td>
                        <td class="text-center text-muted small">{{ $item->{"Waktu Perubahan Stok"} ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat kartu stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
