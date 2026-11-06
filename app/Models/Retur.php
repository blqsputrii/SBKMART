<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    Protected $table = 'retur';
    Protected $primaryKey = 'idretur';
    public $timestamps = false;
    protected $guarded = [];
}
