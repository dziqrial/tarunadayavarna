@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('heading', 'Edit Pengguna: ' . $user->nama)

@section('content')
<div class="admin-card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf @method('PUT')

    <div class="form-group">
      <label>Nama Lengkap</label>
      <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control" required>
      @error('nama') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
      @error('username') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
      @error('email') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Nomor WhatsApp</label>
      <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}" class="form-control">
    </div>

    <div class="form-group">
      <label>Role</label>
      <select name="role" class="form-control" required>
        @foreach($roles as $val => $label)
          <option value="{{ $val }}" {{ old('role', $user->role) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    @if($rws->count() > 1)
    <div class="form-group">
      <label>RW</label>
      <select name="rw_id" class="form-control">
        <option value="">Pilih RW</option>
        @foreach($rws as $rw)
          <option value="{{ $rw->id }}" {{ old('rw_id', $user->rw_id) == $rw->id ? 'selected' : '' }}>{{ $rw->nama }}</option>
        @endforeach
      </select>
    </div>
    @endif

    <div class="form-group">
      <label>
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
        Akun Aktif
      </label>
    </div>

    <div class="form-group">
      <label>Password Baru (kosongkan jika tidak diubah)</label>
      <input type="password" name="password" class="form-control">
      @error('password') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Perbarui</button>
      <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
