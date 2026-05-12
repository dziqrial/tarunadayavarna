<?php

namespace App\Services;

use App\Models\Jadwal;
use App\Models\LaporanBulanan;
use App\Models\PengangkutanLog;

class LaporanService
{
    public function updateBulanan(int $rwId, int $bulan, int $tahun): void
    {
        $jadwals = Jadwal::where('rw_id', $rwId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'selesai')
            ->with('pengangkutanLog')
            ->get();

        $totalKg      = 0;
        $organikKg    = 0;
        $anorganikKg  = 0;
        $b3Kg         = 0;
        $campuranKg   = 0;
        $jumlahAngkut = 0;

        foreach ($jadwals as $jadwal) {
            $log = $jadwal->pengangkutanLog;
            if (!$log) continue;

            $berat = (float) $log->berat_actual_kg;
            $totalKg += $berat;
            $jumlahAngkut++;

            match ($jadwal->jenis_sampah) {
                'organik'   => $organikKg   += $berat,
                'anorganik' => $anorganikKg += $berat,
                'b3'        => $b3Kg        += $berat,
                default     => $campuranKg  += $berat,
            };
        }

        $tingkatPilah = $totalKg > 0
            ? round((($organikKg + $anorganikKg + $b3Kg) / $totalKg) * 100, 2)
            : 0;

        $skor = $this->hitungSkor($totalKg, $tingkatPilah, $jumlahAngkut);

        LaporanBulanan::updateOrCreate(
            ['rw_id' => $rwId, 'bulan' => $bulan, 'tahun' => $tahun],
            [
                'total_kg'              => $totalKg,
                'organik_kg'            => $organikKg,
                'anorganik_kg'          => $anorganikKg,
                'b3_kg'                 => $b3Kg,
                'daur_ulang_kg'         => $campuranKg,
                'jumlah_pengangkutan'   => $jumlahAngkut,
                'tingkat_pilah_persen'  => $tingkatPilah,
                'skor_rw'               => $skor,
            ]
        );
    }

    public function hitungSkor(float $totalKg, float $tingkatPilah, int $jumlahAngkut): int
    {
        $targetBerat = 500;

        $skorBerat       = min(($totalKg / $targetBerat) * 40, 40);
        $skorPilah       = ($tingkatPilah / 100) * 40;
        $konsistensi     = min($jumlahAngkut / 4, 1);
        $skorKonsistensi = $konsistensi * 20;

        return (int) round($skorBerat + $skorPilah + $skorKonsistensi);
    }
}
