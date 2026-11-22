<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    private function roles()
    {
        return DB::select('SELECT `Kode Role`, `Nama Role` FROM v_role ORDER BY `Kode Role`');
    }

    private function atribut(): array
    {
        return ['username' => 'Username', 'password' => 'Password', 'idrole' => 'Role'];
    }

    public function index()
    {
        $rows = DB::select('SELECT * FROM v_user ORDER BY `Kode Pengguna`');
        return view('user.index', compact('rows'));
    }

    public function create()
    {
        return view('user.form', ['data' => null, 'roles' => $this->roles()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:45',
            'password' => 'required|min:5|max:50',
            'idrole' => 'required|integer',
        ], $this->pesan(), $this->atribut());

        $ada = DB::select('SELECT COUNT(*) AS n FROM `user` WHERE username = ?', [$request->username])[0]->n;
        if ($ada > 0) {
            return back()->withInput()->with('error', 'Username sudah dipakai.');
        }

        DB::insert('INSERT INTO `user` (idrole, username, password) VALUES (?, ?, ?)', [$request->idrole, $request->username, Hash::make($request->password)]);
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $r = $this->satu('SELECT * FROM v_user WHERE `Kode Pengguna` = ?', [$id]);
        $data = (object) ['id' => $r->{'Kode Pengguna'}, 'username' => $r->{'Username'}, 'idrole' => $r->{'Kode Role'}];
        return view('user.form', ['data' => $data, 'roles' => $this->roles()]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:45',
            'password' => 'nullable|min:5|max:50',
            'idrole' => 'required|integer',
        ], $this->pesan(), $this->atribut());

        $ada = DB::select('SELECT COUNT(*) AS n FROM `user` WHERE username = ? AND iduser <> ?', [$request->username, $id])[0]->n;
        if ($ada > 0) {
            return back()->withInput()->with('error', 'Username sudah dipakai.');
        }

        DB::update('UPDATE `user` SET username = ?, idrole = ? WHERE iduser = ?', [$request->username, $request->idrole, $id]);
        if ($request->filled('password')) {
            DB::update('UPDATE `user` SET password = ? WHERE iduser = ?', [Hash::make($request->password), $id]);
        }
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diubah.');
    }

    public function destroy($id)
    {
        if ($id == session('user_id')) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang dipakai.');
        }
        try {DB::delete('DELETE FROM `user` WHERE iduser = ?', [$id]);}
        catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Pengguna tidak dapat dihapus karena sudah punya transaksi.');
        }
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
