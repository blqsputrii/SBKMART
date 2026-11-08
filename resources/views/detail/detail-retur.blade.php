@extends('layouts.app')

@section('title', 'Detail Retur')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Detail Item Retur Pengembalian</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Item Retur
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Kode Rincian Retur</th>
                    <th class="text-center">Nomor Retur</th>
                    <th class="text-center">Kode Barang Diretur</th>
                    <th class="text-center">Jumlah Barang Dikembalikan</th>
                    <th>Alasan Pengembalian</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailList as $item)
                    <tr>
                        <td class="text-center fw-bold">{{ $item->{"Kode Rincian Retur"} ?? $item->iddetail_retur }}</td>
                        <td class="text-center font-monospace">#{{ $item->{"Nomor Retur"} ?? $item->idretur }}</td>
                        <td class="text-center fw-bold">{{ $item->{"Kode Barang Diretur"} ?? $item->iddetail_penerimaan }}</td>
                        <td class="text-center fw-bold text-danger">{{ $item->{"Jumlah Barang Dikembalikan"} ?? $item->jumlah }}</td>
                        <td style="color: var(--navy-dark);">{{ $item->{"Alasan Pengembalian"} ?? $item->alasan }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Rincian Retur"} ?? $item->iddetail_retur }}">Ubah</button>
                            <form action="{{ route('detail-retur.destroy', $item->{"Kode Rincian Retur"} ?? $item->iddetail_retur) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rincian retur ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Rincian Retur"} ?? $item->iddetail_retur }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('detail-retur.update', $item->{"Kode Rincian Retur"} ?? $item->iddetail_retur) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Detail Retur</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nomor Retur</label>
                                            <select name="idretur" class="form-select" required>
                                                @foreach($returList as $r)
                                                    <option value="{{ $r->idretur }}">#{{ $r->idretur }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Kode Barang Diretur</label>
                                            <select name="iddetail_penerimaan" class="form-select" required>
                                                @foreach($penerimaanList as $dp)
                                                    <option value="{{ $dp->iddetail_penerimaan }}">Barang #{{ $dp->iddetail_penerimaan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jumlah Barang Dikembalikan</label>
                                            <input type="number" name="jumlah" class="form-control" value="{{ $item->{"Jumlah Barang Dikembalikan"} ?? $item->jumlah }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alasan Pengembalian</label>
                                            <input type="text" name="alasan" class="form-control" value="{{ $item->{"Alasan Pengembalian"} ?? $item->alasan }}" required>
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
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada rincian detail retur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('detail-retur.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Detail Retur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Retur</label>
                        <select name="idretur" class="form-select" required>
                            @foreach($returList as $r)
                                <option value="{{ $r->idretur }}">#{{ $r->idretur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Barang Diretur</label>
                        <select name="iddetail_penerimaan" class="form-select" required>
                            @foreach($penerimaanList as $dp)
                                <option value="{{ $dp->iddetail_penerimaan }}">Barang #{{ $dp->iddetail_penerimaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Barang Dikembalikan</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Pengembalian</label>
                        <input type="text" name="alasan" class="form-control" placeholder="Kemasan rusak / cacat" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue">Simpan Item Retur</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
