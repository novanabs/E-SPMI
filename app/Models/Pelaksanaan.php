<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    protected $table = 'laporan_pelaksanaan';

    protected $fillable = [
        'name',
        'link_bukti_laporan',
        'nama_mitra',
        'link_bukti_kerjasama',
        'id_users'
    ];
}
