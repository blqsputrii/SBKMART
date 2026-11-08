<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaanList = Penerimaan::all();
        $pengadaanList  = DB::table('pengadaan')->get();
        $userList       = DB::table('user')->get();
        return view('penerimaan.index', compact('penerimaanList', 'pengadaanList', 'userList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('penerimaan')->max('idpenerimaan') ?? 0;
        DB::table('penerimaan')->insert([
            'idpenerimaan' => $maxId + 1,
            'idpengadaan'  => $request->idpengadaan,
            'iduser'       => $request->iduser,
            'status'       => $request->status ?? 1,
            'created_at'   => now(),
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('penerimaan')->where('idpenerimaan', $id)->update([
            'idpengadaan' => $request->idpengadaan,
            'iduser'      => $request->iduser,
            'status'      => $request->status,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('penerimaan')->where('idpenerimaan', $id)->delete();
            return redirect()->back()->with('success', 'Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Penerimaan ini terhubung dengan detail penerimaan atau retur!');
        }
    }
}
