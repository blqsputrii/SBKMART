<?php

namespace App\Http\Controllers;

use App\Models\DetailRetur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailReturController extends Controller
{
    public function index()
    {
        $detailList     = DetailRetur::all();
        $returList      = DB::table('retur')->get();
        $penerimaanList = DB::table('detail_penerimaan')->get();
        return view('detail-retur.index', compact('detailList', 'returList', 'penerimaanList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('detail_retur')->max('iddetail_retur') ?? 0;
        DB::table('detail_retur')->insert([
            'iddetail_retur'      => $maxId + 1,
            'idretur'             => $request->idretur,
            'iddetail_penerimaan' => $request->iddetail_penerimaan,
            'jumlah'              => $request->jumlah,
            'alasan'              => $request->alasan,
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('detail_retur')->where('iddetail_retur', $id)->update([
            'idretur'             => $request->idretur,
            'iddetail_penerimaan' => $request->iddetail_penerimaan,
            'jumlah'              => $request->jumlah,
            'alasan'              => $request->alasan,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_retur')->where('iddetail_retur', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil Dihapus');
    }
}
