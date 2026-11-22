<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            ['username' => 'required', 'password' => 'required'],
            $this->pesan(),
            ['username' => 'Username', 'password' => 'Password']
        );

        $rows = DB::select(
            'SELECT u.iduser, u.idrole, u.username, u.password, r.nama_role
             FROM `user` u, role r
             WHERE r.idrole = u.idrole AND u.username = ?',
            [$request->username]
        );

        $user = $rows[0] ?? null;
        $cocok = false;
        if ($user) {
            if (str_starts_with((string) $user->password, '$2y$')) {
                $cocok = Hash::check($request->password, $user->password);
            } else {
                $cocok = hash_equals((string) $user->password, (string) $request->password);
            }
        }
        if (! $cocok) {
            return back()->withInput($request->only('username'))
                         ->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();
        session([
            'user_id' => $user->iduser,
            'user_name' => $user->username,
            'user_role' => (int) $user->idrole,
            'user_role_name' => $user->nama_role,
        ]);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}
