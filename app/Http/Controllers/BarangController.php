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
        $satuanList = DB::table('satuan')->get();
        return view('layouts.barang', compact('barangList', 'satuanList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('barang')->max('idbarang') ?? 0;
        DB::table('barang')->insert([
            'idbarang' => $maxId + 1,
            'idsatuan' => $request->idsatuan,
            'jenis'    => $request->jenis,
            'nama'     => $request->nama,
            'harga'    => $request->harga,
            'status'   => $request->status,
        ]);
        return redirect()->back()->with('success', 'Barang Berhasil Ditambahkan');
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
        return redirect()->back()->with('success', 'Barang Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('barang')->where('idbarang', $id)->delete();
            return redirect()->back()->with('success', 'Barang Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Barang ini pernah digunakan dalam transaksi!');
        }
    }
}
