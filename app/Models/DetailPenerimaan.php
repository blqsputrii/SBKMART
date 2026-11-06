<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenerimaan extends Model
{
    Protected $table = 'detail_penerimaan';
    Protected $primaryKey = 'iddetail_penerimaan';
    public $timestamps = false;
    protected $guarded = [];
}
