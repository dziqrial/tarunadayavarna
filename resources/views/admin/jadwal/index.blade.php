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
        <th>Log Bukti</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($jadwals as $j)
        <tr>
          <td>{{ $j->tanggal->format('d/m/Y') }}</td>
          <td style="white-space:nowrap">{{ substr($j->waktu_mulai,0,5) }}–{{ substr($j->waktu_selesai,0,5) }}</td>
          <td>{{ $j->rw?->nama }}</td>
          <td>{{ $j->labelJenisSampah() }}</td>
          <td>{{ $j->petugas?->nama ?? '-' }}</td>
          <td><span class="badge badge-{{ $j->status }}">{{ $j->labelStatus() }}</span></td>
          <td>
            @if($j->pengangkutanLog)
              <div style="font-size:12px">
                <span style="font-weight:700;color:var(--navy)">{{ number_format($j->pengangkutanLog->berat_actual_kg, 1) }} kg</span>
                @if($j->pengangkutanLog->foto_bukti_url)
                  <span style="color:var(--green);margin-left:4px" title="Foto tersedia">📷</span>
                @endif
              </div>
              <a href="{{ route('admin.jadwal.show', $j->id) }}" class="btn-primary-sm" style="margin-top:4px;display:inline-block">Lihat Detail</a>
            @else
              <span style="font-size:12px;color:var(--muted)">Belum ada log</span>
              @if(in_array($j->status, ['menunggu','proses']))
                <a href="{{ route('admin.jadwal.show', $j->id) }}" class="btn-table-edit" style="display:block;margin-top:4px;text-align:center">Input Log</a>
              @endif
            @endif
          </td>
          <td style="white-space:nowrap">
            <a href="{{ route('admin.jadwal.show', $j->id) }}" class="btn-table-edit">Detail</a>
            <a href="{{ route('admin.jadwal.edit', $j->id) }}" style="background:#f3e5f5;color:#6a1b9a;padding:4px 10px;border-radius:7px;font-size:12px;font-weight:600;text-decoration:none;display:inline-block">Edit</a>
            <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id) }}" style="display:inline"
                  onsubmit="return confirm('Hapus jadwal ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-table-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">Belum ada jadwal.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $jadwals->links() }}</div>
</div>
@endsection
