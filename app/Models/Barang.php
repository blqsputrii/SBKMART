<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    Protected $table = 'barang';
    Protected $primaryKey = 'idbarang';
    public $timestamps = false;
    protected $guarded = [];
}
