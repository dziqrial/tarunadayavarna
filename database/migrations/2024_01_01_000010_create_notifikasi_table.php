<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->text('pesan');
            $table->enum('tipe', ['jadwal', 'info', 'broadcast'])->default('info');
            $table->enum('target_role', ['semua', 'warga', 'petugas', 'admin_rw'])->default('semua');
            $table->foreignId('target_rw_id')->nullable()->constrained('rw')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
