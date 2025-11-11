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
        Schema::table('users_matrik', function (Blueprint $table) {
            $table->foreignId('id_matriks_led')->constrained('matriks_lembar_evaluasi_diri')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            //
        });
    }
};
