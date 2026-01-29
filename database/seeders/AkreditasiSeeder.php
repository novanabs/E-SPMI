<?php

namespace Database\Seeders;

use App\Models\Akreditasi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkreditasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jurusan'       => 'Pendidikan Geografi',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '420/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-04-25',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Khusus',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '500/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-05-16',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Guru Sekolah Dasar',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '586/SK/LAMDIK/Ak/S/XI/2022',
                'tanggal_sk'         => '2022-11-04',
                'tanggal_kadaluarsa' => '2027-06-06',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Sosiologi',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '541/SK/LAMDIK/Ak/S/XI/2022',
                'tanggal_sk'         => '2022-11-04',
                'tanggal_kadaluarsa' => '2027-07-18',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Bahasa dan Sastra Indonesia',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '481/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-08-01',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Pancasila dan Kewarganegaraan',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '604/SK/LAMDIK/Ak/S/XI/2022',
                'tanggal_sk'         => '2022-11-04',
                'tanggal_kadaluarsa' => '2027-08-15',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Jasmani',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '608/SK/LAMDIK/Ak/S/XI/2022',
                'tanggal_sk'         => '2022-11-04',
                'tanggal_kadaluarsa' => '2027-09-12',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Sejarah',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '511/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-10-24',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Ekonomi',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '519/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-11-28',
            ],
            [
                'nama_jurusan'       => 'Bimbingan Konseling',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '497/SK/LAMDIK/Ak/S/X/2022',
                'tanggal_sk'         => '2022-10-24',
                'tanggal_kadaluarsa' => '2027-12-27',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Seni Pertunjukan',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '809/SK/LAMDIK/Ak/S/XII/2022',
                'tanggal_sk'         => '2023-04-11',
                'tanggal_kadaluarsa' => '2028-04-10',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Biologi',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '618/SK/LAMDIK/Ak/S/VIII/2023',
                'tanggal_sk'         => '2023-08-04',
                'tanggal_kadaluarsa' => '2028-10-03',
            ],
            [
                'nama_jurusan'       => 'Pendidikan IPA',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '283/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-04-10',
                'tanggal_kadaluarsa' => '2029-04-09',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Guru Pendidikan Anak Usia Dini',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '318/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-04-10',
                'tanggal_kadaluarsa' => '2029-04-09',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Komputer',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '234/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-04-10',
                'tanggal_kadaluarsa' => '2029-04-09',
            ],
            [
                'nama_jurusan'       => 'Pendidikan IPS',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '216/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-04-24',
                'tanggal_kadaluarsa' => '2029-04-23',
            ],
            [
                'nama_jurusan'       => 'Teknologi Pendidikan',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '210/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-04-24',
                'tanggal_kadaluarsa' => '2029-04-23',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Fisika',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '125/SK/LAMDIK/Ak/S/II/2024',
                'tanggal_sk'         => '2024-02-19',
                'tanggal_kadaluarsa' => '2029-02-18',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Bahasa Inggris',
                'akreditasi'         => 'A',
                'nomor_sk'           => '12850/SK/BAN-PT/Ak-PPJ/S/XII/2021',
                'tanggal_sk'         => '2021-12-07',
                'tanggal_kadaluarsa' => '2026-12-02',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Kimia',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '256/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-03-04',
                'tanggal_kadaluarsa' => '2029-03-03',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Matematika',
                'akreditasi'         => 'Unggul',
                'nomor_sk'           => '199/SK/LAMDIK/Ak/S/III/2024',
                'tanggal_sk'         => '2024-03-04',
                'tanggal_kadaluarsa' => '2029-03-03',
            ],
            [
                'nama_jurusan'       => 'Pendidikan Profesi Guru',
                'akreditasi'         => 'B',
                'nomor_sk'           => '12302/SK/BAN-PT/Akred/PP/XI/2021',
                'tanggal_sk'         => '2021-11-09',
                'tanggal_kadaluarsa' => '2026-11-09',
            ],
        ];

        foreach ($data as $row) {
            Akreditasi::create(array_merge($row, [
                'dokumen' => '#',
            ]));
        }
    }
}
