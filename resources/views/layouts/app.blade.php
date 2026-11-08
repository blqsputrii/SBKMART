<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SBKMART System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --navy-dark: #1E293B;
            --teal-brand: #0D9488;
            --amber-accent: #F59E0B;
            --blue-action: #2563EB;
            --blue-soft: #D1E8EE;
            --bg-offwhite: #F8FAFC;
        }
        body {
            background-color: var(--bg-offwhite);
            color: var(--navy-dark);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: var(--navy-dark);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #FFFFFF !important;
        }
        .navbar-custom .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .dropdown-item:hover {
            background-color: var(--blue-soft);
            color: var(--navy-dark);
        }
        .card-custom {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .btn-blue {
            background-color: var(--blue-action);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-blue:hover { background-color: #1d4ed8; color: #FFFFFF; }

        .btn-teal {
            background-color: var(--teal-brand);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-teal:hover { background-color: #0f766e; color: #FFFFFF; }

        .table-custom th {
            background-color: var(--blue-soft);
            color: var(--navy-dark);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('barang.index') }}">
            <i class="bi bi-shop me-2" style="color: var(--amber-accent);"></i>SBKMART
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-database-fill me-1"></i> Data Master
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('barang.index') }}"><i class="bi bi-box-seam me-2"></i>Katalog Produk</a></li>
                        <li><a class="dropdown-item" href="{{ route('satuan.index') }}"><i class="bi bi-tag me-2"></i> Satuan Kemasan</a></li>
                        <li><a class="dropdown-item" href="{{ route('vendor.index') }}"><i class="bi bi-truck me-2"></i> Data Pemasok</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.index') }}"><i class="bi bi-people me-2"></i> Akun Pengguna</a></li>
                        <li><a class="dropdown-item" href="{{ route('role.index') }}"><i class="bi bi-person-badge me-2"></i> Peran Sistem</a></li>
                        <li><a class="dropdown-item" href="{{ route('margin-penjualan.index') }}"><i class="bi bi-percent me-2"></i> Margin Keuntungan</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-cart-check-fill me-1"></i> Transaksi Utama
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('pengadaan.index') }}"><i class="bi bi-bag-plus me-2"></i> Pengadaan Barang</a></li>
                        <li><a class="dropdown-item" href="{{ route('penerimaan.index') }}"><i class="bi bi-box-arrow-in-down me-2"></i> Penerimaan Gudang</a></li>
                        <li><a class="dropdown-item" href="{{ route('penjualan.index') }}"><i class="bi bi-receipt me-2"></i> Penjualan Kasir</a></li>
                        <li><a class="dropdown-item" href="{{ route('retur.index') }}"><i class="bi bi-arrow-return-left me-2"></i> Retur Pengembalian</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-journal-text me-1"></i> Detail & Mutasi
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('detail-pengadaan.index') }}">Detail Pengadaan</a></li>
                        <li><a class="dropdown-item" href="{{ route('detail-penerimaan.index') }}">Detail Penerimaan</a></li>
                        <li><a class="dropdown-item" href="{{ route('detail-penjualan.index') }}">Detail Penjualan</a></li>
                        <li><a class="dropdown-item" href="{{ route('detail-retur.index') }}">Detail Retur</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold" href="{{ route('kartu-stok.index') }}"><i class="bi bi-card-checklist me-2 text-teal"></i> Kartu Stok Mutasi</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #DCFCE7; color: #166534;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
