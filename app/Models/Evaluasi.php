<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $table = 'laporan_evaluasi';

    protected $fillable = [
        'aspek',
        'jenis_laporan',
        'tahun',
        'jenis',
        'link_bukti_laporan',
        'id_users'
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
