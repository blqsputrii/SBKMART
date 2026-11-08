<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $barangList = Barang::all();
        $satuanList = DB::table('satuan')->where('status', 1)->get();
        return view('barang.index', compact('barangList', 'satuanList'));
    }

    public function store(Request $request)
    {
    $maxId = DB::table('barang')->max('idbarang') ?? 0;
    $newId = $maxId + 1;

    DB::table('barang')->insert([
        'idbarang' => $newId,
        'idsatuan' => $request->idsatuan,
        'jenis'    => $request->jenis,
        'nama'     => $request->nama,
        'harga'    => $request->harga,
        'status'   => $request->status,
    ]);

    return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }
    public function update(Request $request, $id)
    {
        DB::table('barang')->where('idbarang', $id)->update([
            'idsatuan' => $request->idsatuan,
            'jenis'    => $request->jenis,
            'nama'     => $request->nama,
            'harga'    => $request->harga,
            'status'   => $request->status,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('barang')->where('idbarang', $id)->delete();
        return redirect()->back()->with('success', 'Barang Berhasil Dihapus');
    }
}
