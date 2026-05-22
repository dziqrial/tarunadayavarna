@extends('app.layouts.mobile')

@section('title', 'Daftar Akun')

@section('content')
<div class="auth-screen" style="padding-bottom:30px">

  <div class="auth-header" style="padding:40px 24px 20px">
    <div class="logo-circle">
      <img src="{{ asset('images/logo.svg') }}" alt="Tarunadayavarna" style="width:44px;height:44px;object-fit:contain">
    </div>
    <h1 class="app-title">Daftar Akun</h1>
    <p class="app-subtitle">Buat akun warga baru</p>
  </div>

  <div class="auth-card">
    <form method="POST" action="{{ route('app.register') }}">
      @csrf

      <div class="input-group">
        <label class="input-label">Nama Lengkap</label>
        <div class="input-row">
          <div class="input-icon">👤</div>
          <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
        </div>
        @error('nama') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="input-group">
        <label class="input-label">Username</label>
        <div class="input-row">
          <div class="input-icon">🔖</div>
          <input type="text" name="username" value="{{ old('username') }}" placeholder="Username unik" required>
        </div>
        @error('username') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="input-group">
        <label class="input-label">Email (opsional)</label>
        <div class="input-row">
          <div class="input-icon">✉️</div>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (opsional)">
        </div>
        @error('email') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="input-group">
        <label class="input-label">Nomor WhatsApp (opsional)</label>
        <div class="input-row">
          <div class="input-icon">📱</div>
          <input type="text" name="no_wa" value="{{ old('no_wa') }}" placeholder="08xxxxxxxxxx">
        </div>
      </div>

      <div class="input-group">
        <label class="input-label">RW</label>
        <div class="input-row" style="padding-right:12px">
          <div class="input-icon">🏘️</div>
          <select name="rw_id" required style="flex:1;border:none;background:transparent;font-family:inherit;font-size:14px;outline:none">
            <option value="">Pilih RW Anda</option>
            @foreach($rws as $rw)
              <option value="{{ $rw->id }}" {{ old('rw_id') == $rw->id ? 'selected' : '' }}>
                {{ $rw->nama }}
              </option>
            @endforeach
          </select>
        </div>
        @error('rw_id') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="input-group">
        <label class="input-label">Password</label>
        <div class="input-row">
          <div class="input-icon">🔒</div>
          <input type="password" name="password" placeholder="Minimal 6 karakter" required>
        </div>
        @error('password') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="input-group">
        <label class="input-label">Konfirmasi Password</label>
        <div class="input-row">
          <div class="input-icon">🔒</div>
          <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
        </div>
      </div>

      <p style="font-size:11px;color:var(--muted);margin:16px 0;line-height:1.5">
        Akun Anda akan aktif setelah disetujui oleh Admin RW.
      </p>

      <button type="submit" class="btn-yellow">DAFTAR SEKARANG</button>
    </form>

    <p class="auth-link">
      Sudah punya akun? <a href="{{ route('app.login') }}">Login di sini</a>
    </p>
  </div>

</div>
@endsection
