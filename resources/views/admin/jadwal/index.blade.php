@extends('admin.layouts.app')

@section('title', 'Jadwal')
@section('heading', 'Manajemen Jadwal')

@section('topbar-actions')
  <a href="{{ route('admin.jadwal.create') }}" class="btn-primary">+ Buat Jadwal</a>
@endsection

@section('content')
<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>RW</th>
        <th>Jenis Sampah</th>
        <th>Petugas</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($jadwals as $j)
        <tr>
          <td>{{ $j->tanggal->format('d/m/Y') }}</td>
          <td>{{ substr($j->waktu_mulai,0,5) }}–{{ substr($j->waktu_selesai,0,5) }}</td>
          <td>{{ $j->rw?->nama }}</td>
          <td>{{ $j->labelJenisSampah() }}</td>
          <td>{{ $j->petugas?->nama ?? '-' }}</td>
          <td><span class="badge badge-{{ $j->status }}">{{ $j->labelStatus() }}</span></td>
          <td>
            <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="btn-table-edit">Edit</a>
            <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id) }}" style="display:inline"
                  onsubmit="return confirm('Hapus jadwal ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-table-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:var(--muted)">Belum ada jadwal.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $jadwals->links() }}</div>
</div>
@endsection
