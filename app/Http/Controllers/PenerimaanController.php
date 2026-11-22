<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT * FROM v_penerimaan ORDER BY `No. Penerimaan` DESC');
        return view('penerimaan.index', compact('rows'));
    }

    public function create(Request $request)
    {
        $pengadaan = DB::select("SELECT `No. Pengadaan`, `Nama Vendor`, `Tanggal Pesan`, `Status` FROM v_pengadaan WHERE `Status` <> 'Diterima Utuh' AND `Subtotal` > 0 ORDER BY `No. Pengadaan` DESC");
        $nota = null;
        $detail = [];
        if ($request->filled('pengadaan')) {
            $nota = $this->satu('SELECT * FROM v_pengadaan WHERE `No. Pengadaan` = ?', [$request->pengadaan]);
            $detail = DB::select('SELECT * FROM v_detail_pengadaan WHERE `No. Pengadaan` = ? ORDER BY `No. Detail`', [$request->pengadaan]);
        }
        return view('penerimaan.create', compact('pengadaan', 'nota', 'detail'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengadaan' => 'required|integer',
            'jumlah' => 'required|array',
            'jumlah.*' => 'nullable|integer|min:0',
        ], $this->pesan(), ['pengadaan' => 'Nota pengadaan', 'jumlah' => 'Jumlah', 'jumlah.*' => 'Jumlah terima']);

        $iduser = session('user_id');
        $idpenerimaan = 0;
        $berhasil = 0;
        $gagal = [];

        foreach ($request->jumlah as $idbarang => $qty) {
            $qty = (int) $qty;
            if ($qty <= 0) {
                continue;
            }
            DB::statement('CALL sp_proses_transaksi(?, ?, ?, ?, ?, ?, ?, @id_penerimaan, @pesan)', ['T', $iduser, $request->pengadaan, $idbarang, $qty, null, $idpenerimaan]);
            $hasil = DB::select('SELECT @id_penerimaan AS id, @pesan AS pesan')[0];
            if ($hasil->pesan === 'OK') {
                $idpenerimaan = $hasil->id;
                $berhasil++;
            } else {
                $gagal[] = 'Barang ' . $idbarang . ': ' . $hasil->pesan;
            }
        }

        if ($berhasil == 0 && count($gagal) == 0) {
            return back()->withInput()->with('error', 'Isi jumlah terima minimal untuk satu barang.');
        }
        if ($berhasil == 0) {
            return back()->withInput()->with('error', implode(' | ', $gagal));
        }

        $redirect = redirect()->route('penerimaan.show', $idpenerimaan)
                              ->with('success', 'Penerimaan nomor ' . $idpenerimaan . ' berhasil disimpan.');
        if (count($gagal) > 0) {
            $redirect->with('error', 'Sebagian tidak diproses: ' . implode(' | ', $gagal));
        }
        return $redirect;
    }

    public function show($id)
    {
        $nota = $this->satu('SELECT * FROM v_penerimaan WHERE `No. Penerimaan` = ?', [$id]);
        $detail = DB::select('SELECT * FROM v_detail_penerimaan WHERE `No. Penerimaan` = ? ORDER BY `No. Detail`', [$id]);
        return view('penerimaan.show', compact('nota', 'detail'));
    }
}
