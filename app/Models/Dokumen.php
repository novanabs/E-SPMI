<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen_lainnya';

    protected $fillable = [
        'name',
        'deskripsi',
        'link_dokumen',
        'id_users'
    ];
}
