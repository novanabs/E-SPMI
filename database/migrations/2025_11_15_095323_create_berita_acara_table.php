<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Berita acara ini bisa digenerate* dengan memilih id jurusan, lalu auditor 1 dan 2

    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jurusan')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->foreignId('auditor_1')->constrained('users')->onDelete('cascade');
            $table->foreignId('auditor_2')->constrained('users')->onDelete('cascade');
            $table->text('catatan_umum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
