<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rw extends Model
{
    protected $table = 'rw';

    protected $fillable = [
        'nama',
        'ketua_nama',
        'alamat',
        'jumlah_kk',
        'deskripsi',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function laporanBulanan(): HasMany
    {
        return $this->hasMany(LaporanBulanan::class);
    }
}
