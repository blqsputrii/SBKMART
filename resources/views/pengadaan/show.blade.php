@extends('layouts.app')

@section('title', 'Pengadaan No. ' . $nota->{'No. Pengadaan'})

@section('content')
<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"><small class="text-secondary">Vendor</small><div class="fw-bold">{{ $nota->{'Nama Vendor'} }}</div></div>
      <div class="col-md-3"><small class="text-secondary">Tanggal Pesan</small><div class="fw-bold">{{ $nota->{'Tanggal Pesan'} }}</div></div>
      <div class="col-md-3"><small class="text-secondary">Petugas</small><div class="fw-bold">{{ $nota->{'Petugas'} }}</div></div>
      <div class="col-md-3"><small class="text-secondary">Status</small>
        <div><span class="badge text-bg-{{ warna_status($nota->{'Status'}) }}">{{ $nota->{'Status'} }}</span></div></div>
    </div>
  </div>
</div>

@if (in_array(session('user_role'), [1, 3]) && $nota->{'Status'} === 'Dipesan')
  @include('partials.form-barang', [
      'action'     => route('pengadaan.detail.store', $nota->{'No. Pengadaan'}),
      'barang'     => $barang,
      'margin'     => 0,
      'tampilStok' => false,
      'tombol'     => 'Simpan Barang ke Nota',
  ])
@endif

<div class="card mb-3">
  <div class="card-header"><h5 class="card-title mb-0">Barang yang Dipesan</h5></div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $detail, 'sembunyi' => ['No. Pengadaan']])
  </div>
  <div class="card-footer text-end">
    Subtotal <b>{{ rupiah($nota->{'Subtotal'}) }}</b> &nbsp;|&nbsp;
    PPN 11% <b>{{ rupiah($nota->{'PPN'}) }}</b> &nbsp;|&nbsp;
    Total <b>{{ rupiah($nota->{'Total'}) }}</b>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Penerimaan Barang</h5>
    @if (in_array(session('user_role'), [1, 3]) && $nota->{'Status'} !== 'Diterima Utuh' && count($detail) > 0)
      <a href="{{ route('penerimaan.create', ['pengadaan' => $nota->{'No. Pengadaan'}]) }}" class="btn btn-success btn-sm">
        <i class="bi bi-box-seam"></i> Terima Barang
      </a>
    @endif
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $terima, 'sembunyi' => ['No. Pengadaan'], 'aksiView' => 'penerimaan._aksi'])
  </div>
</div>
@endsection
