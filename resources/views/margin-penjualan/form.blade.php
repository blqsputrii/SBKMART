@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Margin Penjualan')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('margin-penjualan.update', $data->id) : route('margin-penjualan.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Margin (%)</label>
        <input type="number" step="0.01" min="0" max="100" name="persen" value="{{ old('persen', $data->persen ?? '') }}" class="form-control @error('persen') is-invalid @enderror">
        @error('persen') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <p class="text-secondary mb-0">Margin baru berstatus nonaktif. Aktifkan dari daftar margin.</p>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('margin-penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
