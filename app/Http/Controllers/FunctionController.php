<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FunctionController extends Controller
{
    public function index(Request $request)
    {
        $omsetResult = DB::select("SELECT fn_hitung_total_penjualan() AS Omset");
        $omset = $omsetResult[0]->omset ?? 0;

        $idTerima = $request->get('idpenerimaan', 1);
        $batasHari = $request->get('batas_hari', 7);

        $returResult = DB::select("SELECT fn_cek_kelayakan_retur(?,?) AS status_retur", [$idTerima, $batasHari]);
        $statusRetur = $returResult[0]->status_retur ?? 'Tidak Diketahui';

        return view('function', compact('omset', 'statusRetur', 'idTerima', 'batasHari'));
    }
}
