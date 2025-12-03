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
            // Untuk isian, karena tidak menggunakan 4 pilihan
            $table->longText('harkat_penskoran')->nullable();
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
