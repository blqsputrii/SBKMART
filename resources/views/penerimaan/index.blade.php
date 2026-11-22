@extends('layouts.app')

@section('title', 'Penerimaan')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Daftar Penerimaan Barang</h5>
    @if (in_array(session('user_role'), [1, 3]))
      <a href="{{ route('penerimaan.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Penerimaan Baru</a>
    @endif
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $rows, 'aksiView' => 'penerimaan._aksi'])
  </div>
</div>
@endsection
