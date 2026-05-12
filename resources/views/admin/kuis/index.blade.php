@extends('admin.layouts.app')

@section('title', 'Kuis')
@section('heading', 'Manajemen Kuis')

@section('topbar-actions')
  <a href="{{ route('admin.kuis.create') }}" class="btn-primary">+ Buat Kuis</a>
@endsection

@section('content')
<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Judul Kuis</th>
        <th>Edukasi Terkait</th>
        <th>Soal</th>
        <th>Durasi</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($kuis as $k)
        <tr>
          <td>{{ $k->judul }}</td>
          <td>{{ $k->edukasi?->judul ?? 'Kuis Umum' }}</td>
          <td>{{ $k->soal->count() }} soal</td>
          <td>{{ $k->durasi_menit }} menit</td>
          <td>
            <span class="badge" style="{{ $k->is_active ? 'background:#D4F5E6;color:#1a7a44' : 'background:#F0F0F0;color:#888' }}">
              {{ $k->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.kuis.show', $k->id) }}" class="btn-table-edit">Lihat</a>
            <a href="{{ route('admin.kuis.edit', $k->id) }}" class="btn-table-edit">Edit</a>
            <form method="POST" action="{{ route('admin.kuis.destroy', $k->id) }}" style="display:inline"
                  onsubmit="return confirm('Hapus kuis ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-table-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted)">Belum ada kuis.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $kuis->links() }}</div>
</div>
@endsection
