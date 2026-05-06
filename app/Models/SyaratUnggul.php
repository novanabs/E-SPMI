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
}
