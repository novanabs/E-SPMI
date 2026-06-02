<?php

namespace Database\Seeders;

use App\Models\Evaluasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // aspek(Pendidikan, Penelitian, Pengabdian)
        // jenis_laporan(AMI, Monev_jurusan, Survey)

        $link = 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/view?usp=drive_link';

        $jurusan_seeds = [
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'AMI',            'jenis' => 'Semester Ganjil', 'id_users' => '1'],
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Semester Genap',  'id_users' => '1'],
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'Survey',         'jenis' => 'Tahun',            'id_users' => '1'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'AMI',            'jenis' => 'Semester Ganjil', 'id_users' => '1'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Tahun',            'id_users' => '1'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'Survey',         'jenis' => 'Semester Genap',  'id_users' => '1'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'AMI',            'jenis' => 'Semester Ganjil', 'id_users' => '1'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Tahun',            'id_users' => '1'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'Survey',         'jenis' => 'Semester Genap',  'id_users' => '1'],
        ];

        $fkip_seeds = [
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'AMI',            'jenis' => 'Tahun',            'id_users' => '3'],
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Semester Ganjil', 'id_users' => '3'],
            ['aspek' => 'Pendidikan',  'jenis_laporan' => 'Survey',         'jenis' => 'Semester Genap',  'id_users' => '3'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'AMI',            'jenis' => 'Tahun',            'id_users' => '3'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Semester Ganjil', 'id_users' => '3'],
            ['aspek' => 'Penelitian',  'jenis_laporan' => 'Survey',         'jenis' => 'Semester Genap',  'id_users' => '3'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'AMI',            'jenis' => 'Tahun',            'id_users' => '3'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'Monev_jurusan',  'jenis' => 'Semester Ganjil', 'id_users' => '3'],
            ['aspek' => 'Pengabdian',  'jenis_laporan' => 'Survey',         'jenis' => 'Semester Genap',  'id_users' => '3'],
        ];

        foreach (array_merge($jurusan_seeds, $fkip_seeds) as $seed) {
            Evaluasi::firstOrCreate($seed + [
                'tahun' => '2024',
                'link_bukti_laporan' => $link,
            ]);
        }
    }
}
