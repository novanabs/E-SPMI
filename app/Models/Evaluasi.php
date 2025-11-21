<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $table = 'laporan_evaluasi';

    protected $fillable = [
        'aspek',
        'jenis_laporan',
        'link_bukti_laporan',
        'id_users'
    ];
}
