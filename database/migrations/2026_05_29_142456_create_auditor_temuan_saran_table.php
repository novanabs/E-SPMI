<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditor_temuan_saran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_users')->constrained('users');
            $table->foreignId('id_user_jurusan')->constrained('users');
            $table->foreignId('id_matriks_led')->constrained('matriks_lembar_evaluasi_diri');
            $table->text('temuan')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();

            $table->unique(['id_users', 'id_user_jurusan', 'id_matriks_led'], 'ats_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditor_temuan_saran');
    }
};
