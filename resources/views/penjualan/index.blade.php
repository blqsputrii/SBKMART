@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Daftar Penjualan</h5>
    @if (in_array(session('user_role'), [1, 2]))
      <a href="{{ route('penjualan.create') }}" class="btn btn-success btn-sm"><i class="bi bi-cart-plus"></i> Penjualan Baru</a>
    @endif
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $rows, 'aksiView' => 'penjualan._aksi'])
  </div>
</div>
@endsection
