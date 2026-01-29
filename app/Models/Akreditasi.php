<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    protected $fillable = [
        'nama_jurusan',
        'akreditasi',
        'nomor_sk',
        'tanggal_sk',
        'tanggal_kadaluarsa',
        'dokumen',
    ];
}
