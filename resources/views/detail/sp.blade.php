@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #F8FAFC; min-height: 80vh;">
    <h2 class="mb-4 font-weight-bold" style="color: #1E293B;">Stored Procedure Database</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="background-color: #FFFFFF;">
                <div class="card-header text-white" style="background-color: #0D9488;">
                    <h5 class="mb-0">Penjualan Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sp.penjualan') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nomor Struk Penjualan</label>
                            <input type="number" name="idpenjualan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kasir</label>
                            <input type="number" name="iduser" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kode Barang</label>
                            <input type="number" name="idbarang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Jumlah Beli</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Harga Satuan</label>
                            <input type="number" step="0.01" name="harga" class="form-control" required>
                        </div>
                        <button type="submit" class="btn text-white w-100 font-weight-bold shadow-sm" style="background-color: #2563EB;">Proses Penjualan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="background-color: #FFFFFF;">
                <div class="card-header text-white" style="background-color: #1E293B;">
                    <h5 class="mb-0">Retur Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sp.retur') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nomor Retur</label>
                            <input type="number" name="idretur" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nomor Surat Penerimaan</label>
                            <input type="number" name="idpenerimaan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Petugas</label>
                            <input type="number" name="iduser" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kode Barang</label>
                            <input type="number" name="idbarang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Jumlah Barang Dikembalikan</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                        <button type="submit" class="btn text-white w-100 font-weight-bold shadow-sm" style="background-color: #0D9488;">Proses Retur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4" style="background-color: #FFFFFF;">
        <div class="card-header text-white" style="background-color: #1E293B;">
            <h5 class="mb-0">Data View Penjualan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead style="background-color: #0D9488; color: white;">
                        <tr>
                            <th>Nomor Struk Penjualan</th>
                            <th>Kasir</th>
                            <th>Persentase Margin</th>
                            <th>Total Belanja Sebelum Pajak</th>
                            <th>Pajak Pembeli PPN</th>
                            <th>Total Bayar Konsumen</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan as $row)
                        <tr>
                            <td>{{ $row->{'Nomor Struk Penjualan'} }}</td>
                            <td>{{ $row->{'Kasir'} }}</td>
                            <td>{{ $row->{'Persentase Margin'} }}%</td>
                            <td>Rp {{ number_format($row->{'Total Belanja Sebelum Pajak'}, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row->{'Pajak Pembeli PPN'}, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($row->{'Total Bayar Konsumen'}, 0, ',', '.') }}</strong></td>
                            <td>{{ $row->{'Waktu'} }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Belum ada data penjualan tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
