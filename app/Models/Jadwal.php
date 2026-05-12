<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'rw_id',
        'petugas_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'jenis_sampah',
        'status',
        'estimasi_kg',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pengangkutanLog(): HasOne
    {
        return $this->hasOne(PengangkutanLog::class);
    }

    public function labelJenisSampah(): string
    {
        return match ($this->jenis_sampah) {
            'organik'    => 'Organik',
            'anorganik'  => 'Anorganik',
            'campuran'   => 'Campuran',
            'b3'         => 'B3',
            default      => ucfirst($this->jenis_sampah),
        };
    }

    public function labelStatus(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'proses'   => 'Proses',
            'selesai'  => 'Selesai',
            'batal'    => 'Batal',
            default    => ucfirst($this->status),
        };
    }
}
