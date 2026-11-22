<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    private function aturan(): array
    {
        return [
            'nama_vendor' => 'required|max:100',
            'badan_hukum' => 'required|in:Y,N',
            'status' => 'required|in:A,N',
        ];
    }

    private function atribut(): array
    {
        return ['nama_vendor' => 'Nama vendor', 'badan_hukum' => 'Badan hukum', 'status' => 'Status'];
    }

    public function index()
    {
        $rows = DB::select('SELECT * FROM v_vendor ORDER BY `Kode Vendor`');
        return view('vendor.index', compact('rows'));
    }

    public function create()
    {
        return view('vendor.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());
        DB::insert('INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)', [$request->nama_vendor, $request->badan_hukum, $request->status]);
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_vendor WHERE `Kode Vendor` = ?', [$id]);
        $data = (object) [
            'id' => $r->{'Kode Vendor'},
            'nama_vendor' => $r->{'Nama Vendor'},
            'badan_hukum' => $r->{'Badan Hukum'} === 'Ya' ? 'Y' : 'N',
            'status' => $r->{'Status'} === 'Aktif' ? 'A' : 'N',
        ];
        return view('vendor.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->aturan(), $this->pesan(), $this->atribut());
        DB::update('UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?', [$request->nama_vendor, $request->badan_hukum, $request->status, $id]);
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diubah.');
    }

    public function destroy($id)
    {
        try {DB::delete('DELETE FROM vendor WHERE idvendor = ?', [$id]);}
        catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Vendor tidak dapat dihapus karena sudah dipakai pada pengadaan.');
        }
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }
}
