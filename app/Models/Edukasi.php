<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Edukasi extends Model
{
    protected $table = 'edukasi';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'format',
        'thumbnail_url',
        'video_url',
        'durasi_menit',
        'is_published',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kuis(): HasOne
    {
        return $this->hasOne(Kuis::class);
    }
}
