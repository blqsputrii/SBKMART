<?php

namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    public function index()
    {
        $marginList = MarginPenjualan::all();
        $userList   = DB::table('user')->get();
        return view('layouts.margin-penjualan', compact('marginList', 'userList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('margin_penjualan')->max('idmargin_penjualan') ?? 0;
        DB::table('margin_penjualan')->insert([
            'idmargin_penjualan' => $maxId + 1,
            'iduser'             => $request->iduser,
            'persen'             => $request->persen,
            'status'             => $request->status,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
        return redirect()->back()->with('success', 'Margin Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('margin_penjualan')->where('idmargin_penjualan', $id)->update([
            'iduser'     => $request->iduser,
            'persen'     => $request->persen,
            'status'     => $request->status,
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Margin Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('margin_penjualan')->where('idmargin_penjualan', $id)->delete();
            return redirect()->back()->with('success', 'Margin Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Margin ini pernah dipakai di transaksi penjualan!');
        }
    }
}
