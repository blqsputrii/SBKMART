<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    Protected $table = 'detail_pengadaan';
    Protected $primaryKey = 'iddetail_pengadaan';
    public $timestamps = false;
    protected $guarded = [];
}
