@extends('app.layouts.mobile')

@section('title', 'Pengaturan')

@section('content')
<div class="page-header-navy">
  <a href="{{ route('app.beranda') }}" class="back-btn">←</a>
  <h2 class="page-header-title">Pengaturan</h2>
  <p class="page-header-sub">Kelola akun dan preferensi</p>
</div>

<div class="page-content">

  {{-- Ganti Password --}}
  <h3 class="section-title">Ganti Password</h3>
  <div class="card" style="margin-bottom:20px">
    <form method="POST" action="{{ route('app.pengaturan.password') }}">
      @csrf

      <div class="input-group">
        <label class="input-label">Password Lama</label>
        <div class="input-row">
          <div class="input-icon">🔒</div>
          <input type="password" name="password_lama" placeholder="Masukkan password lama" required>
        </div>
        @error('password_lama')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="input-group" style="margin-top:10px">
        <label class="input-label">Password Baru</label>
        <div class="input-row">
          <div class="input-icon">🔑</div>
          <input type="password" name="password_baru" placeholder="Minimal 8 karakter" required>
        </div>
        @error('password_baru')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="input-group" style="margin-top:10px">
        <label class="input-label">Konfirmasi Password Baru</label>
        <div class="input-row">
          <div class="input-icon">🔑</div>
          <input type="password" name="password_baru_confirmation" placeholder="Ulangi password baru" required>
        </div>
      </div>

      <button type="submit" class="btn-yellow" style="margin-top:16px">SIMPAN PASSWORD</button>
    </form>
  </div>

  {{-- Tentang Aplikasi --}}
  <h3 class="section-title">Tentang Aplikasi</h3>
  <div class="card" style="margin-bottom:20px">
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray)">
      <span style="font-size:13px;color:var(--muted)">Nama Aplikasi</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">Tarunadayavarna</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray)">
      <span style="font-size:13px;color:var(--muted)">Versi</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">1.0.0</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray)">
      <span style="font-size:13px;color:var(--muted)">Organisasi</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">Kelurahan Tarunadayavarna</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0">
      <span style="font-size:13px;color:var(--muted)">Kontak</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">admin@tarunadayavarna.id</span>
    </div>
  </div>

  {{-- Akun --}}
  <h3 class="section-title">Akun</h3>
  <div class="card" style="margin-bottom:20px">
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray)">
      <span style="font-size:13px;color:var(--muted)">Username</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">{{ $user->username }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray)">
      <span style="font-size:13px;color:var(--muted)">Peran</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0">
      <span style="font-size:13px;color:var(--muted)">RW</span>
      <span style="font-size:13px;font-weight:600;color:var(--navy)">{{ $user->rw?->nama ?? '—' }}</span>
    </div>
  </div>

  {{-- Keluar --}}
  <form method="POST" action="{{ route('app.logout') }}"
        onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
    @csrf
    <button type="submit" style="
      width: 100%; padding: 14px; border-radius: 14px;
      background: #fff; border: 2px solid #FFE5E5;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 600;
      color: #e74c3c; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
    ">
      🚪 Keluar dari Aplikasi
    </button>
  </form>

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
    <div class="nav-icon">📊</div>
    <span class="nav-label">Laporan</span>
  </a>
  <a href="{{ route('app.profil') }}" class="nav-item">
    <div class="nav-icon">👤</div>
    <span class="nav-label">Profil</span>
  </a>
</nav>
@endsection
