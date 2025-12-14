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
            // Tambah kolom setelah id_users (opsional)
            $table->unsignedBigInteger('id_user_jurusan')->nullable()->after('id_users');

            // Buat foreign key ke tabel users
            $table->foreign('id_user_jurusan')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            // Hapus foreign key & kolom
            $table->dropForeign(['id_user_jurusan']);
            $table->dropColumn(['id_user_jurusan']);
        });
    }
};
