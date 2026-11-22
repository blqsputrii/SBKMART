@extends('layouts.app')

@section('title', 'Nota Penjualan No. ' . $nota->{'No. Penjualan'})

@section('content')
@if (in_array(session('user_role'), [1, 2]))
  @if (count($barang) > 0)
    @include('partials.form-barang', [
        'action'     => route('penjualan.detail.store', $nota->{'No. Penjualan'}),
        'barang'     => $barang,
        'margin'     => $nota->{'Margin (%)'},
        'tampilStok' => true,
        'tombol'     => 'Simpan Barang ke Nota',
    ])
  @else
    <div class="alert alert-warning">Belum ada barang yang tersedia. Barang harus diterima lewat penerimaan dulu sebelum bisa dijual.</div>
  @endif
@endif

<div class="card" style="max-width: 900px">
  <div class="card-header"><h5 class="card-title mb-0">Isi Nota</h5></div>
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-4"><small class="text-secondary">Tanggal</small><div class="fw-bold">{{ $nota->{'Tanggal Jual'} }}</div></div>
      <div class="col-md-4"><small class="text-secondary">Petugas</small><div class="fw-bold">{{ $nota->{'Petugas'} }}</div></div>
      <div class="col-md-4"><small class="text-secondary">Margin</small><div class="fw-bold">{{ $nota->{'Margin (%)'} }}%</div></div>
    </div>
    @include('partials.tabel', ['rows' => $detail, 'sembunyi' => ['No. Penjualan']])
  </div>
  <div class="card-footer text-end">
    Subtotal <b>{{ rupiah($nota->{'Subtotal'}) }}</b><br>
    PPN 11% <b>{{ rupiah($nota->{'PPN'}) }}</b><br>
    <span class="fs-5">Total <b>{{ rupiah($nota->{'Total'}) }}</b></span>
  </div>
</div>
@if (in_array(session('user_role'), [1, 2]))
  <a href="{{ route('penjualan.create') }}" class="btn btn-success mt-3"><i class="bi bi-cart-plus"></i> Penjualan Baru</a>
@endif
@endsection
