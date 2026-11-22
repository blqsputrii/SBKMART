@php
  $uang     = ['Harga Dasar', 'Harga Satuan', 'Subtotal', 'PPN', 'Total'];
  $sembunyi = $sembunyi ?? [];
  $kolom    = count($rows) ? array_values(array_diff(array_keys((array) $rows[0]), $sembunyi)) : [];
@endphp
<div class="table-responsive">
  <table class="table table-striped table-hover align-middle mb-0">
    <thead class="table-light">
      <tr>
        @foreach ($kolom as $k)
          <th class="{{ in_array($k, $uang) ? 'text-end' : '' }}">{{ $k }}</th>
        @endforeach
        @isset($aksiView)<th class="text-end">Aksi</th>@endisset
      </tr>
    </thead>
    <tbody>
      @forelse ($rows as $r)
        <tr>
          @foreach ($kolom as $k)
            @php $v = $r->{$k}; @endphp
            @if (in_array($k, $uang))
              <td class="text-end">{{ rupiah($v) }}</td>
            @elseif ($k === 'Status')
              <td><span class="badge text-bg-{{ warna_status($v) }}">{{ $v }}</span></td>
            @else
              <td>{{ $v }}</td>
            @endif
          @endforeach
          @isset($aksiView)
            <td class="text-end text-nowrap">@include($aksiView, ['r' => $r])</td>
          @endisset
        </tr>
      @empty
        <tr><td colspan="{{ max(count($kolom), 1) + 1 }}" class="text-center text-secondary py-4">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
