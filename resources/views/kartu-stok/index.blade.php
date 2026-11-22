@extends('layouts.app')

@section('title', 'Kartu Stok')

@section('content')
<div class="alert alert-info">
  Kartu stok
</div>
<div class="card">
  <div class="card-header">
    <form action="{{ route('kartu-stok.index') }}" method="GET" class="row g-2">
      <div class="col-md-5">
        <select name="barang" class="form-select" onchange="this.form.submit()">
          <option value="">Semua barang</option>
          @foreach ($barang as $b)
            <option value="{{ $b->{'Kode Barang'} }}" @selected(request('barang') == $b->{'Kode Barang'})>{{ $b->{'Nama Barang'} }}</option>
          @endforeach
        </select>
      </div>
    </form>
  </div>
  <div class="card-body p-0">
    @include('partials.tabel', ['rows' => $rows])
  </div>
</div>
@endsection
