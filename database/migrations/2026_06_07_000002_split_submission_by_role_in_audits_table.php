<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            // Drop old single-submission columns
            $table->dropForeign(['submitted_by']);
            $table->dropColumn(['status', 'submitted_at', 'submitted_by']);

            // Add per-role submission columns
            $table->timestamp('jurusan_submitted_at')->nullable();
            $table->foreignId('jurusan_submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('auditor_submitted_at')->nullable();
            $table->foreignId('auditor_submitted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropForeign(['jurusan_submitted_by']);
            $table->dropForeign(['auditor_submitted_by']);
            $table->dropColumn(['jurusan_submitted_at', 'jurusan_submitted_by', 'auditor_submitted_at', 'auditor_submitted_by']);

            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }
};
