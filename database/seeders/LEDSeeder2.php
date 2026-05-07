<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LEDSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'nomor'                => 7,
                'id_kriteria'          => 2,
                'elemen'               => ' Kerjasama tridharma perguruan tinggi ',
                'poin'                 => ' 1.50 ',
                'indikator'            => '  UPPS menjalin kerjasama dalam bidang pendidikan, penelitian, dan PkM dengan pihak lain di tingkat wilayah/lokal, nasional dan internasional dalam 3 tahun terakhir. Skor = ((2 x A) + B) / 3  ',
                'harkat_penskoran'     => <<<TEXT
Jika RK ≥ 4, maka A = 4 
Jika RK < 4 , maka A = RK 

RK = ((a x N1) + (b x N2) + (c x N3)) / NDTPS  Faktor: a = 3, b = 2, c = 1

N1 = Jumlah kerjasama pendidikan. 
N2 = Jumlah kerjasama penelitian. 
N3 = Jumlah kerjasama PkM. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.

Jika NI ≥ a , maka B = 4
Jika NI < a dan NN ≥ b ,
maka B = 3 + (NI / a)
Jika NI = 0 dan NN = 0 dan NW ≥ c
maka B = 2
Jika 0 < NI < a dan 0 < NN < b ,
maka B = 2 + (2 x (NI/a)) + (NN/b) - ((NI x NN)/(a x b))
Jika NI = 0 dan NN = 0 dan NW < c
maka B = 1

NI = Jumlah kerjasama tingkat internasional.   Faktor: a = 2 , b = 6 , c = 9 
NN = Jumlah kerjasama tingkat nasional. 
NW = Jumlah kerjasama tingkat wilayah/lokal.
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 11,
                'id_kriteria'          => 3,
                'elemen'               => ' Rasio jumlah dosen terhadap jumlah mahasiswa  ',
                'poin'                 => ' 1.25 ',
                'indikator'            => ' Rasio jumlah DTPS terhadap jumlah mahasiswa memungkinkan mahasiswa berinteraksi dengan dan memperoleh bimbingan dari dosen dengan baik.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Kelompok Sains Teknologi 
Jika 15 ≤ RMD ≤ 25,
maka Skor = 4
Jika RMD < 15 , maka Skor = (4 x RMD) / 15
Jika 25 < RMD ≤ 35 , maka Skor = (70 - (2 x RMD)) / 5
Jika RMD > 35,maka Skor = 1 

Kelompok Sosial Humaniora 
Jika 25 ≤ RMD ≤ 35,
maka Skor = 4
Jika RMD < 25 , maka Skor = (4 x RMD) / 25
Jika 35 < RMD ≤ 50 , maka Skor = (200 - (4 x RMD)) / 15
Jika RMD > 50 ,
maka Skor = 1

NM = Jumlah mahasiswa pada saat TS. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.  
RMD = NM / NDTPS
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 14,
                'id_kriteria'          => 3,
                'elemen'               => ' Prestasi akademik dan non akademik mahasiswa  ',
                'poin'                 => ' 2.00 ',
                'indikator'            => '  Mahasiswa memiliki prestasi akademik (seperti juara juara 1,2,3 dalam LKTI/PIMNAS dan sejenisnya, mengikuti program pertukaran mahasiswa internasional, dan meraih medali di olimpiade sains) dan non akademik (seperti juara di bidang olah raga, bidang seni, dan bidang kepemimpinan/organisasi)  dalam lima tahun terakhir.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika RI < a dan RN ≥ b, maka Skor = 3 + (RI/a) 
Jika RI = 0 dan RN = 0 dan RW ≥ c,
maka Skor = 2 
Jika RI ≥ a, maka Skor = 4 
Jika0<RI<a dan 0<RN<b, maka Skor = 2 + (2 x (RI/a)) + (RN/b) - ((RI
x RN)/(a x b)
Jika RI = 0 dan RN = 0 dan RW < c,
maka Skor = 1

Faktor: a = 0,1%, b = 1%, c = 2%
RI = NI/NM, RN = NN/NM, RW = NW/NM
NI = Jumlah prestasi akademik dan non akademik tingkat internasional.
NN = Jumlah prestasi akademik dan non akademik tingkat nasional.
NW = Jumlah prestasi akademik dan non akademik tingkat wilayah/lokal.
NM = Jumlah mahasiswa pada saat TS. 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 16,
                'id_kriteria'          => 3,
                'elemen'               => ' Kepuasan mahasiswa ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS/PS melakukan pengukuran kepuasan mahasiswa terhadap (a) performa mengajar dosen, layanan administrasi akademik, dan kuantitaskualitas fasilitas pendidikan yang memenuhi 6 aspek sebagai berikut: (1 menggunakan instrumen kepuasan yang valid dan mudah digunakan, (2) dilaksanakan di setiap akhir semester dan datanya terekam secara lengkap, (3) hasilnya dianalisis dengan metode yang tepat dan bermanfaat untuk pengambilan keputusan, (4) dilakukan review terhadap hasil pelaksanaan pengukuran kepuasan, (5) ditindaklanjuti untuk perbaikan dan peningkatan mutu pengajaran, dan (6)hasilnya dipublikasikan dan mudah diakses; dan (b) memperlihatkan tingkat kepuasan mahasiswa hsil pengukuran tersebut Skor = ((2xa)+b)/3  ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS/PS melaksanakan pengukuran kepuasan mahasiswa terhadap kinerja mengajar dosen, layanan administrasi akademik, dan kuantitas-kualitas fasilitas pendidikan, dengan memenuhi 6 aspek. TKM ≥ 75% ',
                    3 => 'UPPS/PS melaksanakan pengukuran kepuasan mahasiswa terhadap kinerja mengajar dosen, layanan administrasi akademik, dan kuantitas-kualitas fasilitas pendidikan, dengan memenuhi 5 aspek. 50% ≤ TKM < 75% ',
                    2 => 'UPPS/PS melaksanakan pengukuran kepuasan mahasiswa terhadap kinerja mengajar dosen, layanan administrasi akademik, dan kuantitas-kualitas fasilitas pendidikan, dengan memenuhi 4 aspek. 25% ≤ TKM < 50% ',
                    1 => 'UPPS/PS melaksanakan pengukuran kepuasan mahasiswa terhadap kinerja mengajar dosen, layanan administrasi akademik, dan kuantitas-kualitas fasilitas pendidikan, dengan memenuhi  < 4 aspek. TKM < 25% '
                ]),
                'harkat_penskoran'     =>
                    <<<TEXT
Tingkat kepuasan pengguna pada aspek:
TKM1: Reliability; TKM2: Responsiveness; TKM3: Assurance; TKM4: Empathy; TKM5: Tangible.

Tingkat kepuasan mahasiswa pada aspek ke-i dihitung dengan rumus sebagai berikut:
TKMi = (4 x ai) + (3 x bi) + (2 x ci) + di i = 1, 2, ..., 7 

dimana: ai = persentase “Sangat Baik”; bi = persentase “Baik”; ci = persentase “Cukup”; di = persentase “Kurang”.

TKM = ƩTKMi / 5 
TEXT,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 19,
                'id_kriteria'          => 4,
                'elemen'               => ' Kualiﬁkasi akademik  dan jabatan akademik/Fungsional DTPS',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' Pada saat TS, Dosen Tetap Program Studi (DTPS) memiliki kualifikasi akademik dan jabatan akademik/fungsional yang dipersyaratkan. Skor = (a + b) /2 ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PDS3 ≥ 40%,  
maka Skor = 4
Jika PGBLKL ≥ 70% ,
maka Skor = 4

Jika PDS3 < 40% ,  maka Skor = 2 + (5 x PDS3) 
Jika PGBLKL < 70% , 
maka Skor = 2 + ((20 x PGBLKL) /7)

Tidak ada skor 1 
Tidak ada skor 1 

NDS3 = Jumlah DTPS yang dengan kualifikasi akademik tertinggi Doktor.
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti 
program studi yang diakreditasi.
NDGB = Jumlah DTPS yang memiliki jabatan akademik Guru Besar.
NDLK = Jumlah DTPS yang memiliki jabatan akademik Lektor Kepala.
NDL = Jumlah DTPS yang memiliki jabatan akademik Lektor.

PDS3 = (NDS3/NDTPS) x 100%
PGBLKL = ((NDGB + NDLK + NDL) / NDTPS) x 100% 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 20,
                'id_kriteria'          => 4,
                'elemen'               => ' Beban kerja  DTPS',
                'poin'                 => ' 1.25 ',
                'indikator'            => 'Beban Kerja dalam satu tahun terakhir memungkinkan DTPS bekerja secara maksimal. ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika 12 ≤ BKD ≤ 16, maka Skor = 4

Jika 6 ≤ BKD < 12, maka Skor = ((2 x BKD) - 12) / 3
Jika 16 < BKD ≤ 18, maka Skor = 36 - (2 x BKD)

Jika BKD < 6 atau BKD > 18, maka Skor =1 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 21,
                'id_kriteria'          => 4,
                'elemen'               => ' Pengakuan kepakaran DTPS ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' DTPS memiliki prestasi yang diakui di tingkat wilayah/lokal,  nasional dan/atau internasional. ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika RRD ≥ 1, maka Skor = 4. 

Jika RRD < 1, maka Skor = 2 + (2 x RRD). 

Tidak ada Skor kurang dari 2. 

Pengakuan/rekognisi atas kepakaran/prestasi/kinerja DTPS dapat berupa: 
a. menjadi visiting lecturer atau visiting scholar di program studi/perguruan tinggi terakreditasi A/Unggul atau program
studi/perguruan tinggi internasional bereputasi. 
b. menjadi keynote speaker/invited speaker pada pertemuan ilmiah tingkat nasional/ internasional. 
c. menjadi editor atau mitra bestari pada jurnal nasional terakreditasi/jurnal internasional bereputasi di bidang yang sesuai dengan
bidang program studi. 
d. menjadi staf ahli/narasumber di lembaga tingkat wilayah/nasional/internasional pada bidang yang sesuai dengan bidang program
studi (untuk pengusul dari program studi pada program Sarjana/Magister/Doktor), atau menjadi tenaga ahli/konsultan di
lembaga/industri tingkat wilayah/nasional/ internasional pada bidang yang sesuai dengan bidang program studi (untuk pengusul
dari program studi pada program Diploma Tiga/Sarjana Terapan/Magister Terapan/Doktor Terapan). 
e. mendapat penghargaan atas prestasi dan kinerja di tingkat wilayah/nasional/internasional. 

RRD = NRD / NDTPS 
NRD = Jumlah pengakuan atas prestasi/kinerja DTPS yang relevan dengan bidang keahlian dalam 3 tahun terakhir. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 33,
                'id_kriteria'          => 6,
                'elemen'               => ' Integrasi penelitian dan/atau PkM dalam pembelajaran  ',
                'poin'                 => ' 2 ',
                'indikator'            => ' DTPS mengintegrasikan penelitian dan/atau PkM dalam pembelajaran yang memenuhi aspek berikut: (1) hasil penelitian/PkM relevan dengan mata kuliah; (2) hasil penelitian menjadi bagian dari materi mata kuliah; (3) pengintegrasian disertai bukti, seperti materi presentasi, handout, atau modul; (b) DTPS yang  mengintegrasikan hasil penelitian/PkM dalam pembelajaran mencapai jumlah yang memadai; (c) jumlah mata kuliah yang dikembangkan berdasarkan integrasi hasil penelitian/PkM dalam 3 tahun terakhir. ',
                'harkat_penskoran'     =>
                    <<<TEXT
DTPS mengintegrasikan
penelitian dan/atau PkM dalam
pembelajaran dengan
memenuhi  3 aspek. 
PDIPPKM ≥ 50 % 

DTPS mengintegrasikan
penelitian dan/atau PkM dalam
pembelajaran dengan
memenuhi  2 aspek. 
30% ≤ PDIPPKM < 50% 

DTPS mengintegrasikan
penelitian dan/atau PkM dalam
pembelajaran dengan
memenuhi  1 aspek. 
10%≤ PDIPPKM < 30% 

DTPS tidak mengintegrasikan
penelitian dan/atau PkM dalam
pembelajaran. 
PDIPPKM <10% 

PDIPPKM = (NDIPPKM / NDTPS) x 100%

NDIPPKM = Jumlah DTPS yang melakukan integrasi kegiatan penelitian dan PkM dalam pembelajaran dalam 3 tahun terakhir. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.

Jika PMKI ≥ 25%, maka skor PMKI = 4 

Jika 15% ≤ PMKI < 25% ,maka Skor PMKI = 3 +(PMKI - 0,25)/0,10

Jika PMKI < 15%, maka skor PMKI = 2

Tidak ada skor 1 

NMKI = Jumlah mata kuliah yang dikembangkan berdasarkan integrasi hasil penelitian/PkM DTPS dalam 3 tahun terakhir.
NMK = Jumlah mata kuliah.
PMKI = (NMKI / NMK) x 100%
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 40,
                'id_kriteria'          => 6,
                'elemen'               => ' IPK rata-rata lulusan ',
                'poin'                 => ' 1 ',
                'indikator'            => ' lulusan PS memiliki rata-rata IPK yang baik dalam 3 tahun terakhir. RIPK = Rata-rata IPK lulusan dalam 3 tahun terakhir ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika RIPK ≥ 3,25, maka Skor = 4 

Jika 2,00 ≤ RIPK < 3,25, 
maka Skor = ((8 x RIPK) - 6) / 5 

Tidak ada skor 1 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 42,
                'id_kriteria'          => 6,
                'elemen'               => ' Lama studi mahasiswa ',
                'poin'                 => ' 1.5 ',
                'indikator'            => ' Lulusan PS memiliki rata-rata masa studi yang sesuai dengan masa empuh kurikulum. RMS = rata-rata masa studi lulusan (dalam tahun)  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika 3,5 < RMS ≤ 4,0, maka Skor = 4

Jika 3 < RMS ≤ 3,5, maka skor = 4 – ((RMS-3)/0,5) x 2

Jika RMS ≤ 3 dan RMS > 4, maka skor = 1 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 43,
                'id_kriteria'          => 6,
                'elemen'               => ' Kelulusan tepat waktu ',
                'poin'                 => ' 1.5 ',
                'indikator'            => ' Mahasiswa dapat menyelesaikan studinya sesuai masa tempuh kurikulum (MTK). PMTK = Persentase mahasiswa dapat menyelesaikan studi sesuai masa tempuh kurikulum.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PMTK ≥ 50%, maka skor = 4

Jika PMTK < 50%,
maka Skor = 1 + (6 x PMTK) 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 44,
                'id_kriteria'          => 6,
                'elemen'               => ' Keberhasilan studi mahasiswa ',
                'poin'                 => ' 1.5 ',
                'indikator'            => '  Mahasiswa berhasil menyelesaikan studinya. PKSM = Persentase keberhasilan studi lulusan ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PKMS ≥ 85%, 
maka Skor = 4 

Jika 45% ≤ PKMS < 85% , 
maka Skor = ((80 x PKMS) - 24) / 11

Jika PKMS < 45%,
maka Skor = 1 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 45,
                'id_kriteria'          => 6,
                'elemen'               => ' Employability, kewirausahaan, dan studi lanjut',
                'poin'                 => ' 1.25 ',
                'indikator'            => ' Setelah menyelesaikan studi, para lulusan PS (a) bekerja di lembaga pendidikan tertentu atau bidang lainnya yang relevan dengan proﬁl lulusan, (b) melakukan usaha mandiri, (c) melakukan studi lanjut ke S2, atau (d) mengikuti program pendidikan profesi guru (PPG). PLB = Persentase jumlah lulusan yang bekerja, usaha mandiri, studi lanjut, mengikuti PPG (a + b + c + d) ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' PLB ≥ 80%.',
                    3 => ' 60% ≤ PLB < 80%  ',
                    2 => ' 40% ≤ PLB < 60% ',
                    1 => ' PLB < 40% '
                ]),
                'harkat_penskoran'     =>
                    <<<TEXT
Ketentuan persentase responden lulusan:  
untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) ≥ 150 orang, maka Prmin = 30%. 
untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) < 150 orang, maka Prmin = 50% - ((NL / 150) x 20%) Jika
persentase responden memenuhi ketentuan di atas, maka Skor akhir = Skor. 

Jika persentase responden tidak memenuhi ketentuan di atas, maka berlaku penyesuaian sebagai berikut: Skor akhir = (PJ / Prmin) x Skor. 
NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) 
NJ = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak 
PJ = Persentase lulusan yang terlacak = (NL / NJ) x 100% 
Prmin = Persentase responden minimum
TEXT,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 46,
                'id_kriteria'          => 6,
                'elemen'               => ' Waktu tunggu mendapatkan pekerjaan pertama ',
                'poin'                 => ' 1 ',
                'indikator'            => ' Mahasiswa PS mendapatkan pekerjaan pertama setelah lulus. WTMP = waktu tunggu lulusan untuk mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika WTMP < 6 bulan, maka Skor = 4.

Jika 6 ≤ WTWP ≤ 12, maka Skor = (18 – WTMP) / 3. 

WTWP > 12 bulan, maka Skor = 1 

Ketentuan persentase responden lulusan: 
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) ≥ 150 orang, maka Prmin = 30%. 
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) < 150 orang, maka Prmin = 50% - ((NL / 150) x 20%
Jika persentase responden memenuhi ketentuan diatas, maka Skor akhir = Skor. 
Jika persentase responden tidak memenuhi ketentuan diatas, maka berlaku penyesuaian sebagai berikut: 
Skor akhir = (PJ / Prmin) x Skor. 

NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) 
NJ = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak 
PJ = Persentase lulusan yang terlacak = (NL / NJ) x 100%  
Prmin = Persentase responden minimum 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 47,
                'id_kriteria'          => 6,
                'elemen'               => ' Kesesuaian bidang kerja lulusan ',
                'poin'                 => ' 1 ',
                'indikator'            => ' Lulusan PS memperoleh pekerjaan pertama yang sesuai dengan bidang keilmuan PS (TS-4 sampai dengan TS2) PBS = Kesesuaian bidang kerja lulusan saat mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2. ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PBS ≥ 60%, maka Skor = 4

Jika 15% < PBS < 60%, maka Skor = (20 x PBS) / 3 

Jika PBS <= 15%, maka skor = 1 

Ketentuan persentase responden lulusan: 
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) ≥ 150 orang, maka Prmin = 30%. 
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) < 150 orang, maka Prmin = 50% - ((NL / 150) x 20%) 

Jika persentase responden memenuhi ketentuan diatas, maka Skor akhir = Skor. 
Jika persentase responden tidak memenuhi ketentuan diatas, maka berlaku penyesuaian sebagai berikut: 
Skor akhir = (PJ / Prmin) x Skor. 

NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) 
NJ = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak  
PJ = Persentase lulusan yang terlacak = (NL / NJ) x 100%  
Prmin = Persentase responden minimum 

Skor = Tki/9 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 48,
                'id_kriteria'          => 6,
                'elemen'               => ' Kepuasan pengguna lulusan ',
                'poin'                 => ' 1.5 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi tingkat kepuasan pengguna lulusan terhadap kompetensi yang dimiliki oleh lulusan, yang mencakup aspek (a) etika, (b) keahlian pada bidang ilmu (kompetensi utama), (c) kemampuan berbahasa asing, (d) penggunaan teknologi informasi, (e) kemampuan berkomunikasi, (f) kerjasama (g) pengembangan diri (h) berpikir kritis, dan (i) kreativitas.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Skor =TKi/9 Tingkat kepuasan aspek ke-i dihitung dengan rumus sebagai berikut: 
TKi = (4 x ai) + (3 x bi) + (2 x ci) + di i = 1, 2, ..., 9
ai = persentase “sangat baik”. 
bi = persentase “baik”. 
ci = persentase “cukup”. 
di = persentase “kurang”.

Ketentuan persentase responden lulusan:
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) ≥ 150 orang, maka Prmin = 30%.
- untuk program studi dengan jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) < 150 orang, maka Prmin = 50% - ((NL / 150) x 20%)
Jika persentase responden memenuhi ketentuan diatas, maka Skor akhir = Skor.
Jika persentase responden tidak memenuhi ketentuan diatas, maka berlaku penyesuaian sebagai berikut: Skor akhir = (PJ / Prmin) x Skor.
NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)
NJ = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak
PJ = Persentase lulusan yang terlacak = (NL / NJ) x 100%
Prmin = Persentase responden minimum
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 53,
                'id_kriteria'          => 7,
                'elemen'               => ' Produktivitas penelitian DTPS ',
                'poin'                 => ' 2.25 ',
                'indikator'            => ' DTPS melakukan penelitian dengan dana mandiri/PT, dana dalam negeri, dan dana dari luar negeri dalam tiga tahun terakhir.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika RI ≥ a, maka Skor = 4

Jika RI < a dan RN ≥ b, maka Skor = 3 + (RI / a) 
Jika 0 < RI < a dan 0 < RN < b, maka Skor = 2 + (2 x (RI/a)) + (RN/b) - ((RI x RN)/(a x b))

Jika RI = 0 dan RN = 0 dan RL ≥ c, maka Skor = 2

Jika RI = 0 dan RN = 0 dan RL < c, maka Skor = 1

RI = NI / 3 / NDTPS, RN = NN / 3 / NDTPS , RL = NL / 3 / NDTPS Faktor: a = 0,05, b = 0,3 , c = 1  
NI = Jumlah penelitian dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir.  
NN = Jumlah penelitian dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir. 
NL = Jumlah penelitian dengan sumber pembiayaan PT/ mandiri dalam 3 tahun terakhir. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi. 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 54,
                'id_kriteria'          => 7,
                'elemen'               => ' Pelibatan mahasiswa dalam penelitian DTPS ',
                'poin'                 => ' 1 ',
                'indikator'            => ' DTPS melibatkan mahasiswa dalam kegiatan penelitiannya. ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PPDM ≥ 75%, maka Skor = 4

Jika PPDM < 75%, maka Skor = 2 + (8 x PPDM) 

Tidak ada skor 1 

PPDM = (NPM / NPD) x 100%

NPM = Jumlah judul penelitian DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir. 
NPD = Jumlah judul penelitian DTPS dalam 3 tahun terakhir.
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 55,
                'id_kriteria'          => 7,
                'elemen'               => ' Jumlah karya ilmiah DTPS',
                'poin'                 => ' 2.50 ',
                'indikator'            => ' Dalam tiga tahun terakhir, DTPS mempublikasikan karya ilmiah dalam umlah yang memadai.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
                
Jika RI ≥ a, maka Skor = 4 

Jika RI < a dan RN ≥ b , maka Skor = 3 + (RI / a) 
Jika 0 < RI < a dan 0 < RN < b, maka Skor = 2 + (2 x (RI/a)) + (RN/b) - ((RI x RN)/(a x b))

Jika RI = 0 dan RN = 0 dan RW ≥ c
, maka Skor = 2
Jika RI = 0 dan RN = 0 dan RW < c
, maka Skor = 1 

RW = (NA1 + NB1 + NC1) / NDTPS , RN = (NA2 + NA3 + NB2 + NC2) / NDTPS , RI = (NA4 + NB3 + NC3) / NDTPS 
Faktor: a = 0,1 , b = 1 , c = 2 

NA1 = Jumlah publikasi di jurnal nasional tidak terakreditasi. 
NA2 = Jumlah publikasi di jurnal nasional terakreditasi. 
NA3 = Jumlah publikasi di jurnal internasional. 
NA4 = Jumlah publikasi di jurnal internasional bereputasi 
NB1 = Jumlah publikasi di seminar wilayah/lokal/PT. 
NB2 = Jumlah publikasi di seminar nasional. 
NB3 = Jumlah publikasi di seminar internasional. 
NC1 = Jumlah tulisan di media massa wilayah. 
NC1 = Jumlah tulisan di media massa nasional. 
NC3 = Jumlah tulisan di media massa internasional. 

NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 57,
                'id_kriteria'          => 7,
                'elemen'               => ' Jumlah karya ilmiah DTPS yang Disitasi ',
                'poin'                 => ' 2 ',
                'indikator'            => ' Jumlah artikel ilmiah DTPS yang disitasi dalam 3 tahun terakhir. ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' RSA ≥ 9   ',
                    3 => ' 6 ≤ RSA < 9 ',
                    2 => ' 3 ≤ RSA < 6  ',
                    1 => ' RSA < 3  '
                ]),
                'harkat_penskoran'     =>
                    <<<TEXT
RSA = NAS / NDTPS 
NAS = jumlah artikel yang disitasi. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.
TEXT,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 59,
                'id_kriteria'          => 8,
                'elemen'               => ' Produktivitas PkM DTPS ',
                'poin'                 => ' 2 ',
                'indikator'            => ' DTPS memiliki produktivitas PkM dengan dana mandiri/PT, dana dalam negeri, dan dana dari luar negeri dalam tiga tahun terakhir.  ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika RI ≥ a, maka Skor = 4 

Jika RI < a dan RN ≥ b, maka Skor = 3 + (RI / a) 

Jika 0 < RI < a dan 0 < RN < b, maka Skor = 2 + (2 x (RI/a)) + (RN/b) - ((RI x RN)/(a x b))

Jika RI = 0 dan RN = 0 dan RL ≥ c, maka Skor = 2

Jika RI = 0 dan RN = 0 dan RL < c, maka Skor = 1 

RI = NI / 3 / NDTPS, RN = NN / 3 / NDTPS , RL = NL / 3 / NDTPS Faktor: a = 0,05, b = 0,3 , c = 1 
NI = Jumlah PkM dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir. 
NN = Jumlah PkM dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir. 
NL = Jumlah PkM dengan sumber pembiayaan PT/ mandiri dalam 3 tahun terakhir. 
NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti
program studi yang diakreditasi.
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
            [
                'nomor'                => 60,
                'id_kriteria'          => 8,
                'elemen'               => ' Pelibatan mahasiswa dalam PkM DTPS ',
                'poin'                 => ' 1 ',
                'indikator'            => ' DTPS melibatkan mahasiswa dalam kegiatan PkM. ',
                'harkat_penskoran'     =>
                    <<<TEXT
Jika PPkDM ≥ 75%, maka Skor =
4
Jika PPkDM < 75%, maka Skor = 2 + (8 x PPkDM)

Tidak ada skor 1

PPkDM = (NPM / NPDTPS) x 100%

NPkM = Jumlah judul PkM DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir. 
NPkDTPS = Jumlah judul PkM DTPS dalam 3 tahun terakhir. 
TEXT,
                'option_pilihan_ganda' => null,
                'jenis'                => 'isian',
            ],
        ];

        DB::table('matriks_lembar_evaluasi_diri')->upsert(
            $data,
            ['nomor'], // kolom unik
            [
                'id_kriteria',
                'elemen',
                'poin',
                'indikator',
                'harkat_penskoran',
                'option_pilihan_ganda',
                'jenis'
            ]
        );
    }
}
