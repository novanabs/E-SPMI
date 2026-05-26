<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            $table->tinyInteger('skor_a')->nullable()->after('jawaban');
            $table->tinyInteger('skor_b')->nullable()->after('skor_a');
        });

        DB::statement("ALTER TABLE users_matrik MODIFY COLUMN jawaban DECIMAL(5,2) NOT NULL DEFAULT 0");
    }

    public function down(): void
    {
        Schema::table('users_matrik', function (Blueprint $table) {
            $table->dropColumn(['skor_a', 'skor_b']);
        });

        DB::statement("ALTER TABLE users_matrik MODIFY COLUMN jawaban ENUM('4','3','2','1') NOT NULL DEFAULT '4'");
    }
};
