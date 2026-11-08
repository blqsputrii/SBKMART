<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $detailList    = DetailPenjualan::all();
        $penjualanList = DB::table('penjualan')->get();
        $barangList    = DB::table('barang')->get();
        return view('detail.detail-penjualan', compact('detailList', 'penjualanList', 'barangList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('detail_penjualan')->max('iddetail_penjualan') ?? 0;
        DB::table('detail_penjualan')->insert([
            'iddetail_penjualan' => $maxId + 1,
            'idpenjualan'        => $request->idpenjualan,
            'idbarang'           => $request->idbarang,
            'harga_satuan'       => $request->harga_satuan,
            'jumlah'             => $request->jumlah,
            'subtotal'           => $request->harga_satuan * $request->jumlah,
        ]);
        return redirect()->back()->with('success', 'Detail Penjualan Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('detail_penjualan')->where('iddetail_penjualan', $id)->update([
            'idpenjualan'  => $request->idpenjualan,
            'idbarang'     => $request->idbarang,
            'harga_satuan' => $request->harga_satuan,
            'jumlah'       => $request->jumlah,
            'subtotal'     => $request->harga_satuan * $request->jumlah,
        ]);
        return redirect()->back()->with('success', 'Detail Penjualan Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_penjualan')->where('iddetail_penjualan', $id)->delete();
        return redirect()->back()->with('success', 'Detail Penjualan Dihapus');
    }
}
