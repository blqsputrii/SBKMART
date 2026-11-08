<?php

namespace App\Http\Controllers;

use App\Models\KartuStok;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    public function index()
    {
        $kartuStokList = KartuStok::all();
        return view('detail.kartu-stok', compact('kartuStokList'));
    }
}
