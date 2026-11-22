@extends('layouts.app')

@section('title', ($data ? 'Ubah ' : 'Tambah ') . 'Barang')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ $data ? route('barang.update', $data->id) : route('barang.store') }}" method="POST">
    @csrf
    @if ($data) @method('PUT') @endif
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Nama Barang</label>
        <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}" class="form-control @error('nama') is-invalid @enderror">
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Ukuran</label>
        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
          <option value="">-- pilih --</option>
          <option value="S" @selected(old('jenis', $data->jenis ?? '') == 'S')>Small</option>
          <option value="M" @selected(old('jenis', $data->jenis ?? '') == 'M')>Medium</option>
        </select>
        @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Satuan</label>
        <select name="idsatuan" class="form-select @error('idsatuan') is-invalid @enderror">
          <option value="">-- pilih satuan --</option>
          @foreach ($satuan as $s)
            <option value="{{ $s->{'Kode Satuan'} }}" @selected(old('idsatuan', $data->idsatuan ?? '') == $s->{'Kode Satuan'})>{{ $s->{'Nama Satuan'} }}</option>
          @endforeach
        </select>
        @error('idsatuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="harga" min="0" value="{{ old('harga', $data->harga ?? '') }}" class="form-control @error('harga') is-invalid @enderror">
        @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <p class="text-secondary mb-0">Status stok (Tersedia/Kosong) terisi otomatis dari kartu stok.</p>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
