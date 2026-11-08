@extends('layouts.app')

@section('title', 'Pengadaan Barang')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Transaksi Pengadaan Barang</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Buat Pengadaan Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Nomor Nota Belanja</th>
                    <th>Nama Vendor</th>
                    <th>Petugas</th>
                    <th class="text-end">Total Harga Barang</th>
                    <th class="text-end">Pajak PPN</th>
                    <th class="text-end">Total Bayar Pemasok</th>
                    <th class="text-center">Status Pemesanan</th>
                    <th class="text-center">Waktu Pemesanan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengadaanList as $item)
                    <tr>
                        <td class="text-center fw-bold">#{{ $item->{"Nomor Nota Belanja"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Pemasok"} }}</td>
                        <td>{{ $item->Petugas }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"Total Harga Barang"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"Pajak PPN"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($item->{"Total Bayar Pemasok"} ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Status Pemesanan"} ?? ''), 'disetujui'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">{{ $item->{"Status Pemesanan"} }}</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1">{{ $item->{"Status Pemesanan"} }}</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small">{{ $item->{"Waktu Pemesanan"} }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Nomor Nota Belanja"} }}">Ubah</button>
                            <form action="{{ route('pengadaan.destroy', $item->{"Nomor Nota Belanja"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengadaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Nomor Nota Belanja"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('pengadaan.update', $item->{"Nomor Nota Belanja"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Pengadaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Vendor</label>
                                            <select name="idvendor" class="form-select" required>
                                                @foreach($vendorList as $v)
                                                    <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Petugas</label>
                                            <select name="iduser" class="form-select" required>
                                                @foreach($userList as $u)
                                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Total Harga Barang (Rp)</label>
                                            <input type="number" name="subtotal_nilai" class="form-control" value="{{ $item->{"Total Harga Barang"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pajak PPN (Rp)</label>
                                            <input type="number" name="ppn" class="form-control" value="{{ $item->{"Pajak PPN"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Total Bayar Pemasok (Rp)</label>
                                            <input type="number" name="total_nilai" class="form-control" value="{{ $item->{"Total Bayar Pemasok"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Pemesanan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="P">Pending</option>
                                                <option value="S">Disetujui</option>
                                            </select>
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
                    <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada transaksi pengadaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pengadaan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pengadaan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vendor</label>
                        <select name="idvendor" class="form-select" required>
                            @foreach($vendorList as $v)
                                <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Petugas</label>
                        <select name="iduser" class="form-select" required>
                            @foreach($userList as $u)
                                <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Harga Barang (Rp)</label>
                        <input type="number" name="subtotal_nilai" class="form-control" placeholder="100000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pajak PPN (Rp)</label>
                        <input type="number" name="ppn" class="form-control" placeholder="11000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Bayar Pemasok (Rp)</label>
                        <input type="number" name="total_nilai" class="form-control" placeholder="111000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
