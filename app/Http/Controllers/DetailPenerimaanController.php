<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenerimaanController extends Controller
{
    public function edit($id)
    {
        $detail = $this->satu('SELECT * FROM v_detail_penerimaan WHERE `No. Detail` = ?', [$id]);
        return view('penerimaan.edit', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            ['jumlah' => 'required|integer|min:1'],
            $this->pesan(),
            ['jumlah' => 'Jumlah diterima']
        );

        $detail = $this->satu('SELECT * FROM v_detail_penerimaan WHERE `No. Detail` = ?', [$id]);
        DB::statement('CALL sp_proses_transaksi(?, ?, ?, ?, ?, ?, ?, @id_penerimaan, @pesan)', ['U', session('user_id'), null, null, $request->jumlah, $id, 0]);
        $hasil = DB::select('SELECT @id_penerimaan AS id, @pesan AS pesan')[0];
        if ($hasil->pesan !== 'OK') {
            return back()->withInput()->with('error', $hasil->pesan);
        }
        return redirect()->route('penerimaan.show', $detail->{'No. Penerimaan'})
                         ->with('success', 'Jumlah diterima berhasil diubah. Kartu stok dan status pengadaan ikut diperbarui.');
    }
}
