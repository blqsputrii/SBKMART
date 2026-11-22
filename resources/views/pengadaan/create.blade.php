@extends('layouts.app')

@section('title', 'Pengadaan Baru')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ route('pengadaan.store') }}" method="POST">
    @csrf
    <div class="card-header"><h5 class="card-title mb-0">Langkah 1: Pilih Vendor</h5></div>
    <div class="card-body">
      <label class="form-label">Vendor</label>
      <select name="vendor" class="form-select @error('vendor') is-invalid @enderror">
        <option value="">-- pilih vendor --</option>
        @foreach ($vendor as $v)
          <option value="{{ $v->{'Kode Vendor'} }}" @selected(old('vendor') == $v->{'Kode Vendor'})>{{ $v->{'Nama Vendor'} }}</option>
        @endforeach
      </select>
      @error('vendor') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <p class="text-secondary mt-3 mb-0">
        Nota dibuat dulu dengan subtotal dan total 0. Tanggal, petugas, dan status (Dipesan) terisi otomatis.
        Barang yang dipesan diisi pada langkah berikutnya, dan PPN 11% serta total terhitung otomatis.
      </p>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-right-circle"></i> Buat Nota</button>
      <a href="{{ route('pengadaan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
