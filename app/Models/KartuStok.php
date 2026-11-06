<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    Protected $table = 'kartu_stok';
    Protected $primaryKey = 'idkartu_stok';
    public $timestamps = false;
    protected $guarded = [];
}
