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
        Schema::create('users_matrik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_assesment', ['mandiri', 'UPM']);
            $table->enum('jawaban', [4, 3, 2, 1])->nullable();
            $table->integer('nilai_total')->nullable();
            $table->text('isian')->nullable();
            $table->string('link_bukti')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_matrik');
    }
};
