<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarginPenjualan extends Model
{
    Protected $table = 'margin_penjualan';
    Protected $primaryKey = 'idmargin_penjualan';
    public $timestamps = false;
    protected $guarded = [];
}
