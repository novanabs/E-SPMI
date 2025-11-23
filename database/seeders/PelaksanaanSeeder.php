<?php

namespace Database\Seeders;

use App\Models\Pelaksanaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelaksanaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelaksanaan::firstOrCreate([
            'name' => 'Contoh Dokumen Pelaksanaan Jurusan Pendidikan Komputer',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'nama_mitra' => 'Institut Teknologi Bandung',
            'link_bukti_kerjasama' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '1',
        ]);
        Pelaksanaan::firstOrCreate([
            'name' => 'Jurusan Tanpa Kerjsasama',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'nama_mitra' => null,
            'link_bukti_kerjasama' => null,
            'id_users' => '1',
        ]);
        Pelaksanaan::firstOrCreate([
            'name' => 'Contoh Dokumen Pelaksanaan Admin FKIP 1',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'nama_mitra' => 'Institut Teknologi Kalimantan',
            'link_bukti_kerjasama' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'id_users' => '3',
        ]);
        Pelaksanaan::firstOrCreate([
            'name' => 'FKIP Tanpa Kerjasama',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link',
            'nama_mitra' => null,
            'link_bukti_kerjasama' => null,
            'id_users' => '3',
        ]);
    }
}
