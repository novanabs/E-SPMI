<?php

namespace App\Models;

use App\Models\User;
use App\Models\MatriksLED;
use Illuminate\Database\Eloquent\Model;

class UsersMatrik extends Model
{
    protected $table = 'users_matrik';

    protected $fillable = [
        'jawaban',
        'nilai_total',
        'isian',
        'id_users',
        'id_matriks_led',
        'link_bukti',
        'kepemilikan_kriteria',
        'temuan',
        'saran'
    ];

    public function matriksLed()
    {
        return $this->belongsTo(MatriksLED::class, 'id_matriks_led');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
