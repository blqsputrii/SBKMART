@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Satuan')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('satuan.update', $data->id) : route('satuan.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Nama Satuan</label>
        <input type="text" name="nama_satuan" value="{{ old('nama_satuan', $data->nama_satuan ?? '') }}" class="form-control @error('nama_satuan') is-invalid @enderror">
        @error('nama_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
          <option value="1" @selected(old('status', $data->status ?? 1) == 1)>Aktif</option>
          <option value="0" @selected(old('status', $data->status ?? 1) == 0)>Nonaktif</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
