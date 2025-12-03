<?php

namespace App\Models;

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
}
