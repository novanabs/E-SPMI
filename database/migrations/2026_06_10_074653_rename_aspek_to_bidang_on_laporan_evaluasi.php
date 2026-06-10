<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum aspek jadi string agar bisa rename & terima nilai baru
        DB::statement("ALTER TABLE laporan_evaluasi MODIFY aspek VARCHAR(255) NULL");
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            $table->renameColumn('aspek', 'bidang');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            $table->renameColumn('bidang', 'aspek');
        });
        DB::statement("ALTER TABLE laporan_evaluasi MODIFY aspek ENUM('Pendidikan','Penelitian','Pengabdian') NULL");
    }
};
