@if ($r->{'Status'} !== 'Aktif')
  <form action="{{ route('margin-penjualan.aktifkan', $r->{'Kode Margin'}) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-toggle-on"></i> Aktifkan</button>
  </form>
@endif
@include('partials.aksi-ubah-hapus', ['rute' => 'margin-penjualan', 'id' => $r->{'Kode Margin'}, 'nama' => 'margin ' . $r->{'Margin (%)'} . '%'])
