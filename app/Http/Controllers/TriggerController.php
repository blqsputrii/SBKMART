<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriggerController extends Controller
{
    public function index()
    {
        $kartuStok = DB::table('kartu_stok')->orderBy('idkartu_stok', 'desc')->limit(10)->get();
        return view('trigger', compact('kartuStok'));
    }

    public function simulasikan(Request $request)
    {
        DB::table('kartu_stok')->insert([
            'idbarang' => $request->idbarang,
            'jenis_transaksi' => $request->jenis_transaksi,
            'masuk' => $request->masuk,
            'keluar' => $request->keluar,
            'created_at' => now()
        ]);

        return redirect()->back()->with('success', 'Berhasil');
    }
}
