@extends('app.layouts.mobile')

@section('title', 'Beranda')

@section('content')
<div class="page-header-navy">
  <div class="header-top-row">
    <div>
      <p class="header-greeting">Selamat datang,</p>
      <h2 class="header-name">{{ $user->nama }}</h2>
      <span class="role-badge">{{ ucfirst(str_replace('_', ' ', $user->role)) }} · {{ $user->rw?->nama ?? 'Super Admin' }}</span>
    </div>
    <a href="{{ route('app.notifikasi') }}" class="notif-btn">
      🔔
      @if($unreadNotifCount > 0)
        <span class="notif-badge">{{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}</span>
      @endif
    </a>
  </div>
</div>

<div class="page-content">

  {{-- Stat Cards --}}
  <div class="stat-row">
    <div class="stat-card stat-card-yellow">
      <div class="stat-value">{{ number_format($totalKgBulanIni, 1) }}</div>
      <div class="stat-label">kg bulan ini</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">{{ $jumlahAngkutBulanIni }}</div>
      <div class="stat-label">pengangkutan</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">{{ $skorRw }}</div>
      <div class="stat-label">skor RW</div>
    </div>
  </div>

  {{-- Menu Grid --}}
  <h3 class="section-title">Menu</h3>
  <div class="menu-grid" style="grid-template-columns: repeat(4, 1fr)">
    <a href="{{ route('app.jadwal') }}" class="menu-item">
      <div class="menu-icon">📅</div>
      <span>Jadwal</span>
    </a>
    <a href="{{ route('app.edukasi') }}" class="menu-item">
      <div class="menu-icon">📚</div>
      <span>Edukasi</span>
    </a>
    <a href="{{ route('app.laporan') }}" class="menu-item">
      <div class="menu-icon">📊</div>
      <span>Laporan</span>
    </a>
    <a href="{{ route('app.profil') }}" class="menu-item">
      <div class="menu-icon">👤</div>
      <span>Profil</span>
    </a>
  </div>
  <div class="menu-grid" style="grid-template-columns: repeat(4, 1fr)">
    <a href="{{ route('app.notifikasi') }}" class="menu-item">
      <div class="menu-icon">🔔</div>
      <span>Notifikasi</span>
    </a>
    <a href="{{ route('app.pengaturan') }}" class="menu-item">
      <div class="menu-icon">⚙️</div>
      <span>Pengaturan</span>
    </a>
    <div style="flex:1"></div>
    <div style="flex:1"></div>
  </div>

  {{-- Jadwal Hari Ini --}}
  <h3 class="section-title">Jadwal Hari Ini</h3>

  @forelse($jadwalHariIni as $j)
    <div class="card">
      <div class="jadwal-item">
        <div class="jadwal-dot dot-{{ $j->status }}"></div>
        <div class="jadwal-info">
          <div class="jadwal-waktu">{{ substr($j->waktu_mulai, 0, 5) }} – {{ substr($j->waktu_selesai, 0, 5) }}</div>
          <div class="jadwal-jenis">{{ $j->labelJenisSampah() }} · {{ $j->rw?->nama }}</div>
          @if($j->petugas)
            <div class="jadwal-petugas">Petugas: {{ $j->petugas->nama }}</div>
          @endif
        </div>
        <span class="badge badge-{{ $j->status }}">{{ $j->labelStatus() }}</span>
      </div>
    </div>
  @empty
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>Tidak ada jadwal hari ini</p>
    </div>
  @endforelse

</div>

{{-- Bottom Nav --}}
<nav class="bottom-nav">
  <a href="{{ route('app.beranda') }}" class="nav-item">
    <div class="nav-icon active">🏠</div>
    <span class="nav-label active">Beranda</span>
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
    <div class="nav-icon">📊</div>
    <span class="nav-label">Laporan</span>
  </a>
  <a href="{{ route('app.profil') }}" class="nav-item">
    <div class="nav-icon">👤</div>
    <span class="nav-label">Profil</span>
  </a>
</nav>
@endsection
