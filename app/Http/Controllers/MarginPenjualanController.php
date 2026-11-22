<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    private function aturan(): array
    {
        return ['persen' => 'required|numeric|min:0|max:100'];
    }

    public function index()
    {
        $rows = DB::select('SELECT * FROM v_margin_penjualan ORDER BY `Kode Margin`');
        return view('margin-penjualan.index', compact('rows'));
    }

    public function create()
    {
        return view('margin-penjualan.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $request->validate($this->aturan(), $this->pesan(), ['persen' => 'Margin (%)']);
        DB::insert('INSERT INTO margin_penjualan (iduser, persen, status) VALUES (?, ?, 0)', [session('user_id'), $request->persen]);
        return redirect()->route('margin-penjualan.index')->with('success', 'Margin berhasil ditambahkan (nonaktif).');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_margin_penjualan WHERE `Kode Margin` = ?', [$id]);
        $data = (object) ['id' => $r->{'Kode Margin'}, 'persen' => $r->{'Margin (%)'}];
        return view('margin-penjualan.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->aturan(), $this->pesan(), ['persen' => 'Margin (%)']);
        DB::update('UPDATE margin_penjualan SET persen = ? WHERE idmargin_penjualan = ?', [$request->persen, $id]);
        return redirect()->route('margin-penjualan.index')->with('success', 'Margin berhasil diubah.');
    }

    public function aktifkan($id)
    {
        $this->satu('SELECT * FROM v_margin_penjualan WHERE `Kode Margin` = ?', [$id]);
        DB::update('UPDATE margin_penjualan SET status = 0');
        DB::update('UPDATE margin_penjualan SET status = 1 WHERE idmargin_penjualan = ?', [$id]);
        return back()->with('success', 'Margin nomor ' . $id . ' sekarang aktif. Yang lain otomatis nonaktif.');
    }

    public function destroy($id)
    {
        $r = $this->satu('SELECT * FROM v_margin_penjualan WHERE `Kode Margin` = ?', [$id]);
        if ($r->{'Status'} === 'Aktif') {
            return back()->with('error', 'Margin yang sedang aktif tidak boleh dihapus.');
        }
        try {DB::delete('DELETE FROM margin_penjualan WHERE idmargin_penjualan = ?', [$id]);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Margin tidak dapat dihapus karena sudah dipakai pada penjualan.');
        }
        return redirect()->route('margin-penjualan.index')->with('success', 'Margin berhasil dihapus.');
    }
}
