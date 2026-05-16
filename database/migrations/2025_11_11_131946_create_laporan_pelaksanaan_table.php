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
        Schema::create('laporan_pelaksanaan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link_bukti_laporan');
            $table->string('link_bukti_laporan_genap')->nullable();
            $table->string('nama_mitra')->nullable();
            $table->string('link_bukti_kerjasama')->nullable();
            $table->year('tahun')->nullable();
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pelaksanaan');
    }
};
