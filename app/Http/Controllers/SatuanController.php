<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    private function aturan(): array
    {
        return ['nama_satuan' => 'required|max:45', 'status' => 'required|in:0,1'];
    }

    private function atribut(): array
    {
        return ['nama_satuan' => 'Nama satuan', 'status' => 'Status'];
    }

    public function index()
    {
        $rows = DB::select('SELECT * FROM v_satuan ORDER BY `Kode Satuan`');
        return view('satuan.index', compact('rows'));
    }

    public function create()
    {
        return view('satuan.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());
        DB::insert('INSERT INTO satuan (nama_satuan, status) VALUES (?, ?)', [$request->nama_satuan, $request->status]);
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_satuan WHERE `Kode Satuan` = ?', [$id]);
        $data = (object) [
            'id'          => $r->{'Kode Satuan'},
            'nama_satuan' => $r->{'Nama Satuan'},
            'status'      => $r->{'Status'} === 'Aktif' ? 1 : 0,
        ];
        return view('satuan.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());
        DB::update('UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?', [$request->nama_satuan, $request->status, $id]);
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diubah.');
    }

    public function destroy($id)
    {
        try {DB::delete('DELETE FROM satuan WHERE idsatuan = ?', [$id]);}
        catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Satuan tidak dapat dihapus karena masih dipakai barang.');
        }
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
