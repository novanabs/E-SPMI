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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('program_studi');
            $table->string('fakultas')->default('Keguruan dan Ilmu Pendidikan');
            $table->date('tanggal_audit')->nullable();
            $table->text('catatan_umum')->nullable();
            $table->foreignId('auditor_1_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('auditor_2_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
