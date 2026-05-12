<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\NotifikasiUser;
use App\Models\User;

class NotifikasiService
{
    public function kirimKeRW(int $rwId, string $judul, string $pesan, string $tipe = 'info'): void
    {
        $notifikasi = Notifikasi::create([
            'judul'        => $judul,
            'pesan'        => $pesan,
            'tipe'         => $tipe,
            'target_role'  => 'semua',
            'target_rw_id' => $rwId,
            'created_by'   => auth()->id(),
            'created_at'   => now(),
        ]);

        $users = User::where('rw_id', $rwId)
            ->where('is_active', true)
            ->pluck('id');

        foreach ($users as $userId) {
            NotifikasiUser::create([
                'notifikasi_id' => $notifikasi->id,
                'user_id'       => $userId,
                'created_at'    => now(),
            ]);
        }
    }

    public function kirimKeUser(int $userId, string $judul, string $pesan, string $tipe = 'info'): void
    {
        $notifikasi = Notifikasi::create([
            'judul'       => $judul,
            'pesan'       => $pesan,
            'tipe'        => $tipe,
            'target_role' => 'semua',
            'created_by'  => auth()->id(),
            'created_at'  => now(),
        ]);

        NotifikasiUser::create([
            'notifikasi_id' => $notifikasi->id,
            'user_id'       => $userId,
            'created_at'    => now(),
        ]);
    }

    public function broadcast(string $judul, string $pesan, string $tipe = 'broadcast'): void
    {
        $notifikasi = Notifikasi::create([
            'judul'       => $judul,
            'pesan'       => $pesan,
            'tipe'        => $tipe,
            'target_role' => 'semua',
            'created_by'  => auth()->id(),
            'created_at'  => now(),
        ]);

        $users = User::where('is_active', true)->pluck('id');

        foreach ($users as $userId) {
            NotifikasiUser::create([
                'notifikasi_id' => $notifikasi->id,
                'user_id'       => $userId,
                'created_at'    => now(),
            ]);
        }
    }
}
