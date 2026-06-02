<?php

namespace App\Models;

use App\Models\AuditKriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = "kriteria";

    protected $fillable = [
        'name',
        'deskripsi'
    ];

    public function auditKriterias(): HasMany
    {
        // Pastikan nama foreign key di tabel audit_kriterias sesuai. 
        // Secara default Laravel menebaknya 'kriteria_id'.
        return $this->hasMany(AuditKriteria::class, 'kriteria_id');
    }
}
