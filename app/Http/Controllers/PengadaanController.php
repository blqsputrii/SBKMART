<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaanList = Pengadaan::all();
        $vendorList    = DB::table('vendor')->get();
        $userList      = DB::table('user')->get();
        return view('pengadaan.index', compact('pengadaanList', 'vendorList', 'userList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('pengadaan')->max('idpengadaan') ?? 0;
        DB::table('pengadaan')->insert([
            'idpengadaan'    => $maxId + 1,
            'iduser'         => $request->iduser,
            'idvendor'       => $request->idvendor,
            'subtotal_nilai' => $request->subtotal_nilai,
            'ppn'            => $request->ppn,
            'total_nilai'    => $request->total_nilai,
            'status'         => $request->status ?? 'P',
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('pengadaan')->where('idpengadaan', $id)->update([
            'iduser'         => $request->iduser,
            'idvendor'       => $request->idvendor,
            'subtotal_nilai' => $request->subtotal_nilai,
            'ppn'            => $request->ppn,
            'total_nilai'    => $request->total_nilai,
            'status'         => $request->status,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('pengadaan')->where('idpengadaan', $id)->delete();
            return redirect()->back()->with('success', 'Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Pengadaan ini terhubung dengan rincian atau penerimaan!');
        }
    }
}
