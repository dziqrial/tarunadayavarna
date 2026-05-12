@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('topbar-actions')
  <span style="font-size:13px;color:var(--muted)">{{ now()->translatedFormat('l, d F Y') }}</span>
@endsection

@section('content')

<div class="stats-grid">
  <div class="stat-widget">
    <div class="stat-widget-icon" style="background:#e8f0fe">👥</div>
    <div>
      <div class="stat-widget-value">{{ $totalWarga }}</div>
      <div class="stat-widget-label">Total Warga</div>
    </div>
  </div>
  <div class="stat-widget">
    <div class="stat-widget-icon" style="background:#fff3e0">🚛</div>
    <div>
      <div class="stat-widget-value">{{ $totalPetugas }}</div>
      <div class="stat-widget-label">Petugas Aktif</div>
    </div>
  </div>
  <div class="stat-widget">
    <div class="stat-widget-icon" style="background:#e8f5e9">📅</div>
    <div>
      <div class="stat-widget-value">{{ $totalJadwal }}</div>
      <div class="stat-widget-label">Total Jadwal</div>
    </div>
  </div>
  <div class="stat-widget">
    <div class="stat-widget-icon" style="background:#fce4ec">📦</div>
    <div>
      <div class="stat-widget-value">{{ number_format($totalKgBulanIni, 1) }}</div>
      <div class="stat-widget-label">KG Bulan Ini</div>
    </div>
  </div>
</div>

<div class="admin-grid-2">

  {{-- Jadwal Hari Ini --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>Jadwal Hari Ini</h3>
      <a href="{{ route('admin.jadwal.create') }}" class="btn-primary-sm">+ Tambah</a>
    </div>
    @forelse($jadwalHariIni as $j)
      <div class="table-row">
        <span class="badge badge-{{ $j->status }}">{{ $j->labelStatus() }}</span>
        <div>
          <div style="font-weight:600;font-size:13px">{{ $j->rw?->nama }} · {{ $j->labelJenisSampah() }}</div>
          <div style="font-size:12px;color:var(--muted)">{{ substr($j->waktu_mulai,0,5) }}–{{ substr($j->waktu_selesai,0,5) }} · {{ $j->petugas?->nama ?? '-' }}</div>
        </div>
      </div>
    @empty
      <p style="color:var(--muted);font-size:13px;padding:12px 0">Tidak ada jadwal hari ini.</p>
    @endforelse
  </div>

  {{-- Laporan Bulan Ini --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>Laporan Bulan Ini</h3>
      <a href="{{ route('admin.laporan.index') }}" class="btn-secondary-sm">Lihat Semua</a>
    </div>
    @forelse($laporanBulanIni as $l)
      <div class="table-row">
        <div style="font-weight:600;min-width:60px">{{ $l->rw?->nama }}</div>
        <div style="flex:1">
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width:{{ min($l->skor_rw, 100) }}%"></div>
          </div>
        </div>
        <div style="font-weight:700;color:var(--navy);min-width:36px;text-align:right">{{ $l->skor_rw }}</div>
      </div>
    @empty
      <p style="color:var(--muted);font-size:13px;padding:12px 0">Belum ada laporan bulan ini.</p>
    @endforelse
  </div>

</div>

@endsection
