<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('skor');
            $table->integer('total_soal');
            $table->integer('benar');
            $table->timestamp('selesai_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis_hasil');
    }
};
