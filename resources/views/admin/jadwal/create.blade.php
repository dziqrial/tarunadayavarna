@extends('admin.layouts.app')

@section('title', 'Buat Jadwal')
@section('heading', 'Buat Jadwal Baru')

@section('content')
<div class="admin-card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.jadwal.store') }}">
    @csrf

    @if($rws->count() > 1)
    <div class="form-group">
      <label>RW</label>
      <select name="rw_id" class="form-control" required>
        <option value="">Pilih RW</option>
        @foreach($rws as $rw)
          <option value="{{ $rw->id }}" {{ old('rw_id') == $rw->id ? 'selected' : '' }}>{{ $rw->nama }}</option>
        @endforeach
      </select>
      @error('rw_id') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    @else
      <input type="hidden" name="rw_id" value="{{ $rws->first()?->id }}">
    @endif

    <div class="form-group">
      <label>Petugas</label>
      <select name="petugas_id" class="form-control">
        <option value="">Pilih Petugas (opsional)</option>
        @foreach($petugas as $p)
          <option value="{{ $p->id }}" {{ old('petugas_id') == $p->id ? 'selected' : '' }}>
            {{ $p->nama }} ({{ $p->rw?->nama }})
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Tanggal</label>
      <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control" required>
      @error('tanggal') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Waktu Mulai</label>
        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Waktu Selesai</label>
        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="form-control" required>
      </div>
    </div>

    <div class="form-group">
      <label>Jenis Sampah</label>
      <select name="jenis_sampah" class="form-control" required>
        <option value="">Pilih Jenis</option>
        <option value="organik" {{ old('jenis_sampah') == 'organik' ? 'selected' : '' }}>Organik</option>
        <option value="anorganik" {{ old('jenis_sampah') == 'anorganik' ? 'selected' : '' }}>Anorganik</option>
        <option value="campuran" {{ old('jenis_sampah') == 'campuran' ? 'selected' : '' }}>Campuran</option>
        <option value="b3" {{ old('jenis_sampah') == 'b3' ? 'selected' : '' }}>B3</option>
      </select>
      @error('jenis_sampah') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Estimasi Berat (kg, opsional)</label>
      <input type="number" name="estimasi_kg" value="{{ old('estimasi_kg') }}" class="form-control" step="0.01" min="0">
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Buat Jadwal</button>
      <a href="{{ route('admin.jadwal.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
