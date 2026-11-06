<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpController extends Controller
{
    public function index()
    {
        return view('sp');
    }

    public function prosesPenjualan(Request $request)
    {
        try {
            DB::statement("CALL sp_proses_penjualan_barang(?, ?, ?, ?, ?)", [
                $request->idpenjualan,
                $request->iduser,
                $request->idbarang,
                $request->jumlah,
                $request->harga_satuan
            ]);

            return redirect()->back()->with('succes', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('eror', 'Gagal: ' . $e->getMessage());
        }
    }

    public function prosesRetur(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            return redirect()->back()->with('error', 'Akses Ditolak');
        }

        try {
            DB::statement("CALL sp_proses_retur_barang(?, ?, ?, ?, ?)", [
                $request->idretur,
                $request->idpenerimaan,
                $request->iduser,
                $request->idbarang,
                $request->jumlah
            ]);

            return redirect()->back()->with('succes', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('eror', 'Gagal: ' . $e->getMessage());
        }
    }
}
