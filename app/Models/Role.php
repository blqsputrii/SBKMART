<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    Protected $table = 'role';
    Protected $primaryKey = 'idrole';
    public $timestamps = false;
    protected $guarded = [];
}
