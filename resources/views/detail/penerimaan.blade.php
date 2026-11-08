@extends('layouts.app')

@section('title', 'Penerimaan Barang')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Penerimaan Barang Gudang</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-box-arrow-in-down me-1"></i> Catat Penerimaan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">Nomor Surat Penerimaan</th>
                    <th class="text-center">Nomor Nota Belanja</th>
                    <th>Petugas</th>
                    <th class="text-center">Kondisi Penerimaan</th>
                    <th class="text-center">Waktu Barang Sampai</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penerimaanList as $item)
                    <tr>
                        <td class="text-center fw-bold">#{{ $item->{"Nomor Surat Penerimaan"} }}</td>
                        <td class="text-center">#{{ $item->{"Nomor Nota Belanja"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->Petugas }}</td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                <i class="bi bi-check2-all me-1"></i> {{ $item->{"Kondisi Penerimaan"} }}
                            </span>
                        </td>
                        <td class="text-center text-muted small">{{ $item->{"Waktu Barang Sampai"} }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Nomor Surat Penerimaan"} }}">Ubah</button>
                            <form action="{{ route('penerimaan.destroy', $item->{"Nomor Surat Penerimaan"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data penerimaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Nomor Surat Penerimaan"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('penerimaan.update', $item->{"Nomor Surat Penerimaan"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Penerimaan</h5>
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
                                            <label class="form-label fw-semibold">Petugas</label>
                                            <select name="iduser" class="form-select" required>
                                                @foreach($userList as $u)
                                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Penerimaan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="1">Lengkap Diterima</option>
                                                <option value="0">Bermasalah</option>
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
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data penerimaan barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penerimaan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Catat Penerimaan Barang</h5>
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
                        <label class="form-label fw-semibold">Petugas</label>
                        <select name="iduser" class="form-select" required>
                            @foreach($userList as $u)
                                <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Penerimaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
