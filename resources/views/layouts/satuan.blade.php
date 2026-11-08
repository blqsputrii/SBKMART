@extends('layouts.app')

@section('title', 'Satuan Kemasan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Master Satuan Kemasan</h4>
            <p class="text-muted small mb-0">Daftar satuan ukuran produk (Pcs, Kg, Botol, Karton, dll).</p>
        </div>
        <button class="btn btn-blue px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Satuan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10%;">No</th>
                    <th style="width: 50%;">Satuan Ukuran</th>
                    <th class="text-center" style="width: 20%;">Status Penggunaan</th>
                    <th class="text-center" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($satuanList as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">
                            {{ $item->{"Satuan Ukuran"} }}
                        </td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Status Penggunaan"} ?? ''), 'masih') || str_contains(strtolower($item->{"Status Penggunaan"} ?? ''), 'pakai'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $item->{"Status Penggunaan"} }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
                                    {{ $item->{"Status Penggunaan"} }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Satuan"} }}">Ubah</button>
                            <form action="{{ route('satuan.destroy', $item->{"Kode Satuan"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Satuan"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('satuan.update', $item->{"Kode Satuan"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Satuan Kemasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Satuan Ukuran</label>
                                            <input type="text" name="nama_satuan" class="form-control" value="{{ $item->{"Satuan Ukuran"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Penggunaan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="1">Masih Dipakai</option>
                                                <option value="0">Tidak Dipakai</option>
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
                    <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada satuan kemasan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('satuan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Satuan Kemasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Satuan Ukuran</label>
                        <input type="text" name="nama_satuan" class="form-control" placeholder="Contoh: Karton / Dus" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Penggunaan</label>
                        <select name="status" class="form-select" required>
                            <option value="1">Masih Dipakai</option>
                            <option value="0">Tidak Dipakai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-blue">Simpan Satuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
