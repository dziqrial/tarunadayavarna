@extends('app.layouts.mobile')

@section('title', 'Laporan')

@section('content')
<div class="page-header-navy">
  <a href="{{ route('app.beranda') }}" class="back-btn">←</a>
  <h2 class="page-header-title">Laporan Bulanan</h2>
  <p class="page-header-sub">
    {{ \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y') }}
  </p>
</div>

<div class="page-content">

  {{-- Score Card RW Saya --}}
  @if($laporanRwSaya)
    <div class="score-card">
      <div class="score-rw">{{ $laporanRwSaya->rw?->nama }}</div>
      <div class="score-value">{{ $laporanRwSaya->skor_rw }}<span class="score-max">/100</span></div>
      <div class="score-bar-bg">
        <div class="score-bar-fill" style="width:{{ min($laporanRwSaya->skor_rw, 100) }}%"></div>
      </div>
    </div>

    <div class="stat-row" style="margin-top:12px">
      <div class="stat-card">
        <div class="stat-value">{{ number_format($laporanRwSaya->total_kg, 1) }}</div>
        <div class="stat-label">Total KG</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">{{ $laporanRwSaya->jumlah_pengangkutan }}</div>
        <div class="stat-label">Pengangkutan</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">{{ $laporanRwSaya->tingkat_pilah_persen }}%</div>
        <div class="stat-label">Tingkat Pilah</div>
      </div>
      <div class="stat-card">
        <div class="stat-value">{{ number_format($laporanRwSaya->organik_kg, 1) }}</div>
        <div class="stat-label">Organik KG</div>
      </div>
    </div>
  @else
    <div class="empty-state" style="margin-bottom:16px">
      <div class="empty-icon">📊</div>
      <p>Belum ada laporan bulan ini untuk {{ $user->rw?->nama }}</p>
    </div>
  @endif

  {{-- Leaderboard --}}
  <h3 class="section-title">Peringkat RW</h3>
  @forelse($leaderboard as $i => $lap)
    <div class="card leaderboard-item">
      <div class="rank-badge rank-{{ $i + 1 <= 3 ? $i + 1 : 'other' }}">{{ $i + 1 }}</div>
      <div style="flex:1">
        <div style="font-weight:600;font-size:14px">{{ $lap->rw?->nama }}</div>
        <div style="font-size:12px;color:var(--muted)">{{ $lap->jumlah_pengangkutan }}x angkut · {{ number_format($lap->total_kg, 1) }} kg</div>
      </div>
      <div style="text-align:right">
        <div style="font-weight:700;font-size:16px;color:var(--navy)">{{ $lap->skor_rw }}</div>
        <div style="font-size:11px;color:var(--muted)">skor</div>
      </div>
    </div>
  @empty
    <div class="empty-state">
      <p>Belum ada data laporan</p>
    </div>
  @endforelse

  {{-- Riwayat --}}
  @if($riwayat->isNotEmpty())
    <h3 class="section-title" style="margin-top:20px">Riwayat 6 Bulan</h3>
    @foreach($riwayat as $r)
      <div class="card" style="display:flex;justify-content:space-between;align-items:center">
        <div>
          <div style="font-weight:600;font-size:14px">{{ $r->namaBulan() }} {{ $r->tahun }}</div>
          <div style="font-size:12px;color:var(--muted)">{{ number_format($r->total_kg, 1) }} kg · {{ $r->jumlah_pengangkutan }}x</div>
        </div>
        <div style="font-weight:700;font-size:18px;color:var(--navy)">{{ $r->skor_rw }}</div>
      </div>
    @endforeach
  @endif

</div>

<nav class="bottom-nav">
  <a href="{{ route('app.beranda') }}" class="nav-item">
    <div class="nav-icon">🏠</div>
    <span class="nav-label">Beranda</span>
  </a>
  <a href="{{ route('app.jadwal') }}" class="nav-item">
    <div class="nav-icon">📅</div>
    <span class="nav-label">Jadwal</span>
  </a>
  <a href="{{ route('app.edukasi') }}" class="nav-item">
    <div class="nav-icon">📚</div>
    <span class="nav-label">Edukasi</span>
  </a>
  <a href="{{ route('app.laporan') }}" class="nav-item">
    <div class="nav-icon active">📊</div>
    <span class="nav-label active">Laporan</span>
  </a>
  <a href="{{ route('app.profil') }}" class="nav-item">
    <div class="nav-icon">👤</div>
    <span class="nav-label">Profil</span>
  </a>
</nav>
@endsection
