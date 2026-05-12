@extends('app.layouts.mobile')

@section('title', 'Profil')

@section('content')
<div class="page-header-navy" style="text-align:center;padding-bottom:30px">
  <div class="profil-avatar">
    @if($user->foto_profil)
      <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->nama }}" class="avatar-img">
    @else
      <div class="avatar-initials">{{ strtoupper(substr($user->nama, 0, 2)) }}</div>
    @endif
  </div>
  <h2 style="color:#fff;font-family:'Cormorant Garamond',serif;font-size:22px;margin:8px 0 4px">{{ $user->nama }}</h2>
  <span class="role-badge">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
  @if($user->rw)
    <p style="color:rgba(255,255,255,0.7);font-size:12px;margin-top:4px">{{ $user->rw->nama }}</p>
  @endif
</div>

<div class="page-content">

  {{-- Stat --}}
  <div class="stat-row" style="margin-bottom:20px">
    <div class="stat-card">
      <div class="stat-value">{{ $totalKuis }}</div>
      <div class="stat-label">Kuis Selesai</div>
    </div>
    <div class="stat-card stat-card-yellow">
      <div class="stat-value">{{ number_format($avgSkor, 0) }}</div>
      <div class="stat-label">Rata-rata Skor</div>
    </div>
  </div>

  {{-- Form Edit Profil --}}
  <h3 class="section-title">Edit Profil</h3>
  <form method="POST" action="{{ route('app.profil.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="input-group">
      <label class="input-label">Nama Lengkap</label>
      <div class="input-row">
        <div class="input-icon">👤</div>
        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
      </div>
      @error('nama') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="input-group">
      <label class="input-label">Email</label>
      <div class="input-row">
        <div class="input-icon">✉️</div>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
      </div>
      @error('email') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="input-group">
      <label class="input-label">Nomor WhatsApp</label>
      <div class="input-row">
        <div class="input-icon">📱</div>
        <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}">
      </div>
    </div>

    <div class="input-group">
      <label class="input-label">Foto Profil</label>
      <div class="input-row">
        <div class="input-icon">📷</div>
        <input type="file" name="foto_profil" accept="image/*"
               style="flex:1;border:none;background:transparent;font-size:13px;outline:none;padding:8px 0">
      </div>
    </div>

    <div class="input-group">
      <label class="input-label">Password Baru (opsional)</label>
      <div class="input-row">
        <div class="input-icon">🔒</div>
        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
      </div>
      @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="input-group">
      <label class="input-label">Konfirmasi Password Baru</label>
      <div class="input-row">
        <div class="input-icon">🔒</div>
        <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
      </div>
    </div>

    <button type="submit" class="btn-yellow" style="margin-top:20px">SIMPAN PERUBAHAN</button>
  </form>

  {{-- Logout --}}
  <form method="POST" action="{{ route('app.logout') }}" style="margin-top:16px">
    @csrf
    <button type="submit" class="btn-logout-full">Logout</button>
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
    <div class="nav-icon active">👤</div>
    <span class="nav-label active">Profil</span>
  </a>
</nav>
@endsection
