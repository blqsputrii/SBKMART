<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TriggerController extends Controller
{
    public function index()
    {
        $kartuStok = [];
        try {
            $kartuStok = DB::table('v_kartu_stok')->orderBy('Nomor Riwayat Stok', 'DESC')->limit(15)->get();
        } catch (Exception $e) {

        }

        return view('detail.trigger', compact('kartuStok'));
    }
}
