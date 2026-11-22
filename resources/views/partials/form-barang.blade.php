<form action="{{ $action }}" method="POST">
  @csrf
  <div class="card mb-3">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
      <h5 class="card-title mb-0">Tambah Barang</h5>
      <div class="d-flex gap-2">
        <input type="search" id="cari" class="form-control form-control-sm" placeholder="Cari nama barang..." style="width:220px">
        <button type="button" class="btn btn-sm btn-outline-primary" id="tambah"><i class="bi bi-plus-lg"></i> Tambah Baris</button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="min-width:240px">Barang</th>
              @if ($tampilStok)<th class="text-end">Stok</th>@endif
              <th class="text-end">Harga Satuan</th>
              <th style="width:130px">Jumlah</th>
              <th class="text-end">Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="baris"></tbody>
          <tfoot>
            <tr class="fw-bold"><td colspan="{{ $tampilStok ? 4 : 3 }}" class="text-end">Subtotal </td><td class="text-end" id="t-sub">Rp 0</td><td></td></tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ $tombol }}</button>
    </div>
  </div>
</form>

@push('scripts')
<script>
  const barang = @json($barang);
  const margin = {{ $margin }};
  const tampilStok = {{ $tampilStok ? 'true' : 'false' }};
  let data = @json(old('items', [['idbarang' => '', 'jumlah' => 1]]));
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
  const harga = b => Math.round(b['Harga Dasar'] * (1 + margin / 100));
  const tbody = document.getElementById('baris');

  function opsi(terpilih) {
    const kata = document.getElementById('cari').value.toLowerCase();
    return barang
      .filter(b => b['Nama Barang'].toLowerCase().includes(kata) || b['Kode Barang'] == terpilih)
      .map(b => `<option value="${b['Kode Barang']}" ${b['Kode Barang'] == terpilih ? 'selected' : ''}>${b['Nama Barang']} (${b['Nama Satuan']})</option>`)
      .join('');
  }

  function render() {
    tbody.innerHTML = '';
    data.forEach((d, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><select name="items[${i}][idbarang]" class="form-select"><option value="">-- pilih barang --</option>${opsi(d.idbarang)}</select></td>
        ${tampilStok ? '<td class="text-end stok"></td>' : ''}
        <td class="text-end harga"></td>
        <td><input type="number" min="1" name="items[${i}][jumlah]" value="${d.jumlah}" class="form-control"></td>
        <td class="text-end sub"></td>
        <td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger hapus"><i class="bi bi-x-lg"></i></button></td>`;
      tr.querySelector('select').addEventListener('change', e => { data[i].idbarang = e.target.value; hitung(); });
      tr.querySelector('input').addEventListener('input', e => { data[i].jumlah = e.target.value; hitung(); });
      tr.querySelector('.hapus').addEventListener('click', () => { if (data.length > 1) { data.splice(i, 1); render(); } });
      tbody.appendChild(tr);
    });
    hitung();
  }

  function hitung() {
    let total = 0;
    [...tbody.children].forEach((tr, i) => {
      const b = barang.find(x => x['Kode Barang'] == data[i].idbarang);
      const jml = parseInt(data[i].jumlah) || 0;
      const sub = b ? harga(b) * jml : 0;
      if (tampilStok) tr.querySelector('.stok').textContent = b ? b['Stok'] : '-';
      tr.querySelector('.harga').textContent = b ? rp(harga(b)) : '-';
      tr.querySelector('.sub').textContent = rp(sub);
      if (tampilStok) tr.querySelector('input').max = b ? b['Stok'] : '';
      total += sub;
    });
    document.getElementById('t-sub').textContent = rp(total);
  }

  document.getElementById('tambah').addEventListener('click', () => { data.push({ idbarang: '', jumlah: 1 }); render(); });
  document.getElementById('cari').addEventListener('input', render);
  render();
</script>
@endpush
