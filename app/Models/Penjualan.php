<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    Protected $table = 'penjualan';
    Protected $primaryKey = 'idpenjualan';
    public $timestamps = false;
    protected $guarded = [];
}
