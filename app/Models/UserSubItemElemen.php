<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubItemElemen extends Model
{
    protected $table = 'users_sub_item_elemen';

    protected $fillable = [
        'id_matriks',
        'id_sub_item_elemen',
        'nilai',
        'id_users',
        'id_user_jurusan',
        'tahun',
    ];

    public function matriksLED()
    {
        return $this->belongsTo(
            MatriksLED::class,
            'id_matriks',
            'id'
        );
    }
}
