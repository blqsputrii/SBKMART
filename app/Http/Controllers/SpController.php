<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SpController extends Controller
{
    public function index()
    {
        $penjualan = [];
        $retur = [];

        try {
            $penjualan = DB::table('v_penjualan')->orderBy('Nomor Struk Penjualan', 'DESC')->limit(10)->get();
            $retur = DB::table('v_retur')->orderBy('Nomor Retur', 'DESC')->limit(10)->get();
        } catch (Exception $e) {

        }

        return view('detail.sp', compact('penjualan', 'retur'));
    }

    public function prosesPenjualan(Request $request)
    {
        $request->validate([
            'idpenjualan' => 'required|integer',
            'iduser'      => 'required|integer',
            'idbarang'    => 'required|integer',
            'jumlah'      => 'required|integer',
            'harga'       => 'required|numeric',
        ]);

        try {
            DB::statement('CALL sp_proses_penjualan_barang(?, ?, ?, ?, ?)', [
                $request->idpenjualan,
                $request->iduser,
                $request->idbarang,
                $request->jumlah,
                $request->harga
            ]);

            return redirect()->route('sp.index')->with('success', 'Stored Procedure sp_proses_penjualan_barang berhasil dieksekusi!');
        } catch (Exception $e) {
            return redirect()->route('sp.index')->with('error', 'Gagal memproses penjualan: ' . $e->getMessage());
        }
    }

    public function prosesRetur(Request $request)
    {
        $request->validate([
            'idretur'      => 'required|integer',
            'idpenerimaan' => 'required|integer',
            'iduser'       => 'required|integer',
            'idbarang'     => 'required|integer',
            'jumlah'       => 'required|integer',
        ]);

        try {
            DB::statement('CALL sp_proses_retur_barang(?, ?, ?, ?, ?)', [
                $request->idretur,
                $request->idpenerimaan,
                $request->iduser,
                $request->idbarang,
                $request->jumlah
            ]);

            return redirect()->route('sp.index')->with('success', 'Stored Procedure sp_proses_retur_barang berhasil dieksekusi!');
        } catch (Exception $e) {
            return redirect()->route('sp.index')->with('error', 'Gagal memproses retur: ' . $e->getMessage());
        }
    }
}
