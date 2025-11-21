<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengendalian extends Model
{
    protected $table = "laporan_pengendalian";

    protected $fillable = [
        'name',
        'link_bukti_laporan',
        'id_users'
    ];
}
