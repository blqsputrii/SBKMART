<?php

namespace App\Http\Controllers;

use App\Models\satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function index()
    {
        $satuanList = satuan::all();
        return view('layouts.satuan', compact('satuanList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('satuan')->max('idsatuan') ?? 0;
        DB::table('satuan')->insert([
            'idsatuan'    => $maxId + 1,
            'nama_satuan' => $request->nama_satuan,
            'status'      => $request->status,
        ]);
        return redirect()->back()->with('success', 'Satuan Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('satuan')->where('idsatuan', $id)->update([
            'nama_satuan' => $request->nama_satuan,
            'status'      => $request->status,
        ]);
        return redirect()->back()->with('success', 'Satuan Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('satuan')->where('idsatuan', $id)->delete();
            return redirect()->back()->with('success', 'Satuan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Satuan ini masih digunakan di produk!');
        }
    }
}
