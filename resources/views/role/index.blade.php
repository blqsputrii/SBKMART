@extends('layouts.app')

@section('title', 'Role')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">Daftar Jabatan</h5>
    @if (session('user_role') == 1)
      <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Jabatan</a>
    @endif
  </div>
  <div class="card-body p-0">
    @if (session('user_role') == 1)
      @include('partials.tabel', ['rows' => $rows, 'sembunyi' => [], 'aksiView' => 'role._aksi'])
    @else
      @include('partials.tabel', ['rows' => $rows, 'sembunyi' => []])
    @endif
  </div>
</div>
@endsection
