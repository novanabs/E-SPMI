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
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'password_changed')) {
                $table->boolean('password_changed')
                    ->default(false)
                    ->after('password');
            }

            if (!Schema::hasColumn('users', 'generated_password')) {
                $table->string('generated_password')
                    ->nullable()
                    ->after('password_changed');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'generated_password')) {
                $table->dropColumn('generated_password');
            }

            if (Schema::hasColumn('users', 'password_changed')) {
                $table->dropColumn('password_changed');
            }
        });
    }
};
