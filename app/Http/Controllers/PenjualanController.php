<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT * FROM v_penjualan ORDER BY `No. Penjualan` DESC');
        return view('penjualan.index', compact('rows'));
    }

    public function create()
    {
        $margin = DB::select("SELECT `Margin (%)` AS persen FROM v_margin_penjualan WHERE `Status` COLLATE utf8mb4_0900_ai_ci = 'Aktif' COLLATE utf8mb4_0900_ai_ci");
        return view('penjualan.create', compact('margin'));
    }

    public function store()
    {
        DB::insert('INSERT INTO penjualan (iduser, idmargin_penjualan, subtotal_nilai, ppn, total_nilai) SELECT ?, idmargin_penjualan, 0, 0, 0 FROM margin_penjualan WHERE status = 1', [session('user_id')]);
        $nota = DB::getPdo()->lastInsertId();
        if (! $nota) {
            return back()->with('error', 'Belum ada margin penjualan yang aktif. Hubungi admin.');
        }
        return redirect()->route('penjualan.show', $nota)
                         ->with('success', 'Nota penjualan nomor ' . $nota . ' dibuat. Silakan isi barang yang dibeli.');
    }

    public function show($id)
    {
        $nota = $this->satu('SELECT * FROM v_penjualan WHERE `No. Penjualan` = ?', [$id]);
        $detail = DB::select('SELECT * FROM v_detail_penjualan WHERE `No. Penjualan` = ? ORDER BY `No. Detail`', [$id]);
        $barang = DB::select('SELECT `Kode Barang`, `Nama Barang`, `Nama Satuan`, `Harga`, `Stok` FROM v_barang WHERE `Stok` > 0 ORDER BY `Nama Barang`');
        return view('penjualan.show', compact('nota', 'detail', 'barang'));
    }

    public function storeDetail(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.jumlah' => 'required|integer|min:1',
        ], $this->pesan(), [
            'items' => 'Barang',
            'items.*.idbarang' => 'Barang',
            'items.*.jumlah' => 'Jumlah',
        ]);

        $this->satu('SELECT * FROM v_penjualan WHERE `No. Penjualan` = ?', [$id]);
        $item = [];
        foreach ($request->items as $i) {
            $item[$i['idbarang']] = ($item[$i['idbarang']] ?? 0) + (int) $i['jumlah'];
        }

        $berhasil = 0;
        $gagal = [];
        foreach ($item as $idbarang => $jumlah) {
            DB::statement('CALL sp_proses_transaksi(?, ?, ?, ?, ?, ?, ?, @id_penerimaan, @pesan)', ['J', session('user_id'), $id, $idbarang, $jumlah, null, 0]);
            $hasil = DB::select('SELECT @pesan AS pesan')[0];
            if ($hasil->pesan === 'OK') {
                $berhasil++;
            } else {
                $nama = DB::select('SELECT `Nama Barang` AS nama FROM v_barang WHERE `Kode Barang` = ?', [$idbarang]);
                $gagal[] = ($nama[0]->nama ?? 'Barang') . ': ' . $hasil->pesan;
            }
        }

        $redirect = redirect()->route('penjualan.show', $id);
        if ($berhasil > 0) {
            $redirect->with('success', $berhasil . ' barang ditambahkan. Stok, kartu stok, dan total nota sudah diperbarui.');
        }
        if (count($gagal) > 0) {
            $redirect->with('error', implode(' | ', $gagal));
        }
        return $redirect;
    }
}
