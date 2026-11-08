@extends('layouts.app')

@section('title', 'Akun Pengguna')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Data Akun Pengguna</h4>
            <p class="text-muted small mb-0">Kelola kredensial pengguna sistem secara terenkripsi dan aman.</p>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10%;">No</th>
                    <th style="width: 40%;">Nama Pengguna</th>
                    <th style="width: 30%;">Kata Sandi</th>
                    <th class="text-center" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userList as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Pengguna"} }}</td>
                        <td>
                            <span class="text-muted fw-bold fs-5" style="letter-spacing: 2px;">••••••••</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"ID Pengguna"} }}">Ubah</button>
                            <form action="{{ route('user.destroy', $item->{"ID Pengguna"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"ID Pengguna"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('user.update', $item->{"ID Pengguna"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Akun Pengguna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Pengguna</label>
                                            <input type="text" name="username" class="form-control" value="{{ $item->{"Nama Pengguna"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Password Baru</label>
                                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jabatan / Role</label>
                                            <select name="idrole" class="form-select" required>
                                                @foreach($roleList as $role)
                                                    <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
                                                @endforeach
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
                    <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada akun pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pengguna</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: Kasir_Ahmad" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan / Role</label>
                        <select name="idrole" class="form-select" required>
                            @foreach($roleList as $role)
                                <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
