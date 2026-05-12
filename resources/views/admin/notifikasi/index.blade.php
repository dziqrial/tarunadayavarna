@extends('admin.layouts.app')

@section('title', 'Notifikasi')
@section('heading', 'Notifikasi')

@section('topbar-actions')
  <a href="{{ route('admin.notifikasi.create') }}" class="btn-primary">+ Kirim Notifikasi</a>
@endsection

@section('content')
<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Judul</th>
        <th>Tipe</th>
        <th>Target RW</th>
        <th>Dikirim oleh</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      @forelse($notifikasis as $n)
        <tr>
          <td>
            <div style="font-weight:600">{{ $n->judul }}</div>
            <div style="font-size:12px;color:var(--muted)">{{ Str::limit($n->pesan, 60) }}</div>
          </td>
          <td>
            <span class="badge" style="background:#e8f0fe;color:#3d5afe">{{ ucfirst($n->tipe) }}</span>
          </td>
          <td>{{ $n->targetRw?->nama ?? 'Semua RW' }}</td>
          <td>{{ $n->createdBy?->nama ?? '-' }}</td>
          <td>{{ $n->created_at?->format('d/m/Y H:i') }}</td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;color:var(--muted)">Belum ada notifikasi.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $notifikasis->links() }}</div>
</div>
@endsection
