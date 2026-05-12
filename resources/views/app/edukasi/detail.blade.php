@extends('app.layouts.mobile')

@section('title', $edukasi->judul)

@section('content')
<div class="page-header-navy" style="padding-bottom:20px">
  <a href="{{ route('app.edukasi') }}" class="back-btn">←</a>
  <span class="badge-kategori badge-{{ $edukasi->kategori }}" style="margin-top:8px;display:inline-block">
    {{ ucfirst(str_replace('_', ' ', $edukasi->kategori)) }}
  </span>
  <h2 class="page-header-title" style="margin-top:6px;font-size:20px;line-height:1.3">{{ $edukasi->judul }}</h2>
</div>

<div class="page-content">

  @if($edukasi->thumbnail_url && $edukasi->format === 'artikel')
    <img src="{{ $edukasi->thumbnail_url }}" alt="{{ $edukasi->judul }}"
         style="width:100%;border-radius:12px;margin-bottom:16px;max-height:200px;object-fit:cover">
  @endif

  @if($edukasi->format === 'video' && $edukasi->video_url)
    <div class="video-wrapper">
      <iframe src="{{ $edukasi->video_url }}" frameborder="0" allowfullscreen class="video-frame"></iframe>
    </div>
  @endif

  <div class="artikel-konten">
    {!! nl2br(e($edukasi->konten)) !!}
  </div>

  {{-- Kuis --}}
  @if($edukasi->kuis && $edukasi->kuis->is_active)
    <div class="kuis-banner">
      <div class="kuis-banner-icon">❓</div>
      <div>
        <h4>{{ $edukasi->kuis->judul }}</h4>
        <p>{{ $edukasi->kuis->soal->count() }} soal · {{ $edukasi->kuis->durasi_menit }} menit</p>
      </div>
      @if($sudahIkutKuis)
        <span class="badge" style="background:#D4F5E6;color:#1a7a44">Selesai</span>
      @else
        <a href="{{ route('app.kuis.show', $edukasi->kuis->id) }}" class="btn-sm btn-sm-yellow">Mulai</a>
      @endif
    </div>
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
