@extends('app.layouts.mobile')

@section('title', 'Login')

@section('content')
<div class="auth-screen">

  <div class="auth-header">
    <div class="logo-circle">
      <img src="{{ asset('images/logo.svg') }}" alt="Tarunadayavarna" style="width:44px;height:44px;object-fit:contain">
    </div>
    <h1 class="app-title">Tarunadayavarna</h1>
    <p class="app-subtitle">Sistem Pengelolaan Sampah Desa</p>
  </div>

  <div class="auth-card">
    <h2 class="auth-heading">Selamat Datang</h2>
    <p class="auth-desc">Masuk untuk melanjutkan</p>

    <form method="POST" action="{{ route('app.login') }}">
      @csrf

      <div class="input-group">
        <div class="input-row">
          <div class="input-icon">👤</div>
          <input type="text" name="username" value="{{ old('username') }}"
                 placeholder="Username" autocomplete="username" autofocus>
        </div>
        @error('username')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="input-group" style="margin-top:12px">
        <div class="input-row">
          <div class="input-icon">🔒</div>
          <input type="password" name="password" placeholder="Password" autocomplete="current-password">
        </div>
        @error('password')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn-yellow" style="margin-top:24px">LOGIN</button>
    </form>

    <p class="auth-link">
      Belum punya akun? <a href="{{ route('app.register') }}">Daftar di sini</a>
    </p>
  </div>

</div>
@endsection
