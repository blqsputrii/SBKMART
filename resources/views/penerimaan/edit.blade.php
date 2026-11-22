@extends('layouts.app')

@section('title', 'Ubah Jumlah Diterima')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ route('detail-penerimaan.update', $detail->{'No. Detail'}) }}" method="POST">
    @csrf @method('PUT')
    <div class="card-body">
      <dl class="row mb-3">
        <dt class="col-sm-4">No. Penerimaan</dt><dd class="col-sm-8">{{ $detail->{'No. Penerimaan'} }}</dd>
        <dt class="col-sm-4">Barang</dt><dd class="col-sm-8">{{ $detail->{'Nama Barang'} }}</dd>
        <dt class="col-sm-4">Harga Satuan</dt><dd class="col-sm-8">{{ rupiah($detail->{'Harga Satuan'}) }} <small class="text-secondary">(mengikuti nota pengadaan, tidak dapat diubah)</small></dd>
        <dt class="col-sm-4">Jumlah Sekarang</dt><dd class="col-sm-8">{{ $detail->{'Jumlah Diterima'} }}</dd>
      </dl>
      <div class="mb-3">
        <label class="form-label">Jumlah Diterima (baru)</label>
        <input type="number" min="1" name="jumlah" value="{{ old('jumlah', $detail->{'Jumlah Diterima'}) }}" class="form-control @error('jumlah') is-invalid @enderror">
        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <p class="text-secondary mb-0">Kartu stok dan status pengadaan ikut diperbarui otomatis oleh stored procedure.</p>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="{{ route('penerimaan.show', $detail->{'No. Penerimaan'}) }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
