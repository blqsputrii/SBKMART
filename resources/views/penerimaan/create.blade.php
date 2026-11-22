@extends('layouts.app')

@section('title', 'Penerimaan Baru')

@section('content')
<div class="card mb-3">
  <div class="card-header"><h5 class="card-title mb-0">1. Pilih Nota Pengadaan</h5></div>
  <div class="card-body">
    <form action="{{ route('penerimaan.create') }}" method="GET" class="row g-2">
      <div class="col-md-8">
        <select name="pengadaan" class="form-select" onchange="this.form.submit()">
          <option value="">-- pilih pengadaan yang belum diterima utuh --</option>
          @foreach ($pengadaan as $p)
            <option value="{{ $p->{'No. Pengadaan'} }}" @selected(request('pengadaan') == $p->{'No. Pengadaan'})>
              No. {{ $p->{'No. Pengadaan'} }} &middot; {{ $p->{'Nama Vendor'} }} &middot; {{ $p->{'Tanggal Pesan'} }} &middot; {{ $p->{'Status'} }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4"><button class="btn btn-outline-primary">Tampilkan</button></div>
    </form>
    @if ($pengadaan == [])
      <p class="text-secondary mt-2 mb-0">Tidak ada pengadaan yang menunggu penerimaan.</p>
    @endif
  </div>
</div>

@if ($nota)
<form action="{{ route('penerimaan.store') }}" method="POST">
  @csrf
  <input type="hidden" name="pengadaan" value="{{ $nota->{'No. Pengadaan'} }}">
  <div class="card">
    <div class="card-header"><h5 class="card-title mb-0">2. Jumlah Diterima &middot; Pengadaan No. {{ $nota->{'No. Pengadaan'} }} ({{ $nota->{'Nama Vendor'} }})</h5></div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr><th>Barang</th><th class="text-end">Harga Satuan</th><th class="text-end">Dipesan</th><th class="text-end">Sudah Diterima</th><th class="text-end">Sisa</th><th style="width:160px">Diterima Sekarang</th></tr>
          </thead>
          <tbody>
            @foreach ($detail as $d)
              @php $sisa = $d->{'Jumlah Pesan'} - $d->{'Jumlah Diterima'}; @endphp
              <tr>
                <td>{{ $d->{'Nama Barang'} }}</td>
                <td class="text-end">{{ rupiah($d->{'Harga Satuan'}) }}</td>
                <td class="text-end">{{ $d->{'Jumlah Pesan'} }}</td>
                <td class="text-end">{{ $d->{'Jumlah Diterima'} }}</td>
                <td class="text-end">{{ $sisa }}</td>
                <td>
                  @if ($sisa > 0)
                    <input type="number" min="0" max="{{ $sisa }}" name="jumlah[{{ $d->{'Kode Barang'} }}]"
                           value="{{ old('jumlah.' . $d->{'Kode Barang'}, 0) }}" class="form-control">
                  @else
                    <span class="badge text-bg-success">Sudah penuh</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <p class="text-secondary">Isi 0 untuk barang yang belum datang. Harga mengikuti nota pengadaan. Stok dan status pengadaan diperbarui otomatis.</p>
      <button type="submit" class="btn btn-success"><i class="bi bi-box-seam"></i> Simpan Penerimaan</button>
      <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </div>
</form>
@endif
@endsection
