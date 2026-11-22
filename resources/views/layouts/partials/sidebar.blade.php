@php
  $role = (int) session('user_role');
  $aktif = fn ($pola) => request()->routeIs($pola) ? 'active' : '';
@endphp
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <i class="bi bi-basket3-fill ms-3 me-2"></i><span class="brand-text fw-light">SBKMART</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ $aktif('dashboard') }}">
            <i class="nav-icon bi bi-speedometer"></i><p>Dashboard</p>
          </a>
        </li>

        @if (in_array($role, [1, 2]))
          <li class="nav-header">PENJUALAN</li>
          <li class="nav-item">
            <a href="{{ route('penjualan.create') }}" class="nav-link {{ $aktif('penjualan.create') }}">
              <i class="nav-icon bi bi-cart-plus"></i><p>Penjualan Baru</p>
            </a>
          </li>
        @endif
        @if (in_array($role, [1, 2, 4, 5]))
          <li class="nav-item">
            <a href="{{ route('penjualan.index') }}" class="nav-link {{ $aktif('penjualan.index') }}">
              <i class="nav-icon bi bi-receipt"></i><p>Riwayat Penjualan</p>
            </a>
          </li>
        @endif

        @if (in_array($role, [1, 3, 4, 5]))
          <li class="nav-header">PERSEDIAAN</li>
          <li class="nav-item">
            <a href="{{ route('pengadaan.index') }}" class="nav-link {{ $aktif('pengadaan.*') }}">
              <i class="nav-icon bi bi-bag-plus"></i><p>Pengadaan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('penerimaan.index') }}" class="nav-link {{ $aktif('penerimaan.*') }}">
              <i class="nav-icon bi bi-box-seam"></i><p>Penerimaan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('kartu-stok.index') }}" class="nav-link {{ $aktif('kartu-stok.*') }}">
              <i class="nav-icon bi bi-journal-text"></i><p>Kartu Stok</p>
            </a>
          </li>
        @endif

        <li class="nav-header">BARANG</li>
        <li class="nav-item">
          <a href="{{ route('barang.index') }}" class="nav-link {{ $aktif('barang.*') }}">
            <i class="nav-icon bi bi-box"></i><p>Daftar Barang</p>
          </a>
        </li>

        @if ($role == 1)
          <li class="nav-header">DATA MASTER</li>
          <li class="nav-item">
            <a href="{{ route('satuan.index') }}" class="nav-link {{ $aktif('satuan.*') }}">
              <i class="nav-icon bi bi-rulers"></i><p>Satuan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('vendor.index') }}" class="nav-link {{ $aktif('vendor.*') }}">
              <i class="nav-icon bi bi-truck"></i><p>Vendor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('margin-penjualan.index') }}" class="nav-link {{ $aktif('margin-penjualan.*') }}">
              <i class="nav-icon bi bi-percent"></i><p>Margin Penjualan</p>
            </a>
          </li>
          <li class="nav-header">PENGGUNA</li>
          <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ $aktif('user.*') }}">
              <i class="nav-icon bi bi-people"></i><p>Pengguna</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('role.index') }}" class="nav-link {{ $aktif('role.*') }}">
              <i class="nav-icon bi bi-shield-lock"></i><p>Role</p>
            </a>
          </li>
        @endif
      </ul>
    </nav>
  </div>
</aside>
