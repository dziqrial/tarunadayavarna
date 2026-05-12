<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\KuisHasil;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function show(int $id)
    {
        $kuis = Kuis::where('id', $id)
            ->where('is_active', true)
            ->with('soal')
            ->firstOrFail();

        $sudahIkut = KuisHasil::where('kuis_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        return view('app.kuis.show', compact('kuis', 'sudahIkut'));
    }

    public function submit(Request $request, int $id)
    {
        $kuis = Kuis::where('id', $id)
            ->where('is_active', true)
            ->with('soal')
            ->firstOrFail();

        $sudahIkut = KuisHasil::where('kuis_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($sudahIkut) {
            return back()->with('error', 'Anda sudah pernah mengikuti kuis ini.');
        }

        $jawaban   = $request->input('jawaban', []);
        $benar     = 0;
        $totalSoal = $kuis->soal->count();

        foreach ($kuis->soal as $soal) {
            if (isset($jawaban[$soal->id]) && $jawaban[$soal->id] === $soal->jawaban_benar) {
                $benar++;
            }
        }

        $skor = $totalSoal > 0 ? (int) round(($benar / $totalSoal) * 100) : 0;

        KuisHasil::create([
            'kuis_id'    => $id,
            'user_id'    => auth()->id(),
            'skor'       => $skor,
            'total_soal' => $totalSoal,
            'benar'      => $benar,
            'selesai_at' => now(),
        ]);

        return redirect()->route('app.edukasi')
            ->with('success', "Kuis selesai! Skor Anda: {$skor}/100 ({$benar}/{$totalSoal} benar).");
    }
}
