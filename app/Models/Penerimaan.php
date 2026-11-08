<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    Protected $table = 'v_penerimaan';
    Protected $primaryKey = 'Nomor Surat Penerimaan';
    public $timestamps = false;
}
