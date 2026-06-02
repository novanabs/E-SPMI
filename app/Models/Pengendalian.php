<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengendalian extends Model
{
    protected $table = "laporan_pengendalian";

    protected $fillable = [
        'name',
        'tahun',
        'jenis',
        'link_bukti_laporan',
        'id_users',
    ];

    public function getPeriodeAttribute(): string
    {
        return match ($this->jenis) {
            'Semester Ganjil' => "{$this->tahun} - Ganjil",
            'Semester Genap'  => "{$this->tahun} - Genap",
            default           => (string) $this->tahun,
        };
    }
}
