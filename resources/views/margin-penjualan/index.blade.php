@extends('layouts.app')

@section('title', 'Margin Penjualan')

@section('content')
<div class="alert alert-info">
 PPN 11%
</div>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Daftar Margin Penjualan</h5>
    <a href="{{ route('margin-penjualan.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Margin</a>
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $rows, 'aksiView' => 'margin-penjualan._aksi'])
  </div>
</div>
@endsection
