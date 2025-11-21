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

        // Jurusan
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '1',
        ]);

        // FKIP
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pendidikan',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Penelitian',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'AMI',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'Monev_jurusan',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
        Evaluasi::firstOrCreate([
            'aspek' => 'Pengabdian',
            'jenis_laporan' => 'Survey',
            'link_bukti_laporan' => 'https://drive.google.com/file/d/10ut94zuR_s8pcjxp1X9F7iFjkiyhjkSs/preview',
            'id_users' => '3',
        ]);
    }
}
