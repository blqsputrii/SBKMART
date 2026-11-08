<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::all();
        $roleList = DB::table('role')->get();
        return view('layouts.user', compact('userList', 'roleList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('user')->max('iduser') ?? 0;
        DB::table('user')->insert([
            'iduser'   => $maxId + 1,
            'idrole'   => $request->idrole,
            'username' => $request->username,
            'password' => $request->password,
        ]);
        return redirect()->back()->with('success', 'Pengguna Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = [
            'idrole'   => $request->idrole,
            'username' => $request->username,
        ];
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        DB::table('user')->where('iduser', $id)->update($data);
        return redirect()->back()->with('success', 'Pengguna Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('user')->where('iduser', $id)->delete();
            return redirect()->back()->with('success', 'Pengguna Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Akun ini masih terikat transaksi!');
        }
    }
}
