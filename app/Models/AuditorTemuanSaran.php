<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditorTemuanSaran extends Model
{
    protected $table = 'auditor_temuan_saran';

    protected $fillable = [
        'id_users',
        'id_user_jurusan',
        'id_matriks_led',
        'temuan',
        'saran',
    ];
}
