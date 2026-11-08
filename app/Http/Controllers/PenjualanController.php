<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualanList = Penjualan::all();
        $userList      = DB::table('user')->get();
        $marginList    = DB::table('margin_penjualan')->get();
        return view('detail.penjualan', compact('penjualanList', 'userList', 'marginList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('penjualan')->max('idpenjualan') ?? 0;
        DB::table('penjualan')->insert([
            'idpenjualan'        => $maxId + 1,
            'iduser'             => $request->iduser,
            'idmargin_penjualan' => $request->idmargin_penjualan,
            'subtotal_nilai'     => $request->subtotal_nilai,
            'ppn'                => $request->ppn,
            'total_nilai'        => $request->total_nilai,
            'created_at'         => now(),
        ]);
        return redirect()->back()->with('success', 'Penjualan Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('penjualan')->where('idpenjualan', $id)->update([
            'iduser'             => $request->iduser,
            'idmargin_penjualan' => $request->idmargin_penjualan,
            'subtotal_nilai'     => $request->subtotal_nilai,
            'ppn'                => $request->ppn,
            'total_nilai'        => $request->total_nilai,
        ]);
        return redirect()->back()->with('success', 'Penjualan Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('penjualan')->where('idpenjualan', $id)->delete();
            return redirect()->back()->with('success', 'Penjualan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Penjualan terhubung dengan detail penjualan!');
        }
    }
}
