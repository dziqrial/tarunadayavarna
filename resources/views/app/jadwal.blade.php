@extends('app.layouts.mobile')

@section('title', 'Jadwal')

@section('content')
<div class="page-header-navy">
  <a href="{{ route('app.beranda') }}" class="back-btn">←</a>
  <h2 class="page-header-title">Jadwal Pengangkutan</h2>
  <p class="page-header-sub">{{ $user->rw?->nama ?? 'Semua RW' }}</p>
</div>

<div class="page-content">

  {{-- Filter Tanggal --}}
  <form method="GET" action="{{ route('app.jadwal') }}" id="filter-form" style="margin-bottom:12px">
    <div class="input-row" style="padding-right:12px">
      <div class="input-icon">📅</div>
      <input type="date" name="tanggal" value="{{ request('tanggal') }}"
             style="flex:1;border:none;background:transparent;font-size:14px;outline:none"
             onchange="this.form.submit()">
    </div>
    {{-- preserve jenis filter --}}
    @if(request('jenis'))
      <input type="hidden" name="jenis" value="{{ request('jenis') }}">
    @endif
  </form>

  {{-- Filter Jenis Sampah (pills) --}}
  <div style="display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;margin-bottom:14px">
    @php
      $jenisList = ['' => 'Semua', 'organik' => 'Organik', 'anorganik' => 'Anorganik', 'campuran' => 'Campuran', 'b3' => 'B3'];
      $currentJenis = request('jenis', '');
    @endphp
    @foreach($jenisList as $val => $label)
      <a href="{{ route('app.jadwal', array_merge(request()->query(), ['jenis' => $val])) }}"
         class="pill {{ $currentJenis === $val ? 'pill-active' : '' }}"
         style="white-space:nowrap;padding:6px 14px">{{ $label }}</a>
    @endforeach
  </div>

  @forelse($jadwals as $j)
    <div class="card" style="margin-bottom:10px">
      <div class="jadwal-item">
        <div class="jadwal-dot dot-{{ $j->status }}"></div>
        <div class="jadwal-info" style="flex:1">
          <div class="jadwal-waktu">{{ $j->tanggal->format('d M Y') }} · {{ substr($j->waktu_mulai, 0, 5) }}–{{ substr($j->waktu_selesai, 0, 5) }}</div>
          <div class="jadwal-jenis" style="font-weight:600">{{ $j->labelJenisSampah() }}</div>
          @if($j->petugas)
            <div class="jadwal-petugas">Petugas: {{ $j->petugas->nama }}</div>
          @endif
          @if($j->estimasi_kg)
            <div class="jadwal-petugas">Estimasi: {{ $j->estimasi_kg }} kg</div>
          @endif
        </div>
        <span class="badge badge-{{ $j->status }}">{{ $j->labelStatus() }}</span>
      </div>

      {{-- Aksi petugas/admin --}}
      @if(in_array(auth()->user()->role, ['petugas','admin_rw','super_admin']))
        <div style="border-top:1px solid #f0f0f0;margin-top:10px;padding-top:10px;display:flex;gap:8px;flex-wrap:wrap">

          @if($j->status === 'menunggu')
            <form method="POST" action="{{ route('app.jadwal.status', $j->id) }}">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="proses">
              <button type="submit" class="btn-sm btn-sm-yellow">Mulai</button>
            </form>
          @endif

          @if($j->status === 'proses' && !$j->pengangkutanLog)
            <form method="POST" action="{{ route('app.jadwal.log', $j->id) }}"
                  enctype="multipart/form-data" x-data="{ open: false }">
              @csrf
              <button type="button" class="btn-sm btn-sm-navy" @click="open = !open">Input Log</button>
              <div x-show="open" style="margin-top:10px">
                <div class="input-group">
                  <div class="input-row">
                    <div class="input-icon">⚖️</div>
                    <input type="number" name="berat_actual_kg" placeholder="Berat aktual (kg)" step="0.01" min="0" required>
                  </div>
                </div>
                <div class="input-group" style="margin-top:8px">
                  <div class="input-row">
                    <div class="input-icon">📷</div>
                    <input type="file" name="foto_bukti" accept="image/*" style="flex:1;border:none;background:transparent;font-size:13px;outline:none;padding:8px 0">
                  </div>
                </div>
                <div class="input-group" style="margin-top:8px">
                  <div class="input-row">
                    <div class="input-icon">📝</div>
                    <input type="text" name="catatan" placeholder="Catatan (opsional)">
                  </div>
                </div>
                <button type="submit" class="btn-yellow" style="margin-top:10px;height:44px;font-size:13px">Simpan & Selesai</button>
              </div>
            </form>
          @endif

          @if($j->status !== 'selesai' && $j->status !== 'batal')
            <form method="POST" action="{{ route('app.jadwal.status', $j->id) }}">
              @csrf @method('PATCH')
              <input type="hidden" name="status" value="batal">
              <button type="submit" class="btn-sm btn-sm-danger"
                      onclick="return confirm('Batalkan jadwal ini?')">Batal</button>
            </form>
          @endif

        </div>
      @endif

      {{-- Foto bukti kalau sudah ada log --}}
      @if($j->pengangkutanLog?->foto_bukti_url)
        <div style="margin-top:8px">
          <img src="{{ $j->pengangkutanLog->foto_bukti_url }}" alt="Bukti"
               style="width:100%;border-radius:8px;max-height:200px;object-fit:cover">
          <p style="font-size:11px;color:var(--muted);margin-top:4px">
            Berat: {{ $j->pengangkutanLog->berat_actual_kg }} kg
          </p>
        </div>
      @endif
    </div>
  @empty
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>Tidak ada jadwal ditemukan</p>
    </div>
  @endforelse
</div>

<nav class="bottom-nav">
  <a href="{{ route('app.beranda') }}" class="nav-item">
    <div class="nav-icon">🏠</div>
    <span class="nav-label">Beranda</span>
  </a>
  <a href="{{ route('app.jadwal') }}" class="nav-item">
    <div class="nav-icon active">📅</div>
    <span class="nav-label active">Jadwal</span>
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
