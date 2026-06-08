<?php

namespace App\Models;

use App\Models\AuditKriteria;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Audit extends Model
{
    protected $fillable = [
        'program_studi',
        'fakultas',
        'tanggal_audit',
        'catatan_umum',
        'auditor_1_id',
        'auditor_2_id',
        'created_by',
        'jurusan_submitted_at',
        'jurusan_submitted_by',
        'auditor_submitted_at',
        'auditor_submitted_by',
    ];

    protected $casts = [
        'tanggal_audit'         => 'date',
        'jurusan_submitted_at'  => 'datetime',
        'auditor_submitted_at'  => 'datetime',
    ];

    public function auditor1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_1_id');
    }

    public function auditor2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_2_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function auditKriterias(): HasMany
    {
        return $this->hasMany(AuditKriteria::class);
    }

    // Eager load lengkap untuk export
    public function auditKriteriasWithDetail(): HasMany
    {
        return $this->hasMany(AuditKriteria::class)->with('kriteria');
    }
}
