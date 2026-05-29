<?php
// Fill remaining elements for Pendidikan Komputer (user id=1)
// Run: php artisan tinker < database/fill_pilkom.php

use App\Models\MatriksLED;
use App\Models\UsersMatrik;
use App\Models\UserSubItemElemen;
use App\Models\SubItemElemen;
use Illuminate\Support\Facades\DB;

$userId = 1;

// Get all matriks IDs already filled by user 1
$filled = UsersMatrik::where('id_users', $userId)->pluck('id_matriks_led')->toArray();

// Get all matriks LED ordered by nomor
$allMatriks = MatriksLED::orderBy('nomor')->get();

$count = 0;
$subCount = 0;

foreach ($allMatriks as $matriks) {
    if (in_array($matriks->id, $filled)) {
        continue; // skip already filled
    }

    // Determine jawaban and nilai_total based on element type
    $jawaban = 4; // default: excellent
    $poin = (float) $matriks->poin;
    
    // Some elements get 3 instead of 4 for realism
    $nomor = $matriks->nomor;
    if (in_array($nomor, [5, 12, 28, 35, 36, 52, 58, 62])) {
        $jawaban = 3;
    }

    $nilaiTotal = $jawaban * $poin;

    // Create users_matrik record
    $um = UsersMatrik::create([
        'id_users' => $userId,
        'id_matriks_led' => $matriks->id,
        'jawaban' => $jawaban,
        'skor_a' => null,
        'skor_b' => null,
        'nilai_total' => $nilaiTotal,
        'kepemilikan_kriteria' => 'jurusan',
        'link_bukti' => null,
        'temuan' => null,
        'saran' => null,
    ]);
    $count++;

    // Fill sub-item variables if applicable
    $subItems = SubItemElemen::where('nomor_elemen', $nomor)->get();
    foreach ($subItems as $sub) {
        $value = match ($sub->variabel) {
            // Element 41 (Masa Studi)
            'RMS' => 4.0,
            // Element 44 (Tracer Study)
            'PKSM' => 85,
            default => null,
        };

        if ($value !== null && $value !== '') {
            UserSubItemElemen::create([
                'id_matriks' => $matriks->id,
                'id_sub_item_elemen' => $sub->id,
                'nilai' => $value,
                'id_users' => $userId,
                'id_user_jurusan' => null,
            ]);
            $subCount++;
        }
    }
}

echo "Filled {$count} new users_matrik records and {$subCount} sub-item records.\n";
echo "Total filled: " . UsersMatrik::where('id_users', $userId)->count() . " / {$allMatriks->count()}\n";
