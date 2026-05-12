<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\LaporanBulanan;
use App\Models\NotifikasiUser;

class BerandaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $jadwalHariIni = Jadwal::where('rw_id', $user->rw_id)
            ->whereDate('tanggal', today())
            ->with(['petugas', 'rw'])
            ->orderBy('waktu_mulai')
            ->get();

        $laporanBulanIni = LaporanBulanan::where('rw_id', $user->rw_id)
            ->where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->first();

        $totalKgBulanIni      = $laporanBulanIni?->total_kg ?? 0;
        $jumlahAngkutBulanIni = $laporanBulanIni?->jumlah_pengangkutan ?? 0;
        $skorRw               = $laporanBulanIni?->skor_rw ?? 0;

        $unreadNotifCount = NotifikasiUser::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('app.beranda', compact(
            'user',
            'jadwalHariIni',
            'totalKgBulanIni',
            'jumlahAngkutBulanIni',
            'skorRw',
            'unreadNotifCount'
        ));
    }
}
