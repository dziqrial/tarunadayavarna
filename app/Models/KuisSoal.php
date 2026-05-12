<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuisSoal extends Model
{
    protected $table = 'kuis_soal';

    public $timestamps = false;

    protected $fillable = [
        'kuis_id',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
        'urutan',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class);
    }
}
