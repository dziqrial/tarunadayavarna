<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    public $timestamps = false;

    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'target_role',
        'target_rw_id',
        'created_by',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function targetRw(): BelongsTo
    {
        return $this->belongsTo(Rw::class, 'target_rw_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notifikasiUsers(): HasMany
    {
        return $this->hasMany(NotifikasiUser::class);
    }
}
