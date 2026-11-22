@extends('layouts.app')

@section('title', 'Penerimaan No. ' . $nota->{'No. Penerimaan'})

@section('content')
<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"><small class="text-secondary">No. Pengadaan</small>
        <div class="fw-bold"><a href="{{ route('pengadaan.show', $nota->{'No. Pengadaan'}) }}">{{ $nota->{'No. Pengadaan'} }}</a></div></div>
      <div class="col-md-3"><small class="text-secondary">Tanggal Terima</small><div class="fw-bold">{{ $nota->{'Tanggal Terima'} }}</div></div>
      <div class="col-md-3"><small class="text-secondary">Petugas</small><div class="fw-bold">{{ $nota->{'Petugas'} }}</div></div>
      <div class="col-md-3"><small class="text-secondary">Status</small>
        <div><span class="badge text-bg-{{ warna_status($nota->{'Status'}) }}">{{ $nota->{'Status'} }}</span></div></div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header"><h5 class="card-title mb-0">Barang yang Diterima</h5></div>
  <div class="card-body p-0">
    @if (in_array(session('user_role'), [1, 3]))
      @include('partials.tabel', ['rows' => $detail, 'sembunyi' => ['No. Penerimaan'], 'aksiView' => 'penerimaan._aksi-detail'])
    @else
      @include('partials.tabel', ['rows' => $detail, 'sembunyi' => ['No. Penerimaan']])
    @endif
  </div>
</div>
@endsection
