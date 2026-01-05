<?php

namespace App\Models;

use App\Models\Kriteria;
use App\Models\UsersMatrik;
use App\Models\SubItemElemen;
use Illuminate\Database\Eloquent\Model;

class MatriksLED extends Model
{
    protected $table = 'matriks_lembar_evaluasi_diri';

    protected $fillable = [
        'nomor',
        'id_kriteria',
        'elemen',
        'poin',
        'indikator',
        'harkat_penskoran',
        'option_pilihan_ganda', // Ini berarti nullable
        'jenis' // (pilihan ganda, isian)
    ];


    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function userMatrik()
    {
        return $this->hasOne(UsersMatrik::class, 'id_matriks_led');
    }

    public function userMatrikByUser()
    {
        return $this->hasOne(UsersMatrik::class, 'id_matriks_led');
    }

    public function subItemElemen()
    {
        return $this->hasMany(
            SubItemElemen::class,
            'nomor_elemen', // FK di sub_item_elemen
            'nomor'         // PK di matriks_lembar_evaluasi_diri
        );
    }


    public function userSubItemElements()
    {
        return $this->hasMany(
            UserSubItemElemen::class,
            'id_matriks', // FK di tabel child
            'id'              // PK di matriks_led
        );
    }



}
