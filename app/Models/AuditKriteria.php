<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditKriteria extends Model
{
    protected $table = 'audit_kriteria';
    protected $fillable = [
        'jurusan_id',
        'kriteria_id',
        'temuan',
        'rekomendasi',
    ];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(Audit::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
