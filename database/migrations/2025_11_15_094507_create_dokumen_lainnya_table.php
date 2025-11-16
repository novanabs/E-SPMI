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
        Schema::create('dokumen_lainnya', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('deskripsi')->nullable();
            $table->string('link_dokumen');
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_lainnya');
    }
};
