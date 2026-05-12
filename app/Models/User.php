<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'rw_id',
        'no_wa',
        'foto_profil',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'  => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function jadwalSebagaiPetugas(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'petugas_id');
    }

    public function kuisHasil(): HasMany
    {
        return $this->hasMany(KuisHasil::class);
    }

    public function notifikasiUser(): HasMany
    {
        return $this->hasMany(NotifikasiUser::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdminRw(): bool
    {
        return $this->role === 'admin_rw';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
}
