<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Function - SBKMART</title>
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
        .hasil-box {
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 20px;
            border-radius: 10px;
        }
        .btn-teal {
            background-color: #0D9488;
            color: #FFFFFF;
            font-weight: 600;
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
            <h3 class="fw-bold mb-1" style="color: #0F172A;">PENGUJIAN FUNCTION</h3>
            <p class="text-muted mb-0 small">Sistem Manajemen Inventaris & Penjualan SBKMART</p>
        </div>
        <div class="btn-group bg-white p-1 rounded-3 border">
            <a href="{{ route('sp.index') }}" class="btn btn-sm nav-link-custom">Stored Procedure</a>
            <a href="{{ route('function.index') }}" class="btn btn-sm nav-link-custom active">Function</a>
            <a href="{{ route('trigger.index') }}" class="btn btn-sm nav-link-custom">Trigger</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card-custom h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-2" style="color: #0D9488;">fn_hitung_total_penjualan_hari_ini()</h5>
                    <p class="text-muted small mb-4">Menghitung akumulasi total omset penjualan.</p>
                </div>
                <div class="hasil-box text-center my-auto">
                    <span class="text-muted small">Total Omset Hari Ini</span><br>
                    <span class="fw-bold text-success display-6">Rp {{ number_format($omset, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-custom">
                <h5 class="fw-bold mb-2" style="color: #0D9488;">fn_cek_kelayakan_retur()</h5>
                <p class="text-muted small mb-3">Mengevaluasi kelayakan retur berdasarkan tanggal penerimaan.</p>
                <form action="{{ route('function.index') }}" method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small text-muted">ID Penerimaan</label>
                            <input type="number" name="idpenerimaan" class="form-control" value="{{ $idTerima }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Batas Garansi (Hari)</label>
                            <input type="number" name="batas_hari" class="form-control" value="{{ $batasHari }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-teal w-100 mt-3 py-2">Cek Status Retur</button>
                </form>

                <div class="hasil-box text-center">
                    <span class="text-muted small">Status Garansi Retur</span><br>
                    <span class="fw-bold {{ $statusRetur == 'LAYAK' ? 'text-success' : 'text-danger' }} display-6">
                        {{ $statusRetur }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
