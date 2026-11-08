<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenerimaanController extends Controller
{
    public function index()
    {
        $detailList     = DB::table('v_detail_penerimaan')->get();
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
        ]);

        return redirect()->back()->with('success', 'Detail Penerimaan Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('detail_penerimaan')->where('iddetail_penerimaan', $id)->update([
            'idpenerimaan'        => $request->idpenerimaan,
            'idbarang'            => $request->idbarang,
            'jumlah_terima'       => $request->jumlah_terima,
            'harga_satuan_terima' => $request->harga_satuan_terima,
        ]);

        return redirect()->back()->with('success', 'Detail Penerimaan Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_penerimaan')->where('iddetail_penerimaan', $id)->delete();
        return redirect()->back()->with('success', 'Detail Penerimaan Berhasil Dihapus');
    }
}
