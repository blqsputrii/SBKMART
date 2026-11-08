@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Katalog Produk & Barang</h4>
            <p class="text-muted small mb-0">Kelola informasi produk, harga jual, dan status penjualannya.</p>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Barang</th>
                    <th>Satuan Kemasan</th>
                    <th class="text-center">Ukuran Kemasan</th>
                    <th class="text-end">Harga Jual Satuan</th>
                    <th class="text-center">Status Penjualan</th>
                    <th class="text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangList as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Barang"} }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->{"Satuan Kemasan"} }}</span></td>
                        <td class="text-center">
                            @if(str_contains($item->{"Ukuran Kemasan"}, 'Kecil'))
                                <span class="badge" style="background-color: var(--blue-soft); color: var(--navy-dark);">{{ $item->{"Ukuran Kemasan"} }}</span>
                            @else
                                <span class="badge" style="background-color: #FEF3C7; color: #92400E;">{{ $item->{"Ukuran Kemasan"} }}</span>
                            @endif
                        </td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($item->{"Harga Jual Satuan"}, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if(str_contains($item->{"Status Penjualan"}, 'Tersedia'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $item->{"Status Penjualan"} }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> {{ $item->{"Status Penjualan"} }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Barang"} }}">
                                Ubah
                            </button>
                            <form action="{{ route('barang.destroy', $item->{"Kode Barang"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Barang"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('barang.update', $item->{"Kode Barang"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Data Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Produk / Barang</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $item->{"Nama Barang"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Satuan Kemasan</label>
                                            <select name="idsatuan" class="form-select" required>
                                                @foreach($satuanList as $satuan)
                                                    <option value="{{ $satuan->idsatuan }}">{{ $satuan->nama_satuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Ukuran Kemasan</label>
                                            <select name="jenis" class="form-select" required>
                                                <option value="S">Kecil</option>
                                                <option value="M">Besar</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Harga Jual Satuan (Rp)</label>
                                            <input type="number" name="harga" class="form-control" value="{{ $item->{"Harga Jual Satuan"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Penjualan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="1">Tersedia / Aktif</option>
                                                <option value="0">Tidak Dijual</option>
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
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada produk terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk / Barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Indomie Goreng" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Satuan Kemasan</label>
                        <select name="idsatuan" class="form-select" required>
                            @foreach($satuanList as $satuan)
                                <option value="{{ $satuan->idsatuan }}">{{ $satuan->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ukuran Kemasan</label>
                        <select name="jenis" class="form-select" required>
                            <option value="S">Kecil</option>
                            <option value="M">Besar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Jual Satuan (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="3500" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Penjualan</label>
                        <select name="status" class="form-select" required>
                            <option value="1">Tersedia / Aktif</option>
                            <option value="0">Tidak Dijual</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
