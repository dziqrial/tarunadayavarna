@extends('admin.layouts.app')

@section('title', 'Laporan')
@section('heading', 'Laporan Bulanan')

@section('topbar-actions')
  <a href="{{ route('admin.laporan.export', ['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="btn-secondary">
    ⬇ Export CSV
  </a>
@endsection

@section('content')

{{-- Filter --}}
<form method="GET" action="{{ route('admin.laporan.index') }}" class="admin-card" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;margin-bottom:16px">
  <div class="form-group" style="margin:0">
    <label>Bulan</label>
    <select name="bulan" class="form-control">
      @for($m = 1; $m <= 12; $m++)
        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
          {{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
        </option>
      @endfor
    </select>
  </div>
  <div class="form-group" style="margin:0">
    <label>Tahun</label>
    <select name="tahun" class="form-control">
      @for($y = now()->year; $y >= now()->year - 3; $y--)
        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
      @endfor
    </select>
  </div>
  <button type="submit" class="btn-primary">Tampilkan</button>
</form>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Peringkat</th>
        <th>RW</th>
        <th>Total KG</th>
        <th>Organik</th>
        <th>Anorganik</th>
        <th>B3</th>
        <th>Pengangkutan</th>
        <th>Tingkat Pilah</th>
        <th>Skor</th>
      </tr>
    </thead>
    <tbody>
      @forelse($laporan as $i => $l)
        <tr>
          <td>
            <span class="rank-badge rank-{{ $i+1 <= 3 ? $i+1 : 'other' }}">{{ $i+1 }}</span>
          </td>
          <td style="font-weight:600">{{ $l->rw?->nama }}</td>
          <td>{{ number_format($l->total_kg, 1) }}</td>
          <td>{{ number_format($l->organik_kg, 1) }}</td>
          <td>{{ number_format($l->anorganik_kg, 1) }}</td>
          <td>{{ number_format($l->b3_kg, 1) }}</td>
          <td>{{ $l->jumlah_pengangkutan }}x</td>
          <td>{{ $l->tingkat_pilah_persen }}%</td>
          <td>
            <strong style="color:var(--navy);font-size:16px">{{ $l->skor_rw }}</strong>
          </td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align:center;color:var(--muted)">Belum ada data laporan untuk periode ini.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
