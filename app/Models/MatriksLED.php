<?php

namespace App\Models;

use App\Models\Kriteria;
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
        return $this->hasOne(UsersMatrik::class, 'id_matriks_led')->where('id_users', auth()->id());
    }

}
