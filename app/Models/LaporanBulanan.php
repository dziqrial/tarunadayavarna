<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanBulanan extends Model
{
    protected $table = 'laporan_bulanan';

    protected $fillable = [
        'rw_id',
        'bulan',
        'tahun',
        'total_kg',
        'organik_kg',
        'anorganik_kg',
        'b3_kg',
        'daur_ulang_kg',
        'jumlah_pengangkutan',
        'tingkat_pilah_persen',
        'skor_rw',
    ];

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function namaBulan(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $bulan[$this->bulan] ?? '-';
    }
}
