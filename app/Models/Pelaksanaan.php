<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    protected $table = 'laporan_pelaksanaan';

    protected $fillable = [
        'name',
        'tahun',
        'jenis',
        'link_bukti_laporan',
        'nama_mitra',
        'link_bukti_kerjasama',
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
