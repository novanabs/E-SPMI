<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('matriks_lembar_evaluasi_diri', function (Blueprint $table) {
            $table->foreignId('id_kriteria')->constrained('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriks_lembar_evaluasi_diri', function (Blueprint $table) {
            //
        });
    }
};
