@extends('layouts.app')

@section('title', 'Data Pemasok')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Daftar Pemasok (Vendor)</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            Tambah Pemasok
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Perusahaan</th>
                    <th class="text-center">Jenis Legalitas Usaha</th>
                    <th class="text-center">Status Kerjasama</th>
                    <th class="text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendorList as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Nama Perusahaan"} }}</td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Jenis Legalitas Usaha"} ?? ''), 'resmi'))
                                <span class="badge" style="background-color: var(--blue-soft); color: var(--navy-dark);">
                                    {{ $item->{"Jenis Legalitas Usaha"} }}
                                </span>
                            @else
                                <span class="badge bg-light text-dark border">
                                    {{ $item->{"Jenis Legalitas Usaha"} }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Status Kerjasama"} ?? ''), 'aktif'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    {{ $item->{"Status Kerjasama"} }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                    {{ $item->{"Status Kerjasama"} }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Pemasok"} }}">Ubah</button>
                            <form action="{{ route('vendor.destroy', $item->{"Kode Pemasok"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Pemasok"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('vendor.update', $item->{"Kode Pemasok"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Data Pemasok</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Perusahaan</label>
                                            <input type="text" name="nama_vendor" class="form-control" value="{{ $item->{"Nama Perusahaan"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jenis Legalitas Usaha</label>
                                            <select name="badan_hukum" class="form-select" required>
                                                <option value="Y" {{ $item->{"Jenis Legalitas Usaha"} == 'Perusahaan Resmi (PT/CV)' ? 'selected' : '' }}>Perusahaan Resmi (PT/CV)</option>
                                                <option value="N" {{ $item->{"Jenis Legalitas Usaha"} == 'Toko Perorangan' ? 'selected' : '' }}>Toko Perorangan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Kerjasama</label>
                                            <select name="status" class="form-select" required>
                                                <option value="A" {{ $item->{"Status Kerjasama"} == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="N" {{ $item->{"Status Kerjasama"} == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
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
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada pemasok terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('vendor.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pemasok Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" name="nama_vendor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Legalitas Usaha</label>
                        <select name="badan_hukum" class="form-select" required>
                            <option value="Y">Perusahaan Resmi (PT/CV)</option>
                            <option value="N">Toko Perorangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Kerjasama</label>
                        <select name="status" class="form-select" required>
                            <option value="A">Aktif</option>
                            <option value="N">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Pemasok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
