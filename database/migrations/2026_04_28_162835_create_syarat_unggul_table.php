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
        Schema::create('syarat_unggul', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor');
            $table->foreignId('matriks_id')
                ->constrained('matriks_lembar_evaluasi_diri')
                ->cascadeOnDelete();
            $table->string('elemen');
            $table->text('indikator');
            $table->json('syarat_tahun'); // untuk 3 atau 5 tahun
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_unggul');
    }
};
