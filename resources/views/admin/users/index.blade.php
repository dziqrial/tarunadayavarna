@extends('admin.layouts.app')

@section('title', 'Pengguna')
@section('heading', 'Manajemen Pengguna')

@section('topbar-actions')
  <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Tambah User</a>
@endsection

@section('content')
<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Username</th>
        <th>Role</th>
        <th>RW</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
        <tr>
          <td>{{ $u->nama }}</td>
          <td style="color:var(--muted)">{{ $u->username }}</td>
          <td><span class="badge-role badge-role-{{ $u->role }}">{{ ucfirst(str_replace('_',' ',$u->role)) }}</span></td>
          <td>{{ $u->rw?->nama ?? '-' }}</td>
          <td>
            <span class="badge" style="{{ $u->is_active ? 'background:#D4F5E6;color:#1a7a44' : 'background:#F0F0F0;color:#888' }}">
              {{ $u->is_active ? 'Aktif' : 'Non-aktif' }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn-table-edit">Edit</a>
            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline"
                  onsubmit="return confirm('Hapus user ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-table-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted)">Tidak ada data user.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px">{{ $users->links() }}</div>
</div>
@endsection
