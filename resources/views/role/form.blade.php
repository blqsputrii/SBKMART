@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Role')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('role.update', $data->id) : route('role.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Nama Role</label>
        <input type="text" name="nama_role" value="{{ old('nama_role', $data->nama_role ?? '') }}" class="form-control @error('nama_role') is-invalid @enderror">
        @error('nama_role') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('role.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
