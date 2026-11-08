@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Daftar Transaksi Penjualan</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Transaksi Penjualan Kasir
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Nomor Struk Penjualan</th>
                    <th>Kasir</th>
                    <th>Persentase Margin</th>
                    <th class="text-end">Total Belanja Sebelum Pajak</th>
                    <th class="text-end">Pajak Pembeli PPN</th>
                    <th class="text-end">Total Bayar Konsumen</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualanList as $p)
                    <tr>
                        <td class="text-center fw-bold">#{{ $p->{"Nomor Struk Penjualan"} ?? '-' }}</td>
                        <td>{{ $p->{"Kasir"} ?? '-' }}</td>
                        <td>{{ $p->{"Persentase Margin"} ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($p->{"Total Belanja Sebelum Pajak"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($p->{"Pajak Pembeli PPN"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($p->{"Total Bayar Konsumen"} ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $p->{"Waktu"} ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi penjualan kasir.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
