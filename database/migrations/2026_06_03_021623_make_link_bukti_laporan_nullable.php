<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan_pelaksanaan', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable()->change();
        });
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable()->change();
        });
        Schema::table('laporan_pengendalian', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable()->change();
        });
        Schema::table('laporan_peningkatan', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pelaksanaan', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable(false)->change();
        });
        Schema::table('laporan_evaluasi', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable(false)->change();
        });
        Schema::table('laporan_pengendalian', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable(false)->change();
        });
        Schema::table('laporan_peningkatan', function (Blueprint $table) {
            $table->string('link_bukti_laporan', 255)->nullable(false)->change();
        });
    }
};
