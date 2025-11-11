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
            $table->string('nama_mitra');
            $table->string('link_bukti_kerjasama');
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
