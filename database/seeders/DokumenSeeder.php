<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dokumen::firstOrCreate([
            'name' => 'Contoh Dokumen SATU',
            'deskripsi' => 'Ini adalah dokumen dari FKIP',
            'link_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
        Dokumen::firstOrCreate([
            'name' => 'Contoh Dokumen DUA',
            'deskripsi' => 'Ini adalah yang kedua',
            'link_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
        Dokumen::firstOrCreate([
            'name' => 'Contoh Dokumen TIGA',
            'deskripsi' => 'Ini asdsadsadas',
            'link_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
    }
}
