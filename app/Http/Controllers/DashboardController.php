<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('user_role') == 2) {
            return $this->kasir();
        }
        return $this->admin();
    }

    private function admin()
    {
        $jumlahBarang = DB::select('SELECT COUNT(*) AS jumlah FROM v_barang')[0]->jumlah;
        $pengadaanBuka = DB::select("SELECT COUNT(*) AS jumlah FROM v_pengadaan WHERE `Status` <> 'Diterima Utuh'")[0]->jumlah;
        $hariIni = DB::select('SELECT COUNT(*) AS jumlah, SUM(`Total`) AS total FROM v_penjualan WHERE DATE(`Tanggal Jual`) = CURDATE()')[0];
        $margin = DB::select("SELECT `Margin (%)` AS persen FROM v_margin_penjualan WHERE `Status` COLLATE utf8mb4_unicode_ci = 'Aktif' COLLATE utf8mb4_unicode_ci");
        $stokMenipis = DB::select('SELECT `Kode Barang`, `Nama Barang`, `Nama Satuan`, `Stok`, `Status` FROM v_barang WHERE `Stok` <= 5 ORDER BY `Stok`, `Nama Barang`');

        return view('dashboard.admin', compact('jumlahBarang', 'pengadaanBuka', 'hariIni', 'margin', 'stokMenipis'));
    }

    private function kasir()
    {
        $hariIni = DB::select('SELECT COUNT(*) AS jumlah, SUM(`Total`) AS total FROM v_penjualan WHERE DATE(`Tanggal Jual`) = CURDATE() AND `Petugas` = ?', [session('user_name')])[0];
        $margin = DB::select("SELECT `Margin (%)` AS persen FROM v_margin_penjualan WHERE `Status` COLLATE utf8mb4_unicode_ci = 'Aktif' COLLATE utf8mb4_unicode_ci");
        $terakhir = DB::select('SELECT `No. Penjualan`, `Tanggal Jual`, `Total` FROM v_penjualan WHERE `Petugas` = ? ORDER BY `No. Penjualan` DESC LIMIT 5', [session('user_name')]);

        return view('dashboard.kasir', compact('hariIni', 'margin', 'terakhir'));
    }
}
