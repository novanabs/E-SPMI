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
        Schema::create('laporan_evaluasi', function (Blueprint $table) {
            $table->id();
            $table->enum('aspek', ['Pendidikan', 'Penelitian', 'Pengabdian']);
            $table->enum('jenis_laporan', ['AMI', 'Monev_jurusan', 'Survey']);
            $table->year('tahun');
            $table->string('link_bukti_laporan');
            $table->string('link_bukti_laporan_genap')->nullable();
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_evaluasi');
    }
};
