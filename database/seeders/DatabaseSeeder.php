<?php

namespace Database\Seeders;

use App\Models\Rw;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. RW
        $rwData = [
            ['nama' => 'RW 01', 'ketua_nama' => 'Pak Hendra',   'alamat' => 'Jl. Mawar No. 1-35',   'jumlah_kk' => 85],
            ['nama' => 'RW 02', 'ketua_nama' => 'Pak Darto',    'alamat' => 'Jl. Melati No. 5-50',   'jumlah_kk' => 92],
            ['nama' => 'RW 03', 'ketua_nama' => 'Pak Suparman', 'alamat' => 'Jl. Dahlia No. 1-40',   'jumlah_kk' => 78],
            ['nama' => 'RW 04', 'ketua_nama' => 'Pak Wahyu',    'alamat' => 'Jl. Kenanga No. 2-44',  'jumlah_kk' => 104],
            ['nama' => 'RW 05', 'ketua_nama' => 'Pak Bambang',  'alamat' => 'Jl. Anggrek No. 1-28',  'jumlah_kk' => 67],
        ];

        foreach ($rwData as $rw) {
            Rw::create($rw);
        }

        // 2. Super Admin
        User::create([
            'nama'      => 'Admin Tarunadayavarna',
            'username'  => 'superadmin',
            'password'  => Hash::make('password'),
            'role'      => 'super_admin',
            'rw_id'     => null,
            'is_active' => true,
        ]);

        // 3. Admin per RW
        foreach (Rw::all() as $rw) {
            $slug = strtolower(str_replace([' ', '.'], '', $rw->nama));
            User::create([
                'nama'      => 'Admin ' . $rw->nama,
                'username'  => 'admin_' . $slug,
                'password'  => Hash::make('password'),
                'role'      => 'admin_rw',
                'rw_id'     => $rw->id,
                'is_active' => true,
            ]);
        }

        // 4. Petugas sample
        $petugas = [
            ['nama' => 'Budi Santoso',   'username' => 'petugas_01', 'rw_id' => 1],
            ['nama' => 'Heru Prabowo',   'username' => 'petugas_02', 'rw_id' => 2],
            ['nama' => 'Andi Wijaya',    'username' => 'petugas_03', 'rw_id' => 3],
        ];

        foreach ($petugas as $p) {
            User::create([
                'nama'      => $p['nama'],
                'username'  => $p['username'],
                'password'  => Hash::make('password'),
                'role'      => 'petugas',
                'rw_id'     => $p['rw_id'],
                'is_active' => true,
            ]);
        }

        // 5. Warga sample
        $warga = [
            ['nama' => 'Pak Suparman',  'username' => 'suparman.rw03', 'rw_id' => 3],
            ['nama' => 'Ibu Sari',      'username' => 'sari.rw01',     'rw_id' => 1],
            ['nama' => 'Pak Joko',      'username' => 'joko.rw02',     'rw_id' => 2],
        ];

        foreach ($warga as $w) {
            User::create([
                'nama'      => $w['nama'],
                'username'  => $w['username'],
                'password'  => Hash::make('password'),
                'role'      => 'warga',
                'rw_id'     => $w['rw_id'],
                'is_active' => true,
            ]);
        }
    }
}
