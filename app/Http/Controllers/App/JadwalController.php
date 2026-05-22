<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\PengangkutanLog;
use App\Services\LaporanService;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Jadwal::with(['petugas', 'rw'])
            ->where('rw_id', $user->rw_id);

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereDate('tanggal', '>=', now()->subDays(7));
        }

        // Filter jenis sampah
        if ($request->filled('jenis')) {
            $query->where('jenis_sampah', $request->jenis);
        }

        // Petugas hanya lihat jadwal yang di-assign ke dia
        if ($user->isPetugas()) {
            $query->where('petugas_id', $user->id);
        }

        $jadwals = $query->orderBy('tanggal', 'desc')->orderBy('waktu_mulai')->get();

        return view('app.jadwal', compact('jadwals', 'user'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $user   = auth()->user();

        // Petugas hanya bisa update jadwal yang di-assign ke dia
        if ($user->isPetugas() && $jadwal->petugas_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,batal',
        ]);

        $jadwal->update(['status' => $request->status]);

        if ($request->status === 'selesai') {
            app(LaporanService::class)->updateBulanan(
                $jadwal->rw_id,
                $jadwal->tanggal->month,
                $jadwal->tanggal->year
            );
        }

        return back()->with('success', 'Status jadwal berhasil diperbarui.');
    }

    public function inputLog(Request $request, int $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'berat_actual_kg' => 'required|numeric|min:0',
            'foto_bukti'      => 'nullable|image|max:5120',
            'catatan'         => 'nullable|string|max:500',
        ]);

        $path = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('bukti', 'public');
        }

        PengangkutanLog::updateOrCreate(
            ['jadwal_id' => $jadwal->id],
            [
                'berat_actual_kg' => $request->berat_actual_kg,
                'foto_bukti_url'  => $path ? Storage::url($path) : null,
                'catatan'         => $request->catatan,
                'selesai_at'      => now(),
                'created_at'      => now(),
            ]
        );

        $jadwal->update(['status' => 'selesai']);

        app(LaporanService::class)->updateBulanan(
            $jadwal->rw_id,
            $jadwal->tanggal->month,
            $jadwal->tanggal->year
        );

        return back()->with('success', 'Log pengangkutan berhasil disimpan.');
    }
}
