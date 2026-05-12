@extends('admin.layouts.app')

@section('title', 'Edukasi')
@section('heading', 'Konten Edukasi')

@section('topbar-actions')
  <a href="{{ route('admin.edukasi.create') }}" class="btn-primary">+ Tambah Konten</a>
@endsection

@section('content')
<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Format</th>
        <th>Status</th>
        <th>Dibuat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($edukasi as $e)
        <tr>
          <td style="max-width:200px">{{ $e->judul }}</td>
          <td>{{ ucfirst(str_replace('_',' ',$e->kategori)) }}</td>
          <td>{{ ucfirst($e->format) }}</td>
          <td>
            <span class="badge" style="{{ $e->is_published ? 'background:#D4F5E6;color:#1a7a44' : 'background:#F0F0F0;color:#888' }}">
              {{ $e->is_published ? 'Terbit' : 'Draft' }}
            </span>
          </td>
          <td>{{ $e->created_at?->format('d/m/Y') }}</td>
          <td>
            <a href="{{ route('admin.edukasi.edit', $e->id) }}" class="btn-table-edit">Edit</a>
            <form method="POST" action="{{ route('admin.edukasi.destroy', $e->id) }}" style="display:inline"
                  onsubmit="return confirm('Hapus konten ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-table-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted)">Belum ada konten edukasi.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $edukasi->links() }}</div>
</div>
@endsection
