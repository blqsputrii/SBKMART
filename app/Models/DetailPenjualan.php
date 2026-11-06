<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    Protected $table = 'detail_penjualan';
    Protected $primaryKey = 'iddetail_penjualan';
    public $timestamps = false;
    protected $guarded = [];
}
