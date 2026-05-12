<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kuis extends Model
{
    protected $table = 'kuis';

    protected $fillable = [
        'edukasi_id',
        'judul',
        'durasi_menit',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function edukasi(): BelongsTo
    {
        return $this->belongsTo(Edukasi::class);
    }

    public function soal(): HasMany
    {
        return $this->hasMany(KuisSoal::class)->orderBy('urutan');
    }

    public function hasil(): HasMany
    {
        return $this->hasMany(KuisHasil::class);
    }
}
