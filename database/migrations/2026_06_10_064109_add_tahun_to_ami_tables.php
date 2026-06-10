<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            $table->year('tahun')->nullable()->after('id_user_jurusan');
        });

        Schema::table('users_sub_item_elemen', function (Blueprint $table) {
            $table->year('tahun')->nullable()->after('id_user_jurusan');
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->year('tahun')->nullable()->after('program_studi');
        });
    }

    public function down(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });

        Schema::table('users_sub_item_elemen', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
    }
};
