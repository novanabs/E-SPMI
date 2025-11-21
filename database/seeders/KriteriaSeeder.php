<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Visi Keilmuan Program Studi',
                'deskripsi' => 'Menjelaskan arah, fokus keilmuan, serta pencapaian visi program studi dalam menghasilkan lulusan yang sesuai perkembangan ilmu dan kebutuhan masyarakat.'
            ],
            [
                'name' => 'Tata Pamong dan Tata Kelola UPPS',
                'deskripsi' => 'Mengatur sistem kepemimpinan, pengelolaan organisasi, serta tata kelola penyelenggaraan pendidikan yang transparan dan akuntabel di lingkungan UPPS.'
            ],
            [
                'name' => 'Mahasiswa',
                'deskripsi' => 'Mencakup kualitas penerimaan, layanan, pengembangan prestasi, dan keberhasilan studi mahasiswa dalam program pendidikan.'
            ],
            [
                'name' => 'Dosen dan Tenaga Kependidikan',
                'deskripsi' => 'Menguraikan kualifikasi, kompetensi, beban kerja, dan pengembangan profesional dosen serta tenaga kependidikan.'
            ],
            [
                'name' => 'Keuangan, Sarana, dan Prasarana Pendidikan',
                'deskripsi' => 'Menjelaskan kecukupan dan pengelolaan dana, fasilitas, serta lingkungan belajar yang menunjang proses pendidikan.'
            ],
            [
                'name' => 'Pendidikan',
                'deskripsi' => 'Menguraikan proses pembelajaran, kurikulum, metode, serta capaian pembelajaran lulusan yang diterapkan program studi.'
            ],
            [
                'name' => 'Penelitian',
                'deskripsi' => 'Mencakup aktivitas penelitian, produktivitas, relevansi, dan kontribusi penelitian terhadap pengembangan ilmu dan masyarakat.'
            ],
            [
                'name' => 'Pengabdian Kepada Masyarakat',
                'deskripsi' => 'Menggambarkan kegiatan pengabdian yang dilakukan dosen dan mahasiswa serta dampaknya bagi masyarakat.'
            ],
            [
                'name' => 'Penjaminan Mutu',
                'deskripsi' => 'Menjelaskan sistem penjaminan mutu internal meliputi perencanaan, pelaksanaan, evaluasi, dan peningkatan berkelanjutan.'
            ],
        ];

        DB::table('kriteria')->insertOrIgnore($data);
    }
}
