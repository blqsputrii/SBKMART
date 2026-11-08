<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FunctionController extends Controller
{
    public function index(Request $request)
    {
        $hasilCek = null;
        $idpenerimaan = $request->input('idpenerimaan');
        $batasHari = $request->input('batas_hari', 7);

        if ($request->isMethod('post') && $idpenerimaan) {
            try {
                $result = DB::select('SELECT fn_cek_kelayakan_retur(?, ?) AS status_kelayakan', [
                    $idpenerimaan,
                    $batasHari
                ]);

                $hasilCek = $result[0]->status_kelayakan ?? 'Tidak Diketahui';
            } catch (Exception $e) {
                $hasilCek = 'Error: ' . $e->getMessage();
            }
        }

        return view('detail.function', compact('hasilCek', 'idpenerimaan', 'batasHari'));
    }
}
