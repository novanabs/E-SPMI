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
        Schema::create('penilaian_syarat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syarat_unggul_id')->constrained()->cascadeOnDelete();
            $table->integer('tahun'); // 3 atau 5
            $table->text('nilai_user')->nullable(); // input dari user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_syarat');
    }
};
