@extends('admin.layouts.app')

@section('title', 'Tambah Edukasi')
@section('heading', 'Tambah Konten Edukasi')

@section('content')
<div class="admin-card" style="max-width:700px">
  <form method="POST" action="{{ route('admin.edukasi.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>Judul</label>
      <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
      @error('judul') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Kategori</label>
        <select name="kategori" class="form-control" required>
          <option value="">Pilih Kategori</option>
          <option value="organik" {{ old('kategori') == 'organik' ? 'selected' : '' }}>Organik</option>
          <option value="anorganik" {{ old('kategori') == 'anorganik' ? 'selected' : '' }}>Anorganik</option>
          <option value="b3" {{ old('kategori') == 'b3' ? 'selected' : '' }}>B3</option>
          <option value="daur_ulang" {{ old('kategori') == 'daur_ulang' ? 'selected' : '' }}>Daur Ulang</option>
        </select>
        @error('kategori') <span class="field-error">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label>Format</label>
        <select name="format" class="form-control" required>
          <option value="artikel" {{ old('format','artikel') == 'artikel' ? 'selected' : '' }}>Artikel</option>
          <option value="video" {{ old('format') == 'video' ? 'selected' : '' }}>Video</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Konten / Deskripsi</label>
      <textarea name="konten" class="form-control" rows="8">{{ old('konten') }}</textarea>
    </div>

    <div class="form-group">
      <label>Thumbnail</label>
      <input type="file" name="thumbnail" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
      <label>URL Video (jika format video)</label>
      <input type="url" name="video_url" value="{{ old('video_url') }}" class="form-control"
             placeholder="https://www.youtube.com/embed/...">
      @error('video_url') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
      <label>Durasi (menit)</label>
      <input type="number" name="durasi_menit" value="{{ old('durasi_menit') }}" class="form-control" min="1">
    </div>

    <div class="form-group">
      <label>
        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
        Terbitkan sekarang
      </label>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Simpan</button>
      <a href="{{ route('admin.edukasi.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
