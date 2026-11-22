@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-md-3 col-6">
    <div class="small-box text-bg-primary">
      <div class="inner"><h3>{{ $jumlahBarang }}</h3><p>Jenis Barang</p></div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="small-box text-bg-warning">
      <div class="inner"><h3>{{ $pengadaanBuka }}</h3><p>Pengadaan Belum Lengkap</p></div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="small-box text-bg-success">
      <div class="inner"><h3>{{ $hariIni->jumlah }}</h3><p>Penjualan Hari Ini {{ rupiah($hariIni->total ?? 0) }}</p></div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="small-box text-bg-info">
      <div class="inner">
        <h3>{{ count($margin) ? $margin[0]->persen . '%' : '-' }}</h3>
        <p>Margin Aktif &middot; PPN 11%</p>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header"><h5 class="card-title mb-0">Stok Menipis</h5></div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $stokMenipis])
  </div>
</div>
@endsection
