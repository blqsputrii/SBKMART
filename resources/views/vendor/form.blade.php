@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Vendor')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('vendor.update', $data->id) : route('vendor.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Nama Vendor</label>
        <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $data->nama_vendor ?? '') }}" class="form-control @error('nama_vendor') is-invalid @enderror">
        @error('nama_vendor') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Badan Hukum</label>
        <select name="badan_hukum" class="form-select @error('badan_hukum') is-invalid @enderror">
          <option value="Y" @selected(old('badan_hukum', $data->badan_hukum ?? 'Y') == 'Y')>Ya</option>
          <option value="N" @selected(old('badan_hukum', $data->badan_hukum ?? 'Y') == 'N')>Tidak</option>
        </select>
        @error('badan_hukum') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
          <option value="A" @selected(old('status', $data->status ?? 'A') == 'A')>Aktif</option>
          <option value="N" @selected(old('status', $data->status ?? 'A') == 'N')>Nonaktif</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('vendor.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
