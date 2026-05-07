<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('matriks_lembar_evaluasi_diri', function (Blueprint $table) {
            $table->unique('nomor');
        });
    }

    public function down(): void
    {
        Schema::table('matriks_lembar_evaluasi_diri', function (Blueprint $table) {
            $table->dropUnique(['nomor']);
        });
    }
};