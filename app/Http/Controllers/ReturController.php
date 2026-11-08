<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
    public function index()
    {
        $returList      = Retur::all();
        $penerimaanList = DB::table('penerimaan')->get();
        $userList       = DB::table('user')->get();
        return view('retur.index', compact('returList', 'penerimaanList', 'userList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('retur')->max('idretur') ?? 0;
        DB::table('retur')->insert([
            'idretur'      => $maxId + 1,
            'idpenerimaan' => $request->idpenerimaan,
            'iduser'       => $request->iduser,
            'created_at'   => now(),
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('retur')->where('idretur', $id)->update([
            'idpenerimaan' => $request->idpenerimaan,
            'iduser'       => $request->iduser,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('retur')->where('idretur', $id)->delete();
            return redirect()->back()->with('success', 'Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Retur ini terhubung dengan rincian retur!');
        }
    }
}
