<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penetapan extends Model
{
    protected $table = 'dokumen_penetapan';

    protected $fillable = [
        'name',
        'link_bukti_dokumen',
        'id_users',
    ];
}
