<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 200)->unique();
            $table->longText('konten')->nullable();
            $table->enum('kategori', ['organik', 'anorganik', 'b3', 'daur_ulang']);
            $table->enum('format', ['artikel', 'video'])->default('artikel');
            $table->string('thumbnail_url', 255)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edukasi');
    }
};
