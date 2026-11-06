<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    Protected $table = 'penerimaan';
    Protected $primaryKey = 'id_penerimaan';
    public $timestamps = false;
    protected $guarded = [];
}
