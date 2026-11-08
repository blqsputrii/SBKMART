@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #F8FAFC; min-height: 80vh;">
    <h2 class="mb-4 font-weight-bold" style="color: #1E293B;">Mutasi Stok</h2>

    <div class="card shadow-sm border-0" style="background-color: #FFFFFF;">
        <div class="card-header text-white" style="background-color: #1E293B;">
            <h5 class="mb-0">Tabel Riwayat Mutasi Kartu Stok</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead style="background-color: #0D9488; color: white;">
                        <tr>
                            <th>Nomor Riwayat Stok</th>
                            <th>Nama Barang</th>
                            <th>Nomor Transaksi</th>
                            <th>Sumber Mutasi</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Sisa Stok Akhir Gudang</th>
                            <th>Waktu Perubahan Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kartuStok as $row)
                        <tr>
                            <td>{{ $row->{'Nomor Riwayat Stok'} }}</td>
                            <td class="font-weight-bold">{{ $row->{'Nama Barang'} }}</td>
                            <td>{{ $row->{'Nomor Transaksi'} }}</td>
                            <td><span class="badge bg-secondary text-white">{{ $row->{'Sumber Mutasi'} }}</span></td>
                            <td class="text-success">+{{ $row->{'Stok Masuk'} ?? 0 }}</td>
                            <td class="text-danger">-{{ $row->{'Stok Keluar'} ?? 0 }}</td>
                            <td><span class="badge text-white" style="background-color: #2563EB;">{{ $row->{'Sisa Stok Akhir Gudang'} }}</span></td>
                            <td>{{ $row->{'Waktu Perubahan Stok'} }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat mutasi stok tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
