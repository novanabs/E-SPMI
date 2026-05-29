<?php

namespace App\Models;

use App\Models\MatriksLED;
use Illuminate\Database\Eloquent\Model;

class SyaratUnggul extends Model
{
    protected $table = "syarat_unggul";

    protected $fillable = [
        'nomor',
        'matriks_id',
        'elemen',
        'indikator',
        'syarat_tahun'
    ];

    public function matriks()
    {
        return $this->belongsTo(MatriksLED::class, 'matriks_id');
    }

    public function kriteria()
    {
        return $this->hasOneThrough(
            \App\Models\Kriteria::class,
            MatriksLED::class,
            'id',
            'id',
            'matriks_id',
            'id_kriteria'
        );
    }
}
