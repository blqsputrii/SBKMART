<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    Protected $table = 'v_kartu_stok';
    Protected $primaryKey = 'Nomor Riwayat Stok';
    public $timestamps = false;
}
