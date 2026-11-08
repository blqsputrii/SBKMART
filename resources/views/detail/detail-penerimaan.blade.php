@extends('layouts.app')

@section('title', 'Detail Penerimaan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Rincian Detail Penerimaan Barang</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Item Penerimaan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Kode Rincian Terima</th>
                    <th class="text-center">Nomor Surat Penerimaan</th>
                    <th>Nama Barang Diterima</th>
                    <th class="text-center">Jumlah Barang Datang</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-end">Total Nilai Masuk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailList as $item)
                    @php
                        $arrItem      = (array) $item;
                        $id           = $arrItem['Kode Rincian Terima'] ?? $arrItem['iddetail_penerimaan'] ?? null;
                        $surat        = $arrItem['Nomor Surat Penerimaan'] ?? $arrItem['idpenerimaan'] ?? '';
                        $namaBarang   = $arrItem['Nama Barang Diterima'] ?? '';
                        $jumlahDatang = $arrItem['Jumlah Barang Datang'] ?? $arrItem['jumlah_terima'] ?? 0;
                        $hargaSatuan  = $arrItem['Harga Satuan'] ?? $arrItem['harga_satuan_terima'] ?? 0;
                        $totalNilai   = floatval($jumlahDatang) * floatval($hargaSatuan);
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $id }}</td>
                        <td class="text-center fw-bold">#{{ $surat }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $namaBarang }}</td>
                        <td class="text-center fw-bold">{{ $jumlahDatang }}</td>
                        <td class="text-end">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($id)
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $id }}">Ubah</button>
                                <form action="{{ route('detail-penerimaan.destroy', $id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
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
                                <form action="{{ route('detail-penerimaan.update', $id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Rincian Item Penerimaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nomor Surat Penerimaan</label>
                                            <select name="idpenerimaan" class="form-select" required>
                                                @foreach($penerimaanList as $p)
                                                    <option value="{{ $p->idpenerimaan }}" {{ ($p->idpenerimaan == $surat) ? 'selected' : '' }}>#{{ $p->idpenerimaan }}</option>
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
                                            <label class="form-label fw-semibold">Jumlah Barang Datang</label>
                                            <input type="number" name="jumlah_terima" class="form-control" value="{{ $jumlahDatang }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Harga Satuan (Rp)</label>
                                            <input type="number" name="harga_satuan_terima" class="form-control" value="{{ $hargaSatuan }}" required>
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
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada rincian penerimaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('detail-penerimaan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Item Penerimaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Surat Penerimaan</label>
                        <select name="idpenerimaan" class="form-select" required>
                            @foreach($penerimaanList as $p)
                                <option value="{{ $p->idpenerimaan }}">#{{ $p->idpenerimaan }}</option>
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
                        <label class="form-label fw-semibold">Jumlah Barang Datang</label>
                        <input type="number" name="jumlah_terima" class="form-control" placeholder="10" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Satuan (Rp)</label>
                        <input type="number" name="harga_satuan_terima" class="form-control" placeholder="15000" required>
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
