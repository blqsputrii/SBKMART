@extends('layouts.app')

@section('title', 'Detail Pengadaan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Rincian Detail Pengadaan Barang</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Item Pengadaan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Kode Rincian</th>
                    <th class="text-center">Nomor Nota Belanja</th>
                    <th>Nama Barang</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center">Banyak Barang Dibeli</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailList as $item)
                    @php
                        $id = $item->{"Kode Rincian"} ?? $item->iddetail_pengadaan ?? null;
                        $nota = $item->{"Nomor Nota Belanja"} ?? $item->idpengadaan ?? '';
                        $namaBarang = $item->{"Nama Barang"} ?? '';
                        $hargaSatuan = $item->{"Harga Satuan"} ?? 0;
                        $jumlahBeli = $item->{"Banyak Barang Dibeli"} ?? 0;
                        $subtotal = $item->Subtotal ?? 0;
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $id }}</td>
                        <td class="text-center fw-bold">#{{ $nota }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $namaBarang }}</td>
                        <td class="text-end">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                        <td class="text-center fw-bold">{{ $jumlahBeli }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($id)
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $id }}">Ubah</button>
                                <form action="{{ route('detail-pengadaan.destroy', $id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>

                    @if($id)
                    <div class="modal fade" id="modalEdit{{ $id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('detail-pengadaan.update', $id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Rincian Item Pengadaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nomor Nota Belanja</label>
                                            <select name="idpengadaan" class="form-select" required>
                                                @foreach($pengadaanList as $p)
                                                    <option value="{{ $p->idpengadaan }}" {{ ($p->idpengadaan == $nota) ? 'selected' : '' }}>#{{ $p->idpengadaan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pilih Barang</label>
                                            <select name="idbarang" class="form-select" required>
                                                @foreach($barangList as $b)
                                                    <option value="{{ $b->idbarang }}">{{ $b->nama ?? $b->{"Nama Barang"} }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Harga Satuan Beli (Rp)</label>
                                            <input type="number" name="harga_satuan" class="form-control" value="{{ $hargaSatuan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Banyak Barang Dibeli</label>
                                            <input type="number" name="jumlah" class="form-control" value="{{ $jumlahBeli }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-blue">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada rincian pengadaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('detail-pengadaan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Item Pengadaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Nota Belanja</label>
                        <select name="idpengadaan" class="form-select" required>
                            @foreach($pengadaanList as $p)
                                <option value="{{ $p->idpengadaan }}">#{{ $p->idpengadaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang</label>
                        <select name="idbarang" class="form-select" required>
                            @foreach($barangList as $b)
                                <option value="{{ $b->idbarang }}">{{ $b->nama ?? $b->{"Nama Barang"} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Satuan Beli (Rp)</label>
                        <input type="number" name="harga_satuan" class="form-control" placeholder="10000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Banyak Barang Dibeli</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
