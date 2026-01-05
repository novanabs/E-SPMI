<?php

namespace App\Models;

use App\Models\MatriksLED;
use Illuminate\Database\Eloquent\Model;

class SubItemElemen extends Model
{
    protected $table = 'sub_item_elemen';
    protected $fillable = [
        'id_matriks_lembar_evaluasi_diri',
        'variabel',
        'deskripsi',
        'nomor_elemen'
    ];

    public function matriks()
    {
        return $this->belongsTo(
            MatriksLED::class,
            'nomor_elemen',
            'nomor'
        );
    }

    public function nilaiUser()
    {
        return $this->hasMany(UserSubItemElemen::class, 'id_sub_item_elemen');
    }


}
