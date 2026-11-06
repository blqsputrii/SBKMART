<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Stored Procedure - SBKMART</title>
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
            border-radius: 8px;
        }
        .btn-teal:hover {
            background-color: #0f766e;
            color: #FFFFFF;
        }
        .btn-amber {
            background-color: #D97706;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-amber:hover {
            background-color: #b45309;
            color: #FFFFFF;
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
            <h3 class="fw-bold mb-1" style="color: #0F172A;">PENGUJIAN STORED PROCEDURE</h3>
            <p class="text-muted mb-0 small">Sistem Manajemen Inventaris & Penjualan SBKMART</p>
        </div>
        <div class="btn-group bg-white p-1 rounded-3 border">
            <a href="{{ route('sp.index') }}" class="btn btn-sm nav-link-custom active">Stored Procedure</a>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('function.index') }}" class="btn btn-sm nav-link-custom">Function</a>
                <a href="{{ route('trigger.index') }}" class="btn btn-sm nav-link-custom">Trigger</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #DCFCE7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="background-color: #FEE2E2; color: #991B1B;">
            {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-{{ (auth()->check() && auth()->user()->isAdmin()) ? '6' : '12' }}">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="color: #0D9488;">CALL sp_proses_penjualan_barang</h5>
                <form action="{{ route('sp.penjualan') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Penjualan</label>
                        <input type="number" name="idpenjualan" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID User (Kasir)</label>
                        <input type="number" name="iduser" value="{{ auth()->check() ? auth()->user()->iduser : 2 }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Barang</label>
                        <input type="number" name="idbarang" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">Jumlah Beli</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Harga Satuan</label>
                        <input type="number" name="harga_satuan" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-teal w-100 py-2">Eksekusi SP Penjualan</button>
                </form>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
        <div class="col-md-6">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="color: #D97706;">CALL sp_proses_retur_barang</h5>
                <form action="{{ route('sp.retur') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Retur</label>
                        <input type="number" name="idretur" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Penerimaan</label>
                        <input type="number" name="idpenerimaan" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID User (Admin)</label>
                        <input type="number" name="iduser" value="{{ auth()->user()->iduser }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">ID Barang</label>
                        <input type="number" name="idbarang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Jumlah Retur</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-amber w-100 py-2">Eksekusi SP Retur</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

</body>
</html>
