<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    private function satuanAktif()
    {
        return DB::select("SELECT `Kode Satuan`, `Nama Satuan` FROM v_satuan WHERE `Status` = 'Aktif' ORDER BY `Nama Satuan`");
    }

    private function aturan(): array
    {
        return ['nama' => 'required|max:45', 'jenis' => 'required|in:S,M', 'idsatuan' => 'required|integer','harga' => 'required|integer|min:0'];
    }

    private function atribut(): array
    {
        return ['nama' => 'Nama barang', 'jenis' => 'Ukuran', 'idsatuan' => 'Satuan', 'harga' => 'Harga dasar'];
    }

    public function index()
    {
        $rows = DB::select('SELECT * FROM v_barang ORDER BY `Kode Barang`');
        return view('barang.index', compact('rows'));
    }

    public function create()
    {
        return view('barang.form', ['data' => null, 'satuan' => $this->satuanAktif()]);
    }

    public function store(Request $request)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());
        DB::insert(
            'INSERT INTO barang (nama, jenis, idsatuan, harga, status) VALUES (?, ?, ?, ?, 0)',
            [$request->nama, $request->jenis, $request->idsatuan, $request->harga]);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_barang WHERE `Kode Barang` = ?', [$id]);
        $data = (object) [
            'id'       => $r->{'Kode Barang'},
            'nama'     => $r->{'Nama Barang'},
            'jenis'    => $r->{'Ukuran'} === 'Medium' ? 'M' : 'S',
            'idsatuan' => $r->{'Kode Satuan'},
            'harga'    => $r->{'Harga'},
        ];
        return view('barang.form', ['data' => $data, 'satuan' => $this->satuanAktif()]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        DB::update(
            'UPDATE barang SET nama = ?, jenis = ?, idsatuan = ?, harga = ? WHERE idbarang = ?',
            [$request->nama, $request->jenis, $request->idsatuan, $request->harga, $id]
        );
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diubah.');
    }

    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM barang WHERE idbarang = ?', [$id]);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Barang tidak dapat dihapus karena sudah dipakai pada transaksi.');
        }
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
