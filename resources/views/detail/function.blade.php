@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #F8FAFC; min-height: 80vh;">
    <h2 class="mb-4 font-weight-bold" style="color: #1E293B;">Database Function: Cek Kelayakan Retur</h2>

    <div class="card shadow-sm border-0 mb-4" style="background-color: #FFFFFF;">
        <div class="card-header text-white" style="background-color: #2563EB;">
            <h5 class="mb-0">Form Pengecekan Kelayakan Retur</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('function.index') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label font-weight-bold">Nomor Surat Penerimaan</label>
                        <input type="number" name="idpenerimaan" class="form-control" value="{{ $idpenerimaan ?? '' }}" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label font-weight-bold">Batas Hari Maksimal</label>
                        <input type="number" name="batas_hari" class="form-control" value="{{ $batasHari ?? 7 }}" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end mb-3">
                        <button type="submit" class="btn text-white w-100 font-weight-bold shadow-sm" style="background-color: #0D9488;">Cek Status</button>
                    </div>
                </div>
            </form>

            @if(isset($hasilCek))
                <div class="alert mt-3 {{ str_contains($hasilCek, 'Bisa') ? 'alert-success' : 'alert-warning' }}">
                    <strong>Hasil Validasi Function:</strong> {{ $hasilCek }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
