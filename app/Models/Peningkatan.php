<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peningkatan extends Model
{
    protected $table = 'laporan_peningkatan';

    protected $fillable = [
        'name',
        'link_bukti_laporan',
        'id_users'
    ];
}
