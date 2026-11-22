<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT * FROM v_role ORDER BY `Kode Role`');
        return view('role.index', compact('rows'));
    }

    public function create()
    {
        return view('role.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_role' => 'required|max:100'], $this->pesan(), ['nama_role' => 'Nama role']);
        DB::insert('INSERT INTO role (nama_role) VALUES (?)', [$request->nama_role]);
        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_role WHERE `Kode Role` = ?', [$id]);
        $data = (object) ['id' => $r->{'Kode Role'}, 'nama_role' => $r->{'Nama Role'}];
        return view('role.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_role' => 'required|max:100'], $this->pesan(), ['nama_role' => 'Nama role']);
        DB::update('UPDATE role SET nama_role = ? WHERE idrole = ?', [$request->nama_role, $id]);
        return redirect()->route('role.index')->with('success', 'Role berhasil diubah.');
    }

    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM role WHERE idrole = ?', [$id]);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Role tidak dapat dihapus karena masih dipakai pengguna.');
        }
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus.');
    }
}
