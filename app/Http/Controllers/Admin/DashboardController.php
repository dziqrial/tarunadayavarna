<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\LaporanBulanan;
use App\Models\Rw;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = fn($model) => $user->isSuperAdmin()
            ? $model::query()
            : $model::where('rw_id', $user->rw_id);

        $totalWarga   = $query(User::class)->where('role', 'warga')->count();
        $totalPetugas = $query(User::class)->where('role', 'petugas')->count();
        $totalJadwal  = $user->isSuperAdmin()
            ? Jadwal::count()
            : Jadwal::where('rw_id', $user->rw_id)->count();

        $jadwalHariIni = ($user->isSuperAdmin()
            ? Jadwal::with(['rw', 'petugas'])
            : Jadwal::where('rw_id', $user->rw_id)->with(['rw', 'petugas']))
            ->whereDate('tanggal', today())
            ->orderBy('waktu_mulai')
            ->get();

        $laporanBulanIni = LaporanBulanan::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->when(!$user->isSuperAdmin(), fn($q) => $q->where('rw_id', $user->rw_id))
            ->with('rw')
            ->get();

        $totalKgBulanIni = $laporanBulanIni->sum('total_kg');

        $rws = $user->isSuperAdmin() ? Rw::all() : Rw::where('id', $user->rw_id)->get();

        return view('admin.dashboard', compact(
            'user',
            'totalWarga',
            'totalPetugas',
            'totalJadwal',
            'jadwalHariIni',
            'laporanBulanIni',
            'totalKgBulanIni',
            'rws'
        ));
    }
}
