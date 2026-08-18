<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('audit_kriteria', function (Blueprint $table) {
            // Hapus foreign key kriteria_id
            $table->dropForeign(['kriteria_id']);

            // Hapus unique index kriteria_id
            $table->dropUnique('audit_kriteria_kriteria_id_unique');

            // Buat kembali foreign key
            $table->foreign('kriteria_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('cascade');

            // Unique berdasarkan jurusan + kriteria
            $table->unique(
                ['jurusan_id', 'kriteria_id'],
                'audit_kriteria_jurusan_kriteria_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('audit_kriteria', function (Blueprint $table) {
            $table->dropUnique('audit_kriteria_jurusan_kriteria_unique');

            $table->dropForeign(['kriteria_id']);

            $table->foreign('kriteria_id')
                ->references('id')
                ->on('kriteria')
                ->onDelete('cascade');

            $table->unique(
                'kriteria_id',
                'audit_kriteria_kriteria_id_unique'
            );
        });
    }
};
