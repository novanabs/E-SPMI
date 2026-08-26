# Laporan Audit Selisih Nilai AMI — Pendidikan Komputer (TA 2026)

> **Objek**: Penilaian AMI auditor atas Pendidikan Komputer, tahun audit 2026
> **Sumber data**: database produksi (dump hosting 24 Aug 2026)
> **Gejala**: sisi auditor menampilkan **Nilai AMI 329.65**, sisi jurusan/UPM menampilkan **Nilai AMI Auditor 329.69** untuk penilaian yang sama

---

## 1. Konteks

| Aktor | User |
|---|---|
| Jurusan yang dinilai | Pendidikan Komputer — user id **5**, Drs. Harja Santana Purba, M.Kom., Ph.D. |
| Auditor penugasan | user id **30**, Dr. Dra. Hj. Rochgiyanti, M.Si., M.Pd. (`auditor_jurusan`, 2026) |
| Baris skor auditor | `users_matrik` dengan `id_users=5`, `id_user_jurusan=5`, `tahun=2026` → **65 item** (lengkap) |

Kedua halaman membaca **baris data yang sama persis**. Selisih murni berasal dari **perbedaan urutan pembulatan** saat mengagregasi.

## 2. Akar masalah

### Sisi Auditor — jumlah dulu, bulatkan terakhir → **329.65**

`resources/views/auditor/evaluasi.blade.php:1671–1677`

```js
document.querySelectorAll(".nav-item-btn").forEach(btn => {
    total += parseFloat(btn.dataset.nilai_total);   // nilai MENTAH dari atribut
});
el("total_nilai_semua").innerText = total.toFixed(2); // dibulatkan SEKALI di akhir
```

Atribut `data-nilai_total` dirender dari kolom mentah `$item->userMatrik->nilai_total` tanpa pembulatan.

### Sisi Jurusan/UPM — bulatkan tiap item dulu, baru dijumlah → **329.69**

`resources/views/EvaluasiLamdik/show.blade.php:166–169` merender tiap sel sudah dibulatkan:

```blade
{{ $firstAuditorScore > 0 ? number_format($firstAuditorScore, 2) : '-' }}
```

lalu `show.blade.php:998–1000` menjumlahkan **teks sel tersebut**:

```js
document.querySelectorAll(".nilai-auditor .auditor-value").forEach(el => {
    totalAuditor += parseFloat(el.textContent) || 0;   // menambah NILAI YANG SUDAH DIBULATKAN
});
```

Pola identik ada di halaman kembaran `resources/views/EvaluasiDiriJurusan/show.blade.php`.

## 3. Kenapa selisihnya bisa 0.04

Banyak `nilai_total` tersimpan dengan desimal panjang (hasil rumus rasio di JS, mis. `RK = (3·N1 + 2·N2 + N3)/NDTPS`, atau rata-rata ganda seperti `(3·skor_a + skor_b)/4 × poin`). Contoh: elemen 5 = **5.385416666666666**.

- Sisi auditor: semua desimal itu ikut dijumlahkan, hasil 329.6473658… baru dipangkas → kehilangan ±0.0026 dari 329.65.
- Sisi UPM: setiap item dipangkas dulu ke 2 desimal (`number_format`, pembulatan half-up). Untuk 21 item yang punya desimal >2, pemangkasan itu menambah/mengurangi ±maks 0.005 per item — dan secara bersamaan menggeser total sebesar **+0.0426342**.

## 4. Rincian per elemen (65 item)

Kolom "Nilai mentah" = isi kolom `users_matrik.nilai_total` apa adanya.
Kolom "Dibulatkan" = yang tampil & ikut dijumlahkan di sisi UPM.
Baris bertanda ▲/▼ adalah item penyumbang selisih (▲ = pembulatan menaikkan, ▼ = menurunkan).

| No | Elemen | Jwb | Skor A/B | Nilai mentah | Dibulatkan | Drift |
|---:|---|---|---|---:|---:|---|
| 1 | Ketepatan Rumusan Visi Keilmuan PS | 2.00 | — | 3.4375000000000000 | 3.44 | ▲ +0.0025 |
| 2 | Sosialisasi dan Tingkat Pemahaman Visi Keilmuan PS | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 3 | Peran Visi Keilmuan dalam Pelaksanaan Tridharma PT | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 4 | Evaluasi dan Refleksi Kriteria Visi Keilmuan PS dan TL | 3.00 | — | 4.5000000000000000 | 4.50 | |
| 5 ▲ | Keberadaan Tata Pamong | 3.00 | — | 5.3854166666666666 | 5.39 | +0.004583 |
| 6 ▲ | Pelaksanaan Tata Kelola | 2.00 | — | 3.4375000000000000 | 3.44 | +0.0025 |
| 7 ▲ | Kerjasama Tridharma Perguruan Tinggi | 3.59 | A:— /B:4 | 5.3854166666666666 | 5.39 | +0.004583 |
| 8 ▲ | Evaluasi dan Refleksi Kriteria Tata Pamong dan TL | 3.00 | — | 5.3854166666666666 | 5.39 | +0.004583 |
| 9 | Pelaksanaan Penerimaan Mahasiswa Baru | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 10 | Kualitas Input Mahasiswa | 4.00 | A:4 /B:4 | 5.0000000000000000 | 5.00 | |
| 11 ▲ | Rasio Jumlah Dosen terhadap Jumlah Mahasiswa | 3.32 | A:— /B:3 | 4.1458333333333333 | 4.15 | +0.004167 |
| 12 | Ketersediaan, Aksesibilitas, dan Kualitas Layanan Mhs | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 13 | Perlindungan Mahasiswa | 3.00 | — | 4.5000000000000000 | 4.50 | |
| 14 ▼ | Prestasi Akademik dan Non-Akademik Mahasiswa | 2.42 | A:— /B:1 | 4.8410069910317070 | 4.84 | −0.001007 |
| 15 ▲ | Produktivitas Karya Inovatif/Publikasi Ilmiah Mhs | 3.25 | A:— /B:1 | 8.1250000000000000 | 8.13 | +0.0050 |
| 16 ▲ | Kepuasan Mahasiswa | 3.25 | A:4 /B:3 | 4.8750000000000000 | 4.88 | +0.0050 |
| 17 | Evaluasi dan Refleksi Kriteria Mahasiswa dan TL | 3.00 | — | 4.5000000000000000 | 4.50 | |
| 18 | Pelaksanaan Seleksi Dosen dan Tenaga Kependidikan | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 19 ▲ | Kualifikasi Akademik dan Jabatan Akademik DTPS | 3.54 | A:4 /B:4 | 5.3061224489795915 | 5.31 | +0.003878 |
| 20 ▼ | Beban Kerja DTPS | 3.25 | A:4 /B:1 | 4.0625000000000000 | 4.06 | −0.0025 |
| 21 ▲ | Pengakuan Kepakaran DTPS | 3.25 | A:4 /B:1 | 5.6875000000000000 | 5.69 | +0.0025 |
| 22 ▲ | Pengembangan Kompetensi DTPS | 3.25 | A:4 /B:1 | 5.6875000000000000 | 5.69 | +0.0025 |
| 23 ▼ | Pengembangan Kompetensi Tenaga Kependidikan | 3.25 | A:4 /B:1 | 4.0625000000000000 | 4.06 | −0.0025 |
| 24 | Evaluasi dan Refleksi Kriteria Dosen/Tendik dan TL | 3.00 | — | 4.5000000000000000 | 4.50 | |
| 25 | Perencanaan dan Pengelolaan Keuangan | 4.00 | — | 4.0000000000000000 | 4.00 | |
| 26 | Penggunaan Anggaran | 2.00 | — | 3.0000000000000000 | 3.00 | |
| 27 | Ketersediaan dan Aksesibilitas Sarana Prasarana Utama | 4.00 | — | 4.0000000000000000 | 4.00 | |
| 28 | Ketersediaan dan Aksesibilitas Teknologi Informasi | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 29 | Keamanan, Keselamatan, dan Kesehatan Lingkungan (K3L) | 4.00 | — | 5.0000000000000000 | 5.00 | |
| 30 | Evaluasi dan Refleksi Kriteria Keuangan/Sarpras dan TL | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 31 | Pengembangan Kurikulum | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 32 | Pelaksanaan Pembelajaran | 4.00 | — | 8.0000000000000000 | 8.00 | |
| 33 | Integrasi Penelitian dan/atau PkM dalam Pembelajaran | 2.25 | A:2 /B:1 | 4.5000000000000000 | 4.50 | |
| 34 | Penilaian Pembelajaran | 3.00 | — | 6.0000000000000000 | 6.00 | |
| 35 | Perkuliahan Microteaching atau Keterampilan Sejenis | 4.00 | — | 8.0000000000000000 | 8.00 | |
| 36 | Magang Kependidikan | 2.00 | — | 3.5000000000000000 | 3.50 | |
| 37 | Pembimbingan Magang Kependidikan | 2.00 | — | 3.0000000000000000 | 3.00 | |
| 38 | Peningkatan Suasana Akademik | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 39 | Pembimbingan Tugas Akhir | 2.00 | — | 3.5000000000000000 | 3.50 | |
| 40 | Indeks Prestasi Kumulatif (IPK) Rata-Rata Lulusan | 4.00 | A:4 /B:4 | 4.0000000000000000 | 4.00 | |
| 41 ▼ | Masa Studi Lulusan | 3.42 | A:3 /B:4 | 5.1225000000000005 | 5.12 | −0.0025 |
| 42 ▲ | Kelulusan Tepat Waktu | 3.63 | A:4 /B:4 | 5.4478500000000000 | 5.45 | +0.00215 |
| 43 ▼ | Keberhasilan Studi Mahasiswa | 2.35 | A:2 /B:2 | 3.5236363636363639 | 3.52 | −0.003636 |
| 44 | Tracer Study | 2.00 | — | 3.0000000000000000 | 3.00 | |
| 45 ▲ | Kesiapkerjaan, Kewirausahaan, dan Studi Lanjut | 2.75 | A:3 /B:2 | 3.4375000000000000 | 3.44 | +0.0025 |
| 46 | Waktu Tunggu Mendapatkan Pekerjaan Pertama | 3.25 | A:4 /B:1 | 3.2500000000000000 | 3.25 | |
| 47 | Kesesuaian Bidang Kerja Lulusan | 3.25 | A:4 /B:1 | 3.2500000000000000 | 3.25 | |
| 48 | Kepuasan Pengguna Lulusan | 3.50 | A:4 /B:2 | 5.2500000000000000 | 5.25 | |
| 49 | Asesmen Pencapaian CPL | 4.00 | — | 8.0000000000000000 | 8.00 | |
| 50 | Evaluasi Kurikulum | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 51 | Evaluasi dan Refleksi Kriteria Pendidikan dan TL | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 52 | Peta Jalan Penelitian | 3.00 | — | 3.0000000000000000 | 3.00 | |
| 53 ▲ | Produktivitas Penelitian DTPS | 2.74 | A:3 /B:2 | 6.1666666666666666 | 6.17 | +0.003333 |
| 54 | Pelibatan Mahasiswa dalam Penelitian DTPS | 3.25 | A:4 /B:1 | 3.2500000000000000 | 3.25 | |
| 55 ▲ | Jumlah Publikasi Karya Ilmiah DTPS | 3.25 | A:4 /B:1 | 8.1250000000000000 | 8.13 | +0.0050 |
| 56 | Jumlah DTPS yang Melakukan Publikasi Karya Ilmiah | 3.25 | A:4 /B:1 | 6.5000000000000000 | 6.50 | |
| 57 | Jumlah Artikel Ilmiah DTPS yang Disitasi | 3.25 | A:4 /B:1 | 6.5000000000000000 | 6.50 | |
| 58 | Evaluasi dan Refleksi Kriteria Penelitian dan TL | 3.00 | — | 6.5000000000000000 | 6.50 | |
| 59 | Produktivitas PkM DTPS | 3.25 | A:4 /B:1 | 6.5000000000000000 | 6.50 | |
| 60 | Pelibatan Mahasiswa dalam PkM DTPS | 3.25 | A:4 /B:1 | 3.2500000000000000 | 3.25 | |
| 61 | Evaluasi dan Refleksi Kriteria PkM dan TL | 3.00 | — | 4.5000000000000000 | 4.50 | |
| 62 | Terbentuknya Unsur Pelaksana Penjaminan Mutu | 3.00 | — | 5.2500000000000000 | 5.25 | |
| 63 | Ketersediaan Perangkat Penjaminan Mutu | 4.00 | — | 6.0000000000000000 | 6.00 | |
| 64 | Pelaksanaan SPMI dengan Siklus PPEPP Standar PT | 3.00 | — | 7.5000000000000000 | 7.50 | |
| 65 | Evaluasi dan Refleksi Kriteria Penjaminan Mutu dan TL | 4.00 | — | 6.0000000000000000 | 6.00 | |

## 5. Rekonsiliasi total

| Metode | Rumus | Hasil |
|---|---|---|
| **Sisi Auditor** | Σ nilai mentah → dibulatkan sekali di akhir | 329.6473658036… → **329.65** |
| **Sisi Jurusan/UPM** | Σ (pembulatan 2-desimal per item) | **329.69** |
| **Selisih** | | **+0.0426341964** |

Penyumbang drift: **21 item** (ditandai ▲/▼ di tabel). Net drift positif karena pembulatan half-up `number_format`: nilai-nilai berakhiran tepat `.xx5` biner (3.4375 → 3.44, 8.125 → 8.13, 4.875 → 4.88, dst.) semuanya naik (+0.0025 s/d +0.005 per item), hanya sedikit yang turun (4.0625 → 4.06, 5.1225 → 5.12, dll.).

Verifikasi replikasi PHP (persis logika aplikasi):

```
Σ nilai mentah          : 329.6473658036
Σ number_format(x, 2)   : 329.69
```

## 6. Temuan tambahan (di luar selisih pembulatan)

Beberapa item `jenis=pilihan_ganda` menyimpan `nilai_total` yang **tidak sama dengan `poin × jawaban`**, contohnya di jurusan ini:

| No | jawaban | poin | poin × jawaban | nilai_total tersimpan |
|---:|---:|---:|---:|---:|
| 1 | 2.00 | 1.00 | 2.00 | 3.4375 |
| 5 | 3.00 | 1.25 | 3.75 | 5.385417 |
| 19 | 3.54 | 1.50 | 5.31 | 5.306122 |
| 58 | 3.00 | 1.50 | 4.50 | 6.500000 |

Total 10 dari 65 item berbeda material. Indikasi kuat JS sisi penilai menghitung ulang nilai dari rumus sub-item/rasio dan menimpa hasil radio pilihan ganda. Perlu diverifikasi terpisah apakah ini memang rumus resmi LAMDIK atau inkonsistensi antar halaman input.

## 7. Dampak

1. **Angka NA resmi tidak tunggal**: auditor melihat 329.65, jurusan/UPM melihat 329.69 untuk data identik.
2. **Risiko status akreditasi berbeda antar halaman** pada kasus batas: ambang di `hitungAkreditasi()` adalah 200 / 321 / 361. Saat ini kedua total (329.65 dan 329.69) masih di band yang sama, tetapi jurusan lain dengan NA ≈ 320.98 vs 321.02 bisa mendapat status berbeda di dua halaman.
3. Kolom **Selisih** (jurusan vs auditor) di halaman perbandingan ikut bergeser tipis.

## 8. Rekomendasi

1. Satukan aturan agregasi: **jumlahkan nilai mentah, pembulatan hanya sekali saat tampil**.
   Di `EvaluasiLamdik/show.blade.php` dan `EvaluasiDiriJurusan/show.blade.php`, simpan nilai mentah pada attribute lalu jumlahkan attribute tersebut:

   ```blade
   <span class="auditor-value" data-raw="{{ $firstAuditorScore ?? 0 }}">
       {{ $firstAuditorScore > 0 ? number_format($firstAuditorScore, 2) : '-' }}
   </span>
   ```
   ```js
   totalAuditor += parseFloat(el.dataset.raw) || 0;
   ```

   Catatan: fungsi `compute()` ada di **dua file kembar** — edit keduanya.
2. Pertimbangkan menyimpan `nilai_total` yang sudah konsisten 2 desimal di sumbernya (saat save), supaya seluruh halaman & PDF seragam.
3. Telusuri temuan #6 (nilai_total ≠ poin × jawaban) sebelum dipakai sebagai angka resmi.

---
*Dibuat otomatis dari verifikasi database lokal (snapshot hosting 24 Aug 2026) + replikasi PHP `artisan tinker`. Angka dapat direproduksi ulang dengan query di bagian 4.*
