<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Trigger - SBKMART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #FFFFFF 0%, #F1F5F9 100%);
            color: #0F172A;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        .card-custom {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .btn-teal {
            background-color: #0D9488;
            color: #FFFFFF;
            font-weight: 600;
        }
        .btn-teal:hover {
            background-color: #0f766e;
            color: #FFFFFF;
        }
        .table-custom {
            color: #0F172A;
        }
        .table-custom th {
            background-color: #F8FAFC;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid #E2E8F0;
        }
        .nav-link-custom {
            color: #64748B;
            font-weight: 500;
        }
        .nav-link-custom.active {
            background-color: #0D9488 !important;
            color: #FFFFFF !important;
        }
    </style>
</head>
<body class="py-4">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: #0F172A;">STOK BARANG</h3>
            <p class="text-muted mb-0 small">Sistem Manajemen Inventaris & Penjualan SBKMART</p>
        </div>
        <div class="btn-group bg-white p-1 rounded-3 border">
            <a href="{{ route('sp.index') }}" class="btn btn-sm nav-link-custom">Stored Procedure</a>
            <a href="{{ route('function.index') }}" class="btn btn-sm nav-link-custom">Function</a>
            <a href="{{ route('trigger.index') }}" class="btn btn-sm nav-link-custom active">Trigger</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #DCFCE7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="color: #0D9488;">Input Mutasi</h5>
                <form action="{{ route('trigger.simulasi') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Barang</label>
                        <input type="number" name="idbarang" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">Jenis Transaksi</label>
                        <select name="jenis_transaksi" class="form-select" required>
                            <option value="PENERIMAAN">PENERIMAAN</option>
                            <option value="PENJUALAN">PENJUALAN</option>
                            <option value="RETUR">RETUR</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">Jumlah Masuk</label>
                        <input type="number" name="masuk" class="form-control" value="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Jumlah Keluar</label>
                        <input type="number" name="keluar" class="form-control" value="0" required>
                    </div>
                    <button type="submit" class="btn btn-teal w-100 py-2">Mutasi</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="color: #0D9488;">Log Riwayat Stok</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom">
                        <thead>
                            <tr>
                                <th class="text-center">ID KARTU</th>
                                <th class="text-center">ID BARANG</th>
                                <th class="text-center">JENIS</th>
                                <th class="text-center">MASUK</th>
                                <th class="text-center">KELUAR</th>
                                <th class="text-center text-white" style="background-color: #0D9488;">STOCK (AUTO)</th>
                                <th class="text-center">WAKTU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kartuStok as $row)
                                <tr>
                                    <td class="text-center">{{ $row->idkartu_stok }}</td>
                                    <td class="text-center">{{ $row->idbarang }}</td>
                                    <td class="text-center"><span class="badge bg-light text-dark border">{{ $row->jenis_transaksi }}</span></td>
                                    <td class="text-center text-success fw-bold">{{ $row->masuk }}</td>
                                    <td class="text-center text-danger fw-bold">{{ $row->keluar }}</td>
                                    <td class="text-center fw-bold" style="color: #0D9488; font-size: 1.05rem;">{{ $row->stock }}</td>
                                    <td class="text-center small text-muted">{{ $row->created_at }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">Belum ada mutasi stok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
