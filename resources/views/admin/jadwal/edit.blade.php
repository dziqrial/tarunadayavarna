@extends('admin.layouts.app')

@section('title', 'Edit Jadwal')
@section('heading', 'Edit Jadwal')

@section('content')
<div class="admin-card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}">
    @csrf @method('PUT')

    <input type="hidden" name="rw_id" value="{{ $jadwal->rw_id }}">

    <div class="form-group">
      <label>Petugas</label>
      <select name="petugas_id" class="form-control">
        <option value="">Pilih Petugas (opsional)</option>
        @foreach($petugas as $p)
          <option value="{{ $p->id }}" {{ old('petugas_id', $jadwal->petugas_id) == $p->id ? 'selected' : '' }}>
            {{ $p->nama }} ({{ $p->rw?->nama }})
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Tanggal</label>
      <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal->format('Y-m-d')) }}" class="form-control" required>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Waktu Mulai</label>
        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', substr($jadwal->waktu_mulai,0,5)) }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Waktu Selesai</label>
        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', substr($jadwal->waktu_selesai,0,5)) }}" class="form-control" required>
      </div>
    </div>

    <div class="form-group">
      <label>Jenis Sampah</label>
      <select name="jenis_sampah" class="form-control" required>
        @foreach(['organik' => 'Organik', 'anorganik' => 'Anorganik', 'campuran' => 'Campuran', 'b3' => 'B3'] as $val => $label)
          <option value="{{ $val }}" {{ old('jenis_sampah', $jadwal->jenis_sampah) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Status</label>
      <select name="status" class="form-control" required>
        @foreach(['menunggu' => 'Menunggu', 'proses' => 'Proses', 'selesai' => 'Selesai', 'batal' => 'Batal'] as $val => $label)
          <option value="{{ $val }}" {{ old('status', $jadwal->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Estimasi Berat (kg)</label>
      <input type="number" name="estimasi_kg" value="{{ old('estimasi_kg', $jadwal->estimasi_kg) }}" class="form-control" step="0.01" min="0">
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Perbarui</button>
      <a href="{{ route('admin.jadwal.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
