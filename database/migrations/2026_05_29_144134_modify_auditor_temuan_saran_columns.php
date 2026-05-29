<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auditor_temuan_saran', function (Blueprint $table) {
            $table->longText('temuan')->nullable()->change();
            $table->longText('saran')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('auditor_temuan_saran', function (Blueprint $table) {
            $table->text('temuan')->nullable()->change();
            $table->text('saran')->nullable()->change();
        });
    }
};
