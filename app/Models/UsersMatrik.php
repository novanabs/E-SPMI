<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersMatrik extends Model
{
    protected $table = 'users_matrik';

    protected $fillable = [
        'jenis_assesment',
        'jawaban',
        'nilai_total',
        'isian',
        'id_users',
        'id_matriks_led',
        'link_bukti',
        'kepemilikan_kriteria',
        'temuan',
        'saran'
    ];
}
