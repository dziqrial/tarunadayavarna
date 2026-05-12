<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\LaporanBulanan;
use App\Models\Rw;

class LaporanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $bulan = now()->month;
        $tahun = now()->year;

        $laporanRwSaya = LaporanBulanan::where('rw_id', $user->rw_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->with('rw')
            ->first();

        // Leaderboard semua RW bulan ini
        $leaderboard = LaporanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->with('rw')
            ->orderByDesc('skor_rw')
            ->get();

        // Riwayat 6 bulan terakhir RW user
        $riwayat = LaporanBulanan::where('rw_id', $user->rw_id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->limit(6)
            ->get();

        return view('app.laporan', compact('user', 'laporanRwSaya', 'leaderboard', 'riwayat', 'bulan', 'tahun'));
    }
}
