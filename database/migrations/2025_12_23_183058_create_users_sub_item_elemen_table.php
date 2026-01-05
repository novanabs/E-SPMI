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
        Schema::create('users_sub_item_elemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sub_item_elemen')
                ->constrained('sub_item_elemen')
                ->cascadeOnDelete();
            $table->foreignId('id_matriks')
                ->constrained('matriks_lembar_evaluasi_diri')
                ->cascadeOnDelete();
            $table->float('nilai');

            $table->foreignId('id_users')->constrained('users')->onDelete('cascade'); // ini id user yang login

            // Kalau yang menilai fakultas, maka ini beisi
            $table->foreignId('id_user_jurusan')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_sub_item_elemen');
    }
};
