<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    Protected $table = 'vendor';
    Protected $primaryKey = 'idvendor';
    public $timestamps = false;
    protected $guarded = [];
}
