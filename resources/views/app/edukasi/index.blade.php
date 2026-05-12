@extends('app.layouts.mobile')

@section('title', 'Edukasi')

@section('content')
<div class="page-header-navy">
  <a href="{{ route('app.beranda') }}" class="back-btn">←</a>
  <h2 class="page-header-title">Edukasi Sampah</h2>
  <p class="page-header-sub">Pelajari cara memilah sampah</p>
</div>

<div class="page-content">

  {{-- Search --}}
  <form method="GET" action="{{ route('app.edukasi') }}" style="margin-bottom:12px">
    <div class="input-row">
      <div class="input-icon">🔍</div>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel...">
    </div>

    {{-- Filter Kategori --}}
    <div class="filter-pills" style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap" x-data="{ cat: '{{ request('kategori','') }}' }">
      @foreach(['' => 'Semua', 'organik' => '🌿 Organik', 'anorganik' => '♻️ Anorganik', 'b3' => '⚠️ B3', 'daur_ulang' => '🔄 Daur Ulang'] as $val => $label)
        <a href="{{ route('app.edukasi', array_merge(request()->query(), ['kategori' => $val])) }}"
           class="pill {{ request('kategori') == $val ? 'pill-active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>
  </form>

  {{-- Featured --}}
  @if($featured && !request('q') && !request('kategori'))
    <a href="{{ route('app.edukasi.detail', $featured->slug) }}" class="featured-card">
      @if($featured->thumbnail_url)
        <img src="{{ $featured->thumbnail_url }}" alt="{{ $featured->judul }}" class="featured-img">
      @else
        <div class="featured-img featured-placeholder">📰</div>
      @endif
      <div class="featured-overlay">
        <span class="featured-tag">Terbaru</span>
        <h3 class="featured-title">{{ $featured->judul }}</h3>
      </div>
    </a>
  @endif

  {{-- Grid --}}
  <div class="edukasi-grid">
    @forelse($edukasiList as $e)
      <a href="{{ route('app.edukasi.detail', $e->slug) }}" class="edukasi-card">
        @if($e->thumbnail_url)
          <img src="{{ $e->thumbnail_url }}" alt="{{ $e->judul }}" class="edukasi-thumb">
        @else
          <div class="edukasi-thumb edukasi-thumb-placeholder">
            {{ $e->format === 'video' ? '▶️' : '📄' }}
          </div>
        @endif
        <div class="edukasi-body">
          <span class="badge-kategori badge-{{ $e->kategori }}">{{ ucfirst(str_replace('_', ' ', $e->kategori)) }}</span>
          <h4 class="edukasi-title">{{ $e->judul }}</h4>
          @if($e->durasi_menit)
            <p class="edukasi-meta">{{ $e->durasi_menit }} menit</p>
          @endif
        </div>
      </a>
    @empty
      <div class="empty-state" style="grid-column:span 2">
        <div class="empty-icon">📚</div>
        <p>Belum ada konten edukasi</p>
      </div>
    @endforelse
  </div>
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
    <div class="nav-icon active">📚</div>
    <span class="nav-label active">Edukasi</span>
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
