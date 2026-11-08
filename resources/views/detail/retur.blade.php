@extends('layouts.app')

@section('title', 'Retur Pengembalian')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Retur Pembelian</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-arrow-return-left me-1"></i> Buat Retur Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%;">Nomor Retur</th>
                    <th class="text-center" style="width: 25%;">Nomor Surat Penerimaan</th>
                    <th style="width: 25%;">Petugas</th>
                    <th class="text-center" style="width: 20%;">Waktu Pengembalian</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returList as $item)
                    <tr>
                        <td class="text-center fw-bold">#{{ $item->{"Nomor Retur"} }}</td>
                        <td class="text-center">#{{ $item->{"Nomor Surat Penerimaan"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->Petugas }}</td>
                        <td class="text-center text-muted small">{{ $item->{"Waktu Pengembalian"} }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Nomor Retur"} }}">Ubah</button>
                            <form action="{{ route('retur.destroy', $item->{"Nomor Retur"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus retur ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Nomor Retur"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('retur.update', $item->{"Nomor Retur"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Transaksi Retur</h5>
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
                                        <button type="submit" class="btn btn-blue">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi retur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('retur.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Transaksi Retur</h5>
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
                    <button type="submit" class="btn btn-blue">Simpan Retur</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
