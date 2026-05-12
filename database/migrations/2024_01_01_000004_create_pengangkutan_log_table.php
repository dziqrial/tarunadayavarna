<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengangkutan_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal')->cascadeOnDelete();
            $table->decimal('berat_actual_kg', 8, 2)->nullable();
            $table->string('foto_bukti_url', 255)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengangkutan_log');
    }
};
