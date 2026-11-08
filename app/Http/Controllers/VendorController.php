<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendorList = Vendor::all();
        return view('vendor.index', compact('vendorList'));
    }

    public function store(Request $request)
    {
        $maxId = DB::table('vendor')->max('idvendor') ?? 0;
        DB::table('vendor')->insert([
            'idvendor'    => $maxId + 1,
            'nama_vendor' => $request->nama_vendor,
            'badan_hukum' => $request->badan_hukum,
            'status'      => $request->status,
        ]);
        return redirect()->back()->with('success', 'Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        DB::table('vendor')->where('idvendor', $id)->update([
            'nama_vendor' => $request->nama_vendor,
            'badan_hukum' => $request->badan_hukum,
            'status'      => $request->status,
        ]);
        return redirect()->back()->with('success', 'Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        try {
            DB::table('vendor')->where('idvendor', $id)->delete();
            return redirect()->back()->with('success', 'Vendor Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Gagal Hapus: Vendor ini masih digunakan di transaksi pengadaan!');
        }
    }
}
