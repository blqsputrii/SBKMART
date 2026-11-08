<?php

namespace App\Http\Controllers;

use App\Models\DetailPenerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenerimaanController extends Controller
{
    public function index()
    {
        $detailList     = DetailPenerimaan::all();
        $penerimaanList = DB::table('penerimaan')->get();
        $barangList     = DB::table('barang')->get();
        return view('detail.detail-penerimaan', compact('detailList', 'penerimaanList', 'barangList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('detail_penerimaan')->max('iddetail_penerimaan') ?? 0;
        DB::table('detail_penerimaan')->insert([
            'iddetail_penerimaan' => $maxId + 1,
            'idpenerimaan'        => $request->idpenerimaan,
            'idbarang'            => $request->idbarang,
            'jumlah_terima'       => $request->jumlah_terima,
            'harga_satuan_terima' => $request->harga_satuan_terima,
            'sub_total_terima'    => $request->harga_satuan_terima * $request->jumlah_terima,
        ]);
        return redirect()->back()->with('success', 'Detail Penerimaan Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('detail_penerimaan')->where('iddetail_penerimaan', $id)->update([
            'idpenerimaan'        => $request->idpenerimaan,
            'idbarang'            => $request->idbarang,
            'jumlah_terima'       => $request->jumlah_terima,
            'harga_satuan_terima' => $request->harga_satuan_terima,
            'sub_total_terima'    => $request->harga_satuan_terima * $request->jumlah_terima,
        ]);
        return redirect()->back()->with('success', 'Detail Penerimaan Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_penerimaan')->where('iddetail_penerimaan', $id)->delete();
        return redirect()->back()->with('success', 'Detail Penerimaan Dihapus');
    }
}
