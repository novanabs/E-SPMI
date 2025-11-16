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
        Schema::create('berita_acara_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kriteria')->constrained('kriteria')->onDelete('cascade');
            $table->foreignId('id_berita_acara')->constrained('berita_acara')->onDelete('cascade');
            $table->string('hasil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara_kriteria');
    }
};
