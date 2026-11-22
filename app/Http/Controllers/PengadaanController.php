<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT * FROM v_pengadaan ORDER BY `No. Pengadaan` DESC');
        return view('pengadaan.index', compact('rows'));
    }

    public function create()
    {
        $vendor = DB::select("SELECT `Kode Vendor`, `Nama Vendor` FROM v_vendor WHERE `Status` COLLATE utf8mb4_0900_ai_ci = 'Aktif' COLLATE utf8mb4_0900_ai_ci");
        return view('pengadaan.create', compact('vendor'));
    }

    public function store(Request $request)
    {
        $request->validate(['vendor' => 'required|integer'], $this->pesan(), ['vendor' => 'Vendor']);
        $aktif = DB::select("SELECT COUNT(*) AS n FROM v_vendor WHERE `Kode Vendor` = ? AND `Status` COLLATE utf8mb4_0900_ai_ci = 'Aktif' COLLATE utf8mb4_0900_ai_ci", [$request->vendor])[0]->n;
        if ($aktif == 0) {
            return back()->withInput()->with('error', 'Vendor tidak ditemukan atau tidak aktif.');
        }

        DB::insert('INSERT INTO pengadaan (user_iduser, vendor_idvendor, subtotal_nilai, ppn, total_nilai) VALUES (?, ?, 0, 0, 0)', [session('user_id'), $request->vendor]);
        $nota = DB::getPdo()->lastInsertId();
        return redirect()->route('pengadaan.show', $nota)
                         ->with('success', 'Nota pengadaan nomor ' . $nota . ' dibuat. Silakan isi barang yang dipesan.');
    }

    public function show($id)
    {
        $nota = $this->satu('SELECT * FROM v_pengadaan WHERE `No. Pengadaan` = ?', [$id]);
        $detail = DB::select('SELECT * FROM v_detail_pengadaan WHERE `No. Pengadaan` = ? ORDER BY `No. Detail`', [$id]);
        $terima = DB::select('SELECT * FROM v_penerimaan WHERE `No. Pengadaan` = ? ORDER BY `No. Penerimaan`', [$id]);
        $barang = [];
        if ($nota->{'Status'} === 'Dipesan') {
            $barang = DB::select('SELECT `Kode Barang`, `Nama Barang`, `Nama Satuan`, `Harga` FROM v_barang ORDER BY `Nama Barang`');
        }
        return view('pengadaan.show', compact('nota', 'detail', 'terima', 'barang'));
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

        $this->satu('SELECT * FROM v_pengadaan WHERE `No. Pengadaan` = ?', [$id]);

        $berhasil = 0;
        $gagal = [];
        foreach ($request->items as $i) {DB::statement('CALL sp_proses_transaksi(?, ?, ?, ?, ?, ?, ?, @id_penerimaan, @pesan)', ['D', session('user_id'), $id, $i['idbarang'], $i['jumlah'], null, 0]);
            $hasil = DB::select('SELECT @pesan AS pesan')[0];
            if ($hasil->pesan === 'OK') {$berhasil++;}
            else {$nama = DB::select('SELECT `Nama Barang` AS nama FROM v_barang WHERE `Kode Barang` = ?', [$i['idbarang']]);
                $gagal[] = ($nama[0]->nama ?? 'Barang') . ': ' . $hasil->pesan;
            }
        }

        $redirect = redirect()->route('pengadaan.show', $id);
        if ($berhasil > 0) {
            $redirect->with('success', $berhasil . ' barang ditambahkan. Subtotal, PPN, dan total nota sudah diperbarui.');
        }
        if (count($gagal) > 0) {
            $redirect->with('error', implode(' | ', $gagal));
        }
        return $redirect;
    }
}
