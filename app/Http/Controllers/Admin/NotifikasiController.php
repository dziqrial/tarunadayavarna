<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Rw;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user        = auth()->user();
        $notifikasis = Notifikasi::with(['createdBy', 'targetRw'])
            ->when($user->isAdminRw(), fn($q) => $q->where('target_rw_id', $user->rw_id))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    public function create()
    {
        $user = auth()->user();
        $rws  = $user->isSuperAdmin() ? Rw::all() : Rw::where('id', $user->rw_id)->get();

        return view('admin.notifikasi.create', compact('rws', 'user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'judul'       => 'required|string|max:200',
            'pesan'       => 'required|string',
            'tipe'        => 'required|in:jadwal,info,broadcast',
            'target_role' => 'required|in:semua,warga,petugas,admin_rw',
            'target_rw_id' => 'nullable|exists:rw,id',
        ]);

        $service = app(NotifikasiService::class);

        if ($request->tipe === 'broadcast' && $user->isSuperAdmin()) {
            $service->broadcast($request->judul, $request->pesan, 'broadcast');
        } elseif ($request->filled('target_rw_id')) {
            $service->kirimKeRW(
                $request->target_rw_id,
                $request->judul,
                $request->pesan,
                $request->tipe
            );
        } else {
            $rwId = $user->rw_id;
            if ($rwId) {
                $service->kirimKeRW($rwId, $request->judul, $request->pesan, $request->tipe);
            }
        }

        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil dikirim.');
    }
}
