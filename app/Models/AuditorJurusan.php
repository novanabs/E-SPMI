<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditorJurusan extends Model
{
    protected $table = 'auditor_jurusan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
