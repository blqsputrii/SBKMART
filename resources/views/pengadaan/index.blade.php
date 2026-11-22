@extends('layouts.app')

@section('title', 'Pengadaan')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Nota Belanja Vendor</h5>
    @if (in_array(session('user_role'), [1, 3]))
      <a href="{{ route('pengadaan.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Pengadaan Baru</a>
    @endif
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $rows, 'sembunyi' => ['Kode Vendor'], 'aksiView' => 'pengadaan._aksi'])
  </div>
</div>
@endsection
