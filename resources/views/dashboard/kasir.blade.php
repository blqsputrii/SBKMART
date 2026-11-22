@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="small-box text-bg-success">
      <div class="inner"><h3>{{ $hariIni->jumlah }}</h3><p>Transaksi Saya Hari Ini</p></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="small-box text-bg-primary">
      <div class="inner"><h3>{{ rupiah($hariIni->total ?? 0) }}</h3><p>Total Penjualan Hari Ini</p></div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="small-box text-bg-info">
      <div class="inner">
        <h3>{{ count($margin) ? $margin[0]->persen . '%' : '-' }}</h3>
        <p>Margin Aktif &middot; PPN 11%</p>
      </div>
    </div>
  </div>
</div>

<a href="{{ route('penjualan.create') }}" class="btn btn-success btn-lg mb-3">
  <i class="bi bi-cart-plus"></i> Mulai Penjualan Baru
</a>

<div class="card">
  <div class="card-header"><h5 class="card-title mb-0">5 Transaksi Terakhir Saya</h5></div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $terakhir])
  </div>
</div>
@endsection
