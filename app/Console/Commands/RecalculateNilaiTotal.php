<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateNilaiTotal extends Command
{
    protected $signature = 'recalculate:nilai-total
                            {--tahun= : Tahun audit (default: semua tahun)}
                            {--user= : ID user jurusan tertentu (default: semua)}';

    protected $description = 'Recalculate nilai_total pada users_matrik berdasarkan poin terbaru dari matriks_lembar_evaluasi_diri';

    public function handle()
    {
        $tahun = $this->option('tahun');
        $userId = $this->option('user');

        $query = DB::table('users_matrik as um')
            ->join('matriks_lembar_evaluasi_diri as m', 'm.id', '=', 'um.id_matriks_led')
            ->whereNull('um.id_user_jurusan')
            ->whereRaw('ROUND(um.nilai_total, 4) != ROUND(m.poin * um.jawaban, 4)');

        if ($tahun) {
            $query->where('um.tahun', $tahun);
        }
        if ($userId) {
            $query->where('um.id_users', $userId);
        }

        $affected = $query->update([
            'um.nilai_total' => DB::raw('ROUND(m.poin * um.jawaban, 4)'),
        ]);

        $this->info("Recalculate selesai. {$affected} baris diperbarui.");

        return Command::SUCCESS;
    }
}
