<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengangkutanLog extends Model
{
    protected $table = 'pengangkutan_log';

    public $timestamps = false;

    protected $fillable = [
        'jadwal_id',
        'berat_actual_kg',
        'foto_bukti_url',
        'catatan',
        'selesai_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'selesai_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }
}
