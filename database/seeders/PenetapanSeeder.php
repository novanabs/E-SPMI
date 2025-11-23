<?php

namespace Database\Seeders;

use App\Models\Penetapan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenetapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Penetapan::firstOrCreate([
            'name' => 'Contoh Dokumen Penetapan Jurusan Pendidikan Komputer',
            'link_bukti_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '1',
        ]);
        Penetapan::firstOrCreate([
            'name' => 'Contoh Dokumen Penetapan Jurusan Pendidikan Ekonomi',
            'link_bukti_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '2',
        ]);
        Penetapan::firstOrCreate([
            'name' => 'Contoh Dokumen Penetapan Admin FKIP 1',
            'link_bukti_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
        Penetapan::firstOrCreate([
            'name' => 'Contoh Dokumen Penetapan Admin FKIP 2',
            'link_bukti_dokumen' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '4',
        ]);
    }
}
