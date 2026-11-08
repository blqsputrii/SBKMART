@extends('layouts.app')

@section('title', 'Pengadaan Barang')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Transaksi Pengadaan Barang</h4>
            <p class="text-muted small mb-0">Kelola pemesanan stok barang dari supplier / vendor.</p>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Buat Pengadaan Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Pengadaan</th>
                    <th class="text-end">Subtotal Nilai</th>
                    <th class="text-end">PPN</th>
                    <th class="text-end">Total Nilai</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengadaanList as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="text-center fw-bold">#PGD-{{ $item->{"ID Pengadaan"} ?? $item->idpengadaan }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"Subtotal Nilai"} ?? $item->subtotal_nilai ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->{"PPN"} ?? $item->ppn ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($item->{"Total Nilai"} ?? $item->total_nilai ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Status Transaksi"} ?? $item->status ?? ''), 'selesai') || ($item->status ?? '') == 'S')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Selesai</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2">Proses</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"ID Pengadaan"} ?? $item->idpengadaan }}">Ubah</button>
                            <form action="{{ route('pengadaan.destroy', $item->{"ID Pengadaan"} ?? $item->idpengadaan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi pengadaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"ID Pengadaan"} ?? $item->idpengadaan }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('pengadaan.update', $item->{"ID Pengadaan"} ?? $item->idpengadaan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Status Pengadaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pemasok / Vendor</label>
                                            <select name="idvendor" class="form-select" required>
                                                @foreach($vendorList as $v)
                                                    <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Petugas Pembuat</label>
                                            <select name="iduser" class="form-select" required>
                                                @foreach($userList as $u)
                                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Subtotal (Rp)</label>
                                            <input type="number" name="subtotal_nilai" class="form-control" value="{{ $item->{"Subtotal Nilai"} ?? $item->subtotal_nilai }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">PPN (Rp)</label>
                                            <input type="number" name="ppn" class="form-control" value="{{ $item->{"PPN"} ?? $item->ppn }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Total Nilai (Rp)</label>
                                            <input type="number" name="total_nilai" class="form-control" value="{{ $item->{"Total Nilai"} ?? $item->total_nilai }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Pengadaan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="P">Proses (Pending)</option>
                                                <option value="S">Selesai / Diterima</option>
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
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi pengadaan.</td></tr>
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
                        <label class="form-label fw-semibold">Pemasok / Vendor</label>
                        <select name="idvendor" class="form-select" required>
                            @foreach($vendorList as $v)
                                <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Petugas Pembuat</label>
                        <select name="iduser" class="form-select" required>
                            @foreach($userList as $u)
                                <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtotal Nilai (Rp)</label>
                        <input type="number" name="subtotal_nilai" class="form-control" placeholder="100000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">PPN Nilai (Rp)</label>
                        <input type="number" name="ppn" class="form-control" placeholder="11000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total Nilai (Rp)</label>
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
