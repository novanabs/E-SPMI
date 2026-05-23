<?php

namespace Database\Seeders;

use App\Models\Pengendalian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengendalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengendalian::firstOrCreate([
            'name' => 'Laporan Pengendalian Jurusan Pendidikan Komputer',
            'tahun' => '2024',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '1',
        ]);
        Pengendalian::firstOrCreate([
            'name' => 'Laporan Pengendalian FKIP',
            'tahun' => '2024',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
    }
}
