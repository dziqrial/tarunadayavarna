<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rw_id')->constrained('rw')->cascadeOnDelete();
            $table->tinyInteger('bulan')->comment('1-12');
            $table->smallInteger('tahun');
            $table->decimal('total_kg', 10, 2)->default(0);
            $table->decimal('organik_kg', 10, 2)->default(0);
            $table->decimal('anorganik_kg', 10, 2)->default(0);
            $table->decimal('b3_kg', 10, 2)->default(0);
            $table->decimal('daur_ulang_kg', 10, 2)->default(0);
            $table->integer('jumlah_pengangkutan')->default(0);
            $table->decimal('tingkat_pilah_persen', 5, 2)->default(0);
            $table->integer('skor_rw')->default(0);
            $table->timestamps();

            $table->unique(['rw_id', 'bulan', 'tahun'], 'unique_rw_bulan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanan');
    }
};
