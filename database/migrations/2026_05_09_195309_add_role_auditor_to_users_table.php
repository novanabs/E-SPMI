<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'admin_jurusan',
                'admin_FKIP',
                'pimpinan',
                'auditor'
            ) NOT NULL DEFAULT 'auditor'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'admin_jurusan',
                'admin_FKIP',
                'pimpinan'
            ) NOT NULL DEFAULT 'pimpinan'
        ");
    }
};
