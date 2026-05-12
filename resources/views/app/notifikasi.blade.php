@extends('app.layouts.mobile')

@section('title', 'Notifikasi')

@section('content')
<div class="page-header-navy">
  <a href="{{ route('app.beranda') }}" class="back-btn">←</a>
  <h2 class="page-header-title">Notifikasi</h2>
</div>

<div class="page-content">
  @forelse($notifikasis as $nu)
    <div class="card notif-item {{ $nu->is_read ? 'notif-read' : 'notif-unread' }}">
      <div class="notif-icon">
        {{ $nu->notifikasi?->tipe === 'jadwal' ? '📅' : ($nu->notifikasi?->tipe === 'broadcast' ? '📢' : 'ℹ️') }}
      </div>
      <div style="flex:1">
        <div class="notif-title">{{ $nu->notifikasi?->judul }}</div>
        <div class="notif-pesan">{{ $nu->notifikasi?->pesan }}</div>
        <div class="notif-waktu">{{ $nu->created_at?->diffForHumans() }}</div>
      </div>
      @if(!$nu->is_read)
        <span class="notif-dot"></span>
      @endif
    </div>
  @empty
    <div class="empty-state">
      <div class="empty-icon">🔔</div>
      <p>Belum ada notifikasi</p>
    </div>
  @endforelse

  {{ $notifikasis->links() }}
</div>
@endsection
