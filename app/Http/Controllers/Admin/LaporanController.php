<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanBulanan;
use App\Models\Rw;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $query = LaporanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->with('rw');

        if ($user->isAdminRw()) {
            $query->where('rw_id', $user->rw_id);
        }

        $laporan = $query->orderByDesc('skor_rw')->get();
        $rws     = $user->isSuperAdmin() ? Rw::all() : Rw::where('id', $user->rw_id)->get();

        return view('admin.laporan.index', compact('laporan', 'rws', 'bulan', 'tahun', 'user'));
    }

    public function export(Request $request)
    {
        // Placeholder — implementasi CSV/Excel export
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $user  = auth()->user();
        $query = LaporanBulanan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->with('rw');

        if ($user->isAdminRw()) {
            $query->where('rw_id', $user->rw_id);
        }

        $laporan = $query->orderByDesc('skor_rw')->get();

        $header  = ['RW', 'Total KG', 'Organik KG', 'Anorganik KG', 'B3 KG', 'Jumlah Angkut', 'Tingkat Pilah (%)', 'Skor RW'];
        $rows    = $laporan->map(fn($l) => [
            $l->rw?->nama,
            $l->total_kg,
            $l->organik_kg,
            $l->anorganik_kg,
            $l->b3_kg,
            $l->jumlah_pengangkutan,
            $l->tingkat_pilah_persen,
            $l->skor_rw,
        ])->toArray();

        $filename = "laporan_{$bulan}_{$tahun}.csv";

        $callback = function () use ($header, $rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $header);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
