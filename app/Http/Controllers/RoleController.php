<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roleList = Role::all();
        return view('role.index', compact('roleList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('role')->max('idrole') ?? 0;
        DB::table('role')->insert([
            'idrole'    => $maxId + 1,
            'nama_role' => $request->nama_role,
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('role')->where('idrole', $id)->update([
            'nama_role' => $request->nama_role,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('role')->where('idrole', $id)->delete();
            return redirect()->back()->with('success', 'Role Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Role ini masih digunakan oleh akun pengguna!');
        }
    }
}
