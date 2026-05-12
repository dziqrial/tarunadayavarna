@extends('admin.layouts.app')

@section('title', 'Kirim Notifikasi')
@section('heading', 'Kirim Notifikasi')

@section('content')
<div class="admin-card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.notifikasi.store') }}">
    @csrf

    <div class="form-group">
      <label>Judul</label>
      <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
      @error('judul') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Pesan</label>
      <textarea name="pesan" class="form-control" rows="4" required>{{ old('pesan') }}</textarea>
      @error('pesan') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Tipe</label>
        <select name="tipe" class="form-control" required>
          <option value="info" {{ old('tipe') == 'info' ? 'selected' : '' }}>Info</option>
          <option value="jadwal" {{ old('tipe') == 'jadwal' ? 'selected' : '' }}>Jadwal</option>
          @if(auth()->user()->isSuperAdmin())
            <option value="broadcast" {{ old('tipe') == 'broadcast' ? 'selected' : '' }}>Broadcast (semua RW)</option>
          @endif
        </select>
      </div>
      <div class="form-group">
        <label>Target Role</label>
        <select name="target_role" class="form-control">
          <option value="semua">Semua</option>
          <option value="warga" {{ old('target_role') == 'warga' ? 'selected' : '' }}>Warga</option>
          <option value="petugas" {{ old('target_role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
        </select>
      </div>
    </div>

    @if($user->isSuperAdmin() && $rws->count() > 1)
    <div class="form-group">
      <label>Target RW (kosongkan = semua RW)</label>
      <select name="target_rw_id" class="form-control">
        <option value="">Semua RW</option>
        @foreach($rws as $rw)
          <option value="{{ $rw->id }}" {{ old('target_rw_id') == $rw->id ? 'selected' : '' }}>{{ $rw->nama }}</option>
        @endforeach
      </select>
    </div>
    @else
      <input type="hidden" name="target_rw_id" value="{{ $user->rw_id }}">
    @endif

    <div class="form-actions">
      <button type="submit" class="btn-primary">Kirim Notifikasi</button>
      <a href="{{ route('admin.notifikasi.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
