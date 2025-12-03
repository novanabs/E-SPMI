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
        Schema::create('matriks_lembar_evaluasi_diri', function (Blueprint $table) {
            $table->id();
            $table->unique('nomor');
            $table->string('id_kriteria');
            $table->string('elemen');
            $table->string('poin');
            $table->text('indikator')->nullable();
            $table->json('option_pilihan_ganda')->nullable();
            $table->enum('jenis', ['pilihan_ganda', 'isian']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_lembar_evaluasi_diri');
    }
};
