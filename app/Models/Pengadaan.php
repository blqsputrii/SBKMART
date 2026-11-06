<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    Protected $table = 'pengadaan';
    Protected $primaryKey = 'idpengadaan';
    public $timestamps = false;
    protected $guarded = [];
}
