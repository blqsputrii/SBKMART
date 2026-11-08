@extends('layouts.app')

@section('title', 'Peran Sistem')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Posisi Pegawai</h4>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Role
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%;">Kode Jabatan</th>
                    <th style="width: 65%;">Nama Jabatan</th>
                    <th class="text-center" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roleList as $item)
                    <tr>
                        <td class="text-center fw-bold">{{ $item->{"Kode Jabatan"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Jabatan"} }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Jabatan"} }}">Ubah</button>
                            <form action="{{ route('role.destroy', $item->{"Kode Jabatan"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus role ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Jabatan"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('role.update', $item->{"Kode Jabatan"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Peran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Jabatan</label>
                                            <input type="text" name="nama_role" class="form-control" value="{{ $item->{"Nama Jabatan"} }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-blue">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data peran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Peran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Jabatan</label>
                        <input type="text" name="nama_role" class="form-control" placeholder="Contoh: Manager Operasional" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue">Simpan Peran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
