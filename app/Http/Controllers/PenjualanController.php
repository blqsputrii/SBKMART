<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        try {
            $penjualanList = DB::table('v_penjualan')->get();
        } catch (\Exception $e) {
            $penjualanList = [];
        }

        return view('detail.penjualan', compact('penjualanList'));
    }

    public function create()
    {
        $userList = DB::table('user')->get();
        $marginList = DB::table('margin_penjualan')->get();
        $barangList = DB::table('barang')->get();

        return view('penjualan.create', compact('userList', 'marginList', 'barangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iduser' => 'required',
            'idmargin_penjualan' => 'required',
            'idbarang' => 'required',
            'jumlah_beli' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric',
        ]);

        try {
            DB::statement('CALL sp_proses_penjualan_barang(?, ?, ?, ?, ?)', [
                $request->input('iduser'),
                $request->input('idmargin_penjualan'),
                $request->input('idbarang'),
                $request->input('jumlah_beli'),
                $request->input('harga_satuan'),
            ]);

            return redirect()->route('penjualan.index')
                             ->with('success', 'Transaksi penjualan berhasil diproses!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal memproses penjualan: ' . $e->getMessage());
        }
    }
}
