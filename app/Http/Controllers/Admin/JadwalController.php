<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\PengangkutanLog;
use App\Models\Rw;
use App\Models\User;
use App\Services\LaporanService;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $query = Jadwal::with(['rw', 'petugas', 'pengangkutanLog']);

        if ($user->isAdminRw()) {
            $query->where('rw_id', $user->rw_id);
        }

        $jadwals = $query->orderByDesc('tanggal')->paginate(20);

        return view('admin.jadwal.index', compact('jadwals', 'user'));
    }

    public function create()
    {
        $user    = auth()->user();
        $rws     = $user->isSuperAdmin() ? Rw::all() : Rw::where('id', $user->rw_id)->get();
        $petugas = $user->isSuperAdmin()
            ? User::where('role', 'petugas')->where('is_active', true)->get()
            : User::where('role', 'petugas')->where('rw_id', $user->rw_id)->where('is_active', true)->get();

        return view('admin.jadwal.create', compact('rws', 'petugas'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'rw_id'         => 'required|exists:rw,id',
            'petugas_id'    => 'nullable|exists:users,id',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'jenis_sampah'  => 'required|in:organik,anorganik,campuran,b3',
            'estimasi_kg'   => 'nullable|numeric|min:0',
        ]);

        $jadwal = Jadwal::create([
            'rw_id'         => $user->isAdminRw() ? $user->rw_id : $request->rw_id,
            'petugas_id'    => $request->petugas_id,
            'tanggal'       => $request->tanggal,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'jenis_sampah'  => $request->jenis_sampah,
            'estimasi_kg'   => $request->estimasi_kg,
            'created_by'    => $user->id,
        ]);

        // Notifikasi ke warga RW
        $jam = date('H:i', strtotime($request->waktu_mulai));
        app(NotifikasiService::class)->kirimKeRW(
            $jadwal->rw_id,
            'Jadwal Pengangkutan Baru',
            "Jadwal pengangkutan sampah {$jadwal->labelJenisSampah()} pada " .
            date('d/m/Y', strtotime($request->tanggal)) . " pukul {$jam} WIB.",
            'jadwal'
        );

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function show(Jadwal $jadwal)
    {
        $user = auth()->user();
        if ($user->isAdminRw() && $jadwal->rw_id !== $user->rw_id) abort(403);

        $jadwal->load(['rw', 'petugas', 'pengangkutanLog']);

        return view('admin.jadwal.show', compact('jadwal', 'user'));
    }

    public function inputLog(Request $request, Jadwal $jadwal)
    {
        $user = auth()->user();
        if ($user->isAdminRw() && $jadwal->rw_id !== $user->rw_id) abort(403);

        $request->validate([
            'berat_actual_kg' => 'required|numeric|min:0',
            'catatan'         => 'nullable|string|max:1000',
            'foto_bukti'      => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('bukti', 'public');
        }

        PengangkutanLog::updateOrCreate(
            ['jadwal_id' => $jadwal->id],
            [
                'berat_actual_kg' => $request->berat_actual_kg,
                'foto_bukti_url'  => $path ? Storage::url($path) : ($jadwal->pengangkutanLog?->foto_bukti_url),
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

        return redirect()
            ->route('admin.jadwal.show', $jadwal->id)
            ->with('success', 'Log pengangkutan berhasil disimpan dan jadwal ditandai selesai.');
    }

    public function edit(Jadwal $jadwal)
    {
        $user    = auth()->user();
        if ($user->isAdminRw() && $jadwal->rw_id !== $user->rw_id) abort(403);

        $rws     = $user->isSuperAdmin() ? Rw::all() : Rw::where('id', $user->rw_id)->get();
        $petugas = $user->isSuperAdmin()
            ? User::where('role', 'petugas')->where('is_active', true)->get()
            : User::where('role', 'petugas')->where('rw_id', $user->rw_id)->where('is_active', true)->get();

        return view('admin.jadwal.edit', compact('jadwal', 'rws', 'petugas'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $user = auth()->user();
        if ($user->isAdminRw() && $jadwal->rw_id !== $user->rw_id) abort(403);

        $request->validate([
            'rw_id'         => 'required|exists:rw,id',
            'petugas_id'    => 'nullable|exists:users,id',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'jenis_sampah'  => 'required|in:organik,anorganik,campuran,b3',
            'status'        => 'required|in:menunggu,proses,selesai,batal',
            'estimasi_kg'   => 'nullable|numeric|min:0',
        ]);

        $jadwal->update($request->only([
            'petugas_id', 'tanggal', 'waktu_mulai', 'waktu_selesai',
            'jenis_sampah', 'status', 'estimasi_kg',
        ]));

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $user = auth()->user();
        if ($user->isAdminRw() && $jadwal->rw_id !== $user->rw_id) abort(403);

        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
