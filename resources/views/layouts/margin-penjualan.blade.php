@extends('layouts.app')

@section('title', 'Margin Penjualan')

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Margin Keuntungan Penjualan</h4>
        </div>
        <button class="btn btn-teal px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Margin
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle table-custom">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10%;">Kode Margin</th>
                    <th>Ditetapkan Oleh</th>
                    <th class="text-center">Persentase Keuntungan</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Tanggal Diperbarui</th>
                    <th class="text-center">Status Aturan</th>
                    <th class="text-center" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($marginList as $item)
                    <tr>
                        <td class="text-center fw-bold">{{ $item->{"Kode Margin"} }}</td>
                        <td class="fw-bold" style="color: var(--navy-dark);">{{ $item->{"Ditetapkan Oleh"} }}</td>
                        <td class="text-center fw-bold text-success fs-5">{{ $item->{"Persentase Keuntungan"} }} %</td>
                        <td class="text-center text-muted small">{{ $item->{"Tanggal Dibuat"} }}</td>
                        <td class="text-center text-muted small">{{ $item->{"Tanggal Diperbarui"} }}</td>
                        <td class="text-center">
                            @if(str_contains(strtolower($item->{"Status Aturan"} ?? ''), 'aktif') && !str_contains(strtolower($item->{"Status Aturan"} ?? ''), 'non'))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $item->{"Status Aturan"} }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border px-3 py-2">
                                    {{ $item->{"Status Aturan"} }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->{"Kode Margin"} }}">Ubah</button>
                            <form action="{{ route('margin-penjualan.destroy', $item->{"Kode Margin"}) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus margin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->{"Kode Margin"} }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('margin-penjualan.update', $item->{"Kode Margin"}) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Ubah Margin Penjualan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Persentase Keuntungan (%)</label>
                                            <input type="number" step="0.01" name="persen" class="form-control" value="{{ $item->{"Persentase Keuntungan"} }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Ditetapkan Oleh (User)</label>
                                            <select name="iduser" class="form-select" required>
                                                @foreach($userList as $user)
                                                    <option value="{{ $user->iduser }}">{{ $user->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Aturan</label>
                                            <select name="status" class="form-select" required>
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif</option>
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
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada margin penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('margin-penjualan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Margin Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Persentase Keuntungan (%)</label>
                        <input type="number" step="0.01" name="persen" class="form-control" placeholder="10.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ditetapkan Oleh (User)</label>
                        <select name="iduser" class="form-select" required>
                            @foreach($userList as $user)
                                <option value="{{ $user->iduser }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Aturan</label>
                        <select name="status" class="form-select" required>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal">Simpan Margin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
