<?php

namespace App\Http\Controllers;

use App\Models\DetailPengadaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPengadaanController extends Controller
{
    public function index()
    {
        $detailList    = DetailPengadaan::all();
        $pengadaanList = DB::table('pengadaan')->get();
        $barangList    = DB::table('barang')->get();
        return view('detail-pengadaan.index', compact('detailList', 'pengadaanList', 'barangList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('detail_pengadaan')->max('iddetail_pengadaan') ?? 0;
        DB::table('detail_pengadaan')->insert([
            'iddetail_pengadaan' => $maxId + 1,
            'idpengadaan'        => $request->idpengadaan,
            'idbarang'           => $request->idbarang,
            'harga_satuan'       => $request->harga_satuan,
            'jumlah'             => $request->jumlah,
            'sub_total'          => $request->harga_satuan * $request->jumlah,
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('detail_pengadaan')->where('iddetail_pengadaan', $id)->update([
            'idpengadaan'  => $request->idpengadaan,
            'idbarang'     => $request->idbarang,
            'harga_satuan' => $request->harga_satuan,
            'jumlah'       => $request->jumlah,
            'sub_total'    => $request->harga_satuan * $request->jumlah,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_pengadaan')->where('iddetail_pengadaan', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil Dihapus');
    }
}
