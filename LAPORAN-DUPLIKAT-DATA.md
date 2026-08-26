# Laporan Duplikat Data — Database Produksi E-SPMI

> Sumber data: dump hosting `spmi.sql` (MariaDB, diekspor 24 Aug 2026), kini terimport di database lokal `spmi`.
> Analisis per 25 Aug 2026.

## 1. Apa itu "duplikat" di konteks ini

Satu penilaian yang seharusnya hanya punya **1 baris** tersimpan sebagai **2–4 baris kembar**.

Identitas unik satu penilaian adalah kombinasi:

| Tabel | Kombinasi yang seharusnya unik |
|---|---|
| `users_matrik` | (`id_users`, `id_user_jurusan`, `id_matriks_led`, `tahun`) |
| `users_sub_item_elemen` | (`id_users`, `id_user_jurusan`, `id_sub_item_elemen`, `tahun`) |

Aplikasi sendiri memperlakukan kombinasi ini sebagai kunci saat menyimpan (`UsersMatrik::updateOrCreate(...)`
di `EvaluasiLamdikController::store()` dan `UserController::auditorEvaluasiStore()`), tetapi **database tidak
memiliki UNIQUE constraint** untuk memaksakannya — jadi dua request yang masuk hampir bersamaan sama-sama
"tidak menemukan baris lama" dan sama-sama INSERT.

Hasil pemeriksaan dump produksi:

| Tabel | Grup duplikat | Baris berlebih |
|---|---|---|
| `users_matrik` | 4 grup | 6 baris |
| `users_sub_item_elemen` | 11 grup | 11 baris |

## 2. Kasus nyata — `users_matrik`

### Kasus 1 — 4 baris kembar (terparah)

**User id 4 — Dr. Mutiani, S.Pd., M.Pd (Pendidikan IPS)**, self-assessment tahun 2026,
item LED nomor 52 *"Peta Jalan Penelitian"*:

| row id | jawaban | link_bukti | created_at |
|---|---|---|---|
| 1530 | 4.00 | `https://pips.fkip.ulm.ac.id/sdd-sar/rese…` | 2026-08-07 05:07:19 |
| 1531 | 4.00 | `https://pips.fkip.ulm.ac.id/sdd-sar/rese…` | 2026-08-07 05:07:19 |
| 1532 | 4.00 | `https://pips.fkip.ulm.ac.id/sdd-sar/rese…` | 2026-08-07 05:07:19 |
| 1533 | 4.00 | **NULL** | 2026-08-07 05:07:19 |

Keempatnya dibuat di **detik yang sama** — pola khas double-submit / double-klik tombol simpan.
Perhatikan baris 1533 **kehilangan link buktinya**.

### Kasus 2 — dua baris dengan isi BERBEDA

**User id 11 — Dr. Dra. Hj. Rochgiyanti, M.Si., M.Pd (Pendidikan Sosiologi)**, item nomor 63
*"Ketersediaan Perangkat Penjaminan Mutu"*, 2026:

| row id | link_bukti |
|---|---|
| 636 | `https://drive.google.com/drive/folders/1…` (folder) |
| 637 | `https://drive.google.com/file/d/1WpSzQY_…` (file) |

Dua versi bukti yang berbeda — sistem akan menampilkan salah satunya secara **tidak tentu**.

### Kasus 3 & 4 — kembar identik

- **User id 15 — Dr. Rahmadi, S.Pd., M.Pd (Pendidikan Jasmani)**, item nomor 5 *"Keberadaan Tata Pamong"*:
  row id 618 dan 619 identik.
- **User id 12 — Dr. Agus Pratomo Andi Widodo, M.Pd (Pendidikan Khusus)**, baris sisi auditor,
  item nomor 23 *("Pengembangan Kompetensi Tenaga Kependidikan")*: row id 2153 dan 2154,
  `jawaban=3.25`, `skor_a=4`, `skor_b=1`.

## 3. Kasus nyata — `users_sub_item_elemen`

11 grup duplikat, semua baris self-assessment jurusan, tahun 2026:

| user id | Nama | Jurusan (homebase) | Variabel | Nilai yang tersimpan | Row id |
|---|---|---|---|---|---|
| 5 | Drs. Harja Santana Purba, M.Kom., Ph.D. | Pendidikan Komputer | NDS3 | 3, **3** | 1075–1076 |
| 6 | Dr. Syubhan An'nur, S.Pd.I., M.Pd. | Pendidikan IPA | BKD | 16, **16** | 2185–2186 |
| 6 | Dr. Syubhan An'nur, S.Pd.I., M.Pd. | Pendidikan IPA | **NAS** | 20, **203**, 20 ⚠️ | 2367–2369 |
| 7 | Prof. Dr. Karunia Puji Astuti, S.Pd., M.Pd. | Pendidikan Geografi | S1_DTPS | 3, **3** | 1350–1351 |
| 11 | Dr. Dra. Hj. Rochgiyanti, M.Si., M.Pd. | Pendidikan Sosiologi | NA4 | 3, **3** | 691–692 |
| 15 | Dr. Rahmadi, S.Pd., M.Pd. | Pendidikan Jasmani | TK1_SB | 1, **1** | 1694–1695 |
| 19 | Dr. Noor Cahaya, M.Pd. | Pend. Bahasa dan Sastra Indonesia | SINTA5_MHS | 16, **16** | 2327–2328 |
| 19 | Dr. Noor Cahaya, M.Pd. | Pend. Bahasa dan Sastra Indonesia | TK1_SB | 61.9, **61.9** | 2189–2190 |
| 20 | Dr. Muhammad Budi Zakia Sani, S.Pd., M.Pd. | Pendidikan Seni Pertunjukan | NM | 252, **252** | 2612–2613 |
| 20 | Dr. Muhammad Budi Zakia Sani, S.Pd., M.Pd. | Pendidikan Seni Pertunjukan | SINTA2_MHS | 0, **0** | 2621–2622 |
| 22 | Dr. Hj. Nina Permata Sari, S.Psi., M.Pd | Bimbingan Konseling | NI | 0, **0** | 1278–1279 |

⚠️ **Kasus paling berbahaya**: user id 6 (Pendidikan IPA), variabel **NAS**
(jumlah sitasi artikel ilmiah DTPS) — tiga baris berisi **20, 203, dan 20**.
Nilai 203 adalah typo dari input dobel. Baris mana yang dibaca sistem tidak dapat dipastikan,
padahal nilai NAS ikut menghitung skor elemen publikasi.

## 4. Pengaruh pada aplikasi

1. **Skor/bukti tampil berganti-ganti.**
   Relasi `MatriksLED::userMatrik()` (`app/Models/MatriksLED.php`) bertipe `hasOne` — ketika ada >1 baris,
   MySQL bebas mengembalikan yang mana. Radar chart, status akreditasi, dan PDF export bisa menampilkan
   nilai/link yang berbeda antar refresh, tanpa error apa pun.

2. **Nilai variabel bisa salah total.**
   Kasus NAS 20-vs-203 (user id 6): jika baris 203 yang terbaca, skor elemen publikasi Pendidikan IPA
   dihitung dari angka yang keliru ~10× lipat.

3. **Rata-rata/agregat bias.**
   Bagian kode yang menjumlahkan dengan JOIN langsung (tanpa filter duplikat) akan menghitung baris hantu;
   rata-rata tertarik ke arah nilai yang kebetulan dobel.

4. **Data temuan/saran bisa "hilang" secara ilusi.**
   Kasus Mutiani (row 1533 tanpa link bukti): pengeditan selanjutnya bisa update baris yang salah,
   membuat bukti yang sudah diisi tampak kosong kembali.

5. **Tidak reproducible saat debugging.**
   Bug "kadang muncul kadang tidak" karena bergantung pada urutan baris yang dikembalikan query.

## 5. Penyebab teknis

```php
// EvaluasiLamdikController::store() — dedup hanya logika aplikasi:
UsersMatrik::updateOrCreate(
    ['id_users' => …, 'id_matriks_led' => …, 'id_user_jurusan' => null, 'tahun' => $tahun],
    […]
);
```

Tanpa index unik di DB, dua request serentak (double-klik, retry jaringan, dua tab) keduanya lolos
pemeriksaan "belum ada" lalu sama-sama INSERT. Semua kasus di atas memiliki `created_at` dalam detik yang sama.

## 6. Cara mendeteksi ulang

```sql
SELECT id_users, IFNULL(id_user_jurusan,-1), id_matriks_led, tahun, COUNT(*)
FROM users_matrik
GROUP BY 1,2,3,4 HAVING COUNT(*)>1;

SELECT id_users, id_user_jurusan, id_sub_item_elemen, tahun, COUNT(*)
FROM users_sub_item_elemen
GROUP BY 1,2,3,4 HAVING COUNT(*)>1;
```

## 7. Rekomendasi perbaikan

1. **Bersihkan data** — simpan baris dengan `id` terbesar (versi terakhir diisi) per grup, hapus sisanya.
2. **Tambah migrasi unique index** agar DB menolak duplikat baru:

   ```php
   $table->unique(['id_users', 'id_user_jurusan', 'id_matriks_led', 'tahun'], 'um_unique');
   // catatan: kolom nullable → di MySQL baris NULL tidak saling konflik;
   // pertimbangkan kolom generated/virtual (mis. COALESCE) atau ubah id_user_jurusan menjadi NOT NULL
   ```
3. **(Opsional) cegah di sisi UI** — disable tombol simpan setelah klik pertama.
