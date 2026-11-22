<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KartuStokController extends Controller
{
    public function index(Request $request)
    {
        $barang = DB::select('SELECT `Kode Barang`, `Nama Barang` FROM v_barang ORDER BY `Nama Barang`');
        if ($request->filled('barang')) {
            $rows = DB::select('SELECT * FROM v_kartu_stok WHERE `Kode Barang` = ? ORDER BY `No. Kartu` DESC', [$request->barang]);
        } else {
            $rows = DB::select('SELECT * FROM v_kartu_stok ORDER BY `No. Kartu` DESC');
        }

        return view('kartu-stok.index', compact('rows', 'barang'));
    }
}
