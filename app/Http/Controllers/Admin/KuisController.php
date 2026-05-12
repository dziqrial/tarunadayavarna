<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Kuis;
use App\Models\KuisSoal;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function index()
    {
        $kuis = Kuis::with(['edukasi', 'soal'])->latest()->paginate(20);
        return view('admin.kuis.index', compact('kuis'));
    }

    public function create()
    {
        $edukasi = Edukasi::where('is_published', true)->get();
        return view('admin.kuis.create', compact('edukasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:200',
            'edukasi_id'   => 'nullable|exists:edukasi,id',
            'durasi_menit' => 'required|integer|min:1',
            'soal'         => 'required|array|min:1',
            'soal.*.pertanyaan'    => 'required|string',
            'soal.*.pilihan_a'     => 'required|string',
            'soal.*.pilihan_b'     => 'required|string',
            'soal.*.pilihan_c'     => 'nullable|string',
            'soal.*.pilihan_d'     => 'nullable|string',
            'soal.*.jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        $kuis = Kuis::create([
            'edukasi_id'   => $request->edukasi_id,
            'judul'        => $request->judul,
            'durasi_menit' => $request->durasi_menit,
        ]);

        foreach ($request->soal as $i => $soal) {
            KuisSoal::create([
                'kuis_id'      => $kuis->id,
                'pertanyaan'   => $soal['pertanyaan'],
                'pilihan_a'    => $soal['pilihan_a'],
                'pilihan_b'    => $soal['pilihan_b'],
                'pilihan_c'    => $soal['pilihan_c'] ?? null,
                'pilihan_d'    => $soal['pilihan_d'] ?? null,
                'jawaban_benar' => $soal['jawaban_benar'],
                'urutan'       => $i + 1,
                'created_at'   => now(),
            ]);
        }

        return redirect()->route('admin.kuis.index')->with('success', 'Kuis berhasil dibuat.');
    }

    public function show(Kuis $kuis)
    {
        $kuis->load('soal', 'edukasi');
        return view('admin.kuis.show', compact('kuis'));
    }

    public function edit(Kuis $kuis)
    {
        $kuis->load('soal');
        $edukasi = Edukasi::where('is_published', true)->get();
        return view('admin.kuis.edit', compact('kuis', 'edukasi'));
    }

    public function update(Request $request, Kuis $kuis)
    {
        $request->validate([
            'judul'        => 'required|string|max:200',
            'edukasi_id'   => 'nullable|exists:edukasi,id',
            'durasi_menit' => 'required|integer|min:1',
            'is_active'    => 'boolean',
        ]);

        $kuis->update([
            'edukasi_id'   => $request->edukasi_id,
            'judul'        => $request->judul,
            'durasi_menit' => $request->durasi_menit,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.kuis.index')->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Kuis $kuis)
    {
        $kuis->delete();
        return redirect()->route('admin.kuis.index')->with('success', 'Kuis berhasil dihapus.');
    }
}
