<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->string('pilihan_a', 255)->nullable();
            $table->string('pilihan_b', 255)->nullable();
            $table->string('pilihan_c', 255)->nullable();
            $table->string('pilihan_d', 255)->nullable();
            $table->enum('jawaban_benar', ['a', 'b', 'c', 'd']);
            $table->integer('urutan')->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis_soal');
    }
};
