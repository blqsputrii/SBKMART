@extends('layouts.app')

@section('title', 'Penjualan Baru')

@section('content')
<div class="card" style="max-width: 640px">
  <form action="{{ route('penjualan.store') }}" method="POST">
    @csrf
    <div class="card-header"><h5 class="card-title mb-0">Mulai Penjualan</h5></div>
    <div class="card-body">
      @if (count($margin) == 1)
        <p>Margin penjualan aktif: <b>{{ $margin[0]->persen }}%</b>.</p>
      @else
        <div class="alert alert-warning mb-0">Belum ada margin penjualan yang aktif. Hubungi admin sebelum melakukan penjualan.</div>
      @endif
    </div>
    @if (count($margin) == 1)
      <div class="card-footer">
        <button type="submit" class="btn btn-success"><i class="bi bi-arrow-right-circle"></i> Buat Nota Penjualan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
      </div>
    @endif
  </form>
</div>
@endsection
