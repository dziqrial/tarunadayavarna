<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuisHasil extends Model
{
    protected $table = 'kuis_hasil';

    public $timestamps = false;

    protected $fillable = [
        'kuis_id',
        'user_id',
        'skor',
        'total_soal',
        'benar',
        'selesai_at',
    ];

    protected function casts(): array
    {
        return [
            'selesai_at' => 'datetime',
        ];
    }

    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
