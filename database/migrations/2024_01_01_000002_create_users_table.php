<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['super_admin', 'admin_rw', 'petugas', 'warga'])->default('warga');
            $table->foreignId('rw_id')->nullable()->constrained('rw')->nullOnDelete();
            $table->string('no_wa', 20)->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
