@extends('layouts.app')

@section('title', 'Penjualan Kasir')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Transaksi Penjualan</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-cart-plus me-1"></i> Transaksi Kasir Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Nomor Struk Penjualan</th>
                    <th>Kasir</th>
                    <th class="text-center">Persentase Margin</th>
                    <th class="text-end">Total Belanja Sebelum Pajak</th>
                    <th class="text-end">Pajak Pembeli PPN</th>
                    <th class="text-end">Total Bayar Konsumen</th>
                    <th class="text-center">Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualanList as $item)
                    <tr>
                        <td class="text-center fw-bold">#{{ $item->{"Nomor Struk Penjualan"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->Kasir }}</td>
                        <td class="text-center">{{ $item->{"Persentase Margin"} }} %</td>
                        <td class="text-end">Rp {{ number_format($item->{"Total Belanja Sebelum Pajak"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"Pajak Pembeli PPN"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-success fs-6">Rp {{ number_format($item->{"Total Bayar Konsumen"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center text-muted small">{{ $item->Waktu }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Nomor Struk Penjualan"} }}">Ubah</button>
                            <form action="{{ route('penjualan.destroy', $item->{"Nomor Struk Penjualan"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi penjualan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Nomor Struk Penjualan"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('penjualan.update', $item->{"Nomor Struk Penjualan"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Transaksi Penjualan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Kasir</label>
                                            <select name="iduser" class="form-select" required>
                                                @foreach($userList as $u)
                                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Margin Penjualan</label>
                                            <select name="idmargin_penjualan" class="form-select" required>
                                                @foreach($marginList as $m)
                                                    <option value="{{ $m->idmargin_penjualan }}">{{ $m->persen }} %</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Total Belanja Sebelum Pajak (Rp)</label>
                                            <input type="number" name="subtotal_nilai" class="form-control" value="{{ $item->{"Total Belanja Sebelum Pajak"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pajak Pembeli PPN (Rp)</label>
                                            <input type="number" name="ppn" class="form-control" value="{{ $item->{"Pajak Pembeli PPN"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Total Bayar Konsumen (Rp)</label>
                                            <input type="number" name="total_nilai" class="form-control" value="{{ $item->{"Total Bayar Konsumen"} }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-teal">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi penjualan kasir.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Transaksi Penjualan Kasir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kasir</label>
                        <select name="iduser" class="form-select" required>
                            @foreach($userList as $u)
                                <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Margin Penjualan</label>
                        <select name="idmargin_penjualan" class="form-select" required>
                            @foreach($marginList as $m)
                                <option value="{{ $m->idmargin_penjualan }}">{{ $m->persen }} %</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Belanja Sebelum Pajak (Rp)</label>
                        <input type="number" name="subtotal_nilai" class="form-control" placeholder="50000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pajak Pembeli PPN (Rp)</label>
                        <input type="number" name="ppn" class="form-control" placeholder="5500" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Bayar Konsumen (Rp)</label>
                        <input type="number" name="total_nilai" class="form-control" placeholder="55500" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Transaksi Kasir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
