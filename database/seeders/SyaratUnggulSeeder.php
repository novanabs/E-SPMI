<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyaratUnggulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor'        => 1,
                'elemen'       => "Kualitas DTPS (Elemen 19 di Buku 4)",
                'no_elemen'    => 19,
                'indikator'    => "Pada saat TS, Dosen Tetap Program Studi (DTPS) memiliki kualifikasi akademik doktor dan jabatan akademik tertentu.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "a. ≥ 1 DTPS memiliki kualifikasi akademik doktor. b. ≥ 2 DTPS memiliki jabatan akademik minimal lektor",
                    '5_Tahun' => "a. ≥ 2 DTPS memiliki kualifikasi akademik doktor. b. ≥ 2 DTPS memiliki jabatan akademik minimal lektor dan ≥ 1 DTPS memiliki jabatan akademik minimal lektor kepala."
                ]),
            ],
            [
                'nomor'        => 2,
                'elemen'       => "Kurikulum (Elemen 49 di Buku 4)",
                'no_elemen'    => 49,
                'indikator'    => "Program Studi (PS) melakukan asesmen pencapaian Capaian Pembelajaran Lulusan (CPL) berdasarkan capaian hasil belajar mahasiswa pada mata kuliah penciri keilmuan PS, melakukan evaluasi terhadap hasil asesmen pencapaian CPL, dan melakukan tindak lanjut hasil evaluasi terhadap hasil asesmen pencapaian CPL.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "Skor ≥ 3.0",
                    '5_Tahun' => "Skor ≥ 3.5"
                ]),
            ],
            [
                'nomor'        => 3,
                'elemen'       => "Pembelajaran Mikro (microteaching) atau nama lain yang sejenis (Elemen 35 di Buku 4)",
                'no_elemen'    => 35,
                'indikator'    => "PS melaksanakan microteaching atau nama lain yang sejenis bagi PS kependidikan nonmengajar sebagai tahapan pengembangan kompetensi mengajar atau kompetensi lain yang sejenis bagi PS kependidikan nonmengajar.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "Skor ≥ 3.0",
                    '5_Tahun' => "Skor ≥ 3.5"
                ]),
            ],
            [
                'nomor'        => 4,
                'elemen'       => "Pelaksanaan SPMI dengan siklus PPEPP standar pendidikan tinggi (Elemen 64 di Buku 4)",
                'no_elemen'    => 64,
                'indikator'    => "PT/UPPS/PS melaksanakan Sistem Penjaminan Mutu Internal (SPMI) dengan siklus Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan (PPEPP) standar pendidikan tinggi.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "Skor ≥ 3.0",
                    '5_Tahun' => "Skor ≥ 3.5"
                ]),
            ],
            [
                'nomor'        => 5,
                'elemen'       => "Produktivitas Karya Inovatif dan Karya Ilmiah Mahasiswa (Elemen 15 di Buku 4)",
                'no_elemen'    => 15,
                'indikator'    => "Dalam 5 tahun terakhir, mahasiswa dalam jumlah tertentu menghasilkan karya inovatif, publikasi ilmiah yang sesuai dengan bidang keilmuan PS, dan/atau karya seni yang dipamerkan/ dipagelarkan.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "≥ 15% mahasiswa memiliki karya inovatif yang dapat berbentuk book chapter atau buku berISBN, paten/paten sederhana, karya ilmiah yang dipublikasikan pada jurnal nasional terakreditasi minimal Sinta 5 sesuai dengan bidang keilmuannya, dan/atau karya seni yang dipamerkan/ dipagelarkan.",
                    '5_Tahun' => "≥ 25% mahasiswa memiliki karya inovatif yang dapat berbentuk book chapter atau buku berISBN, paten/paten sederhana, karya ilmiah yang dipublikasikan pada jurnal nasional terakreditasi minimal Sinta 4 sesuai dengan bidang keilmuannya, dan/atau karya seni yang dipamerkan/ dipagelarkan."
                ]),
            ],
            [
                'nomor'        => 6,
                'elemen'       => "Produktivitas Publikasi DTPS (Elemen 56 di Buku 4)",
                'no_elemen'    => 56,
                'indikator'    => "Dalam 3 tahun terakhir, DTPS memiliki publikasi di jurnal nasional dan/atau jurnal internasional sebagai penulis pertama atau corresponding author.",
                'syarat_tahun' => json_encode([
                    '3_tahun' => "≥ 20% DTPS memiliki publikasi pada jurnal nasional minimal Sinta 4 dan/atau jurnal internasional sebagai penulis pertama atau corresponding author.",
                    '5_Tahun' => "≥ 20% DTPS memiliki publikasi pada jurnal nasional terakreditasi minimal Sinta 2 dan/atau internasional bereputasi (terindeks scopus atau WoS) sebagai penulis pertama atau corresponding author."
                ]),
            ],
        ];

        foreach ($data as $item) {

            // 🔑 Ambil ID dari tabel matriks berdasarkan nomor elemen
            $matriks = DB::table('matriks_lembar_evaluasi_diri')
                ->where('nomor', $item['no_elemen'])
                ->first();

            if (!$matriks) {
                dd($matriks, $item['no_elemen']);
            }

            DB::table('syarat_unggul')->insert([
                'nomor'        => $item['nomor'],
                'elemen'       => $item['elemen'],
                'matriks_id'   => $matriks->id, // 🔥 relasi utama
                'indikator'    => $item['indikator'],
                'syarat_tahun' => $item['syarat_tahun'],
            ]);
        }
    }
}
