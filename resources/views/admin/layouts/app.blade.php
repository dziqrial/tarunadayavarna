<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') — Tarunadayavarna</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app-admin.css') }}">
  @stack('styles')
</head>
<body class="admin-body">

  <div class="admin-wrapper">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
      <div class="sidebar-logo">
        <div class="logo-badge">T</div>
        <div>
          <div class="logo-title">Tarunadayavarna</div>
          <div class="logo-sub">Panel Admin</div>
        </div>
      </div>

      <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
          <span class="nav-icon">📅</span> Jadwal
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
          <span class="nav-icon">👥</span> Pengguna
        </a>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.edukasi.index') }}" class="nav-link {{ request()->routeIs('admin.edukasi*') ? 'active' : '' }}">
          <span class="nav-icon">📚</span> Edukasi
        </a>
        <a href="{{ route('admin.kuis.index') }}" class="nav-link {{ request()->routeIs('admin.kuis*') ? 'active' : '' }}">
          <span class="nav-icon">❓</span> Kuis
        </a>
        @endif
        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
          <span class="nav-icon">📈</span> Laporan
        </a>
        <a href="{{ route('admin.notifikasi.index') }}" class="nav-link {{ request()->routeIs('admin.notifikasi*') ? 'active' : '' }}">
          <span class="nav-icon">🔔</span> Notifikasi
        </a>
      </nav>

      <div class="sidebar-user">
        <div class="user-avatar">{{ substr(auth()->user()->nama, 0, 1) }}</div>
        <div>
          <div class="user-name">{{ auth()->user()->nama }}</div>
          <div class="user-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
        </div>
        <form method="POST" action="{{ route('app.logout') }}" class="ml-auto">
          @csrf
          <button type="submit" class="btn-logout" title="Logout">↩</button>
        </form>
      </div>
    </aside>

    {{-- Main content --}}
    <main class="admin-main">
      <div class="admin-topbar">
        <h1 class="page-heading">@yield('heading', 'Dashboard')</h1>
        <div class="topbar-actions">@yield('topbar-actions')</div>
      </div>

      {{-- Flash --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
      @endif

      <div class="admin-content">
        @yield('content')
      </div>
    </main>

  </div>

  <script src="{{ asset('js/app-admin.js') }}"></script>
  @stack('scripts')
</body>
</html>
