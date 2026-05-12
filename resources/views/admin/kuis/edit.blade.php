@extends('admin.layouts.app')

@section('title', 'Edit Kuis')
@section('heading', 'Edit Kuis')

@section('content')
<div class="admin-card" style="max-width:700px">
  <form method="POST" action="{{ route('admin.kuis.update', $kuis->id) }}">
    @csrf @method('PUT')

    <div class="form-group">
      <label>Judul Kuis</label>
      <input type="text" name="judul" value="{{ old('judul', $kuis->judul) }}" class="form-control" required>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Edukasi Terkait</label>
        <select name="edukasi_id" class="form-control">
          <option value="">Kuis Umum</option>
          @foreach($edukasi as $e)
            <option value="{{ $e->id }}" {{ old('edukasi_id', $kuis->edukasi_id) == $e->id ? 'selected' : '' }}>{{ $e->judul }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="durasi_menit" value="{{ old('durasi_menit', $kuis->durasi_menit) }}" class="form-control" min="1" required>
      </div>
    </div>

    <div class="form-group">
      <label>
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $kuis->is_active) ? 'checked' : '' }}>
        Kuis Aktif
      </label>
    </div>

    <p style="font-size:12px;color:var(--muted);margin-top:8px">
      Untuk mengedit soal, gunakan halaman detail kuis. (Fitur edit soal inline akan datang.)
    </p>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Perbarui</button>
      <a href="{{ route('admin.kuis.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
