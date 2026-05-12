@extends('admin.layouts.app')

@section('title', 'Edit Edukasi')
@section('heading', 'Edit Konten Edukasi')

@section('content')
<div class="admin-card" style="max-width:700px">
  <form method="POST" action="{{ route('admin.edukasi.update', $edukasi->id) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="form-group">
      <label>Judul</label>
      <input type="text" name="judul" value="{{ old('judul', $edukasi->judul) }}" class="form-control" required>
      @error('judul') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Kategori</label>
        <select name="kategori" class="form-control" required>
          @foreach(['organik'=>'Organik','anorganik'=>'Anorganik','b3'=>'B3','daur_ulang'=>'Daur Ulang'] as $val=>$label)
            <option value="{{ $val }}" {{ old('kategori',$edukasi->kategori)==$val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Format</label>
        <select name="format" class="form-control" required>
          <option value="artikel" {{ old('format',$edukasi->format)=='artikel' ? 'selected' : '' }}>Artikel</option>
          <option value="video" {{ old('format',$edukasi->format)=='video' ? 'selected' : '' }}>Video</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Konten</label>
      <textarea name="konten" class="form-control" rows="8">{{ old('konten', $edukasi->konten) }}</textarea>
    </div>

    @if($edukasi->thumbnail_url)
      <div class="form-group">
        <label>Thumbnail Saat Ini</label><br>
        <img src="{{ $edukasi->thumbnail_url }}" style="height:80px;border-radius:8px;margin-top:4px">
      </div>
    @endif

    <div class="form-group">
      <label>Ganti Thumbnail</label>
      <input type="file" name="thumbnail" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
      <label>URL Video</label>
      <input type="url" name="video_url" value="{{ old('video_url', $edukasi->video_url) }}" class="form-control">
    </div>

    <div class="form-group">
      <label>Durasi (menit)</label>
      <input type="number" name="durasi_menit" value="{{ old('durasi_menit', $edukasi->durasi_menit) }}" class="form-control" min="1">
    </div>

    <div class="form-group">
      <label>
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $edukasi->is_published) ? 'checked' : '' }}>
        Terbitkan
      </label>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Perbarui</button>
      <a href="{{ route('admin.edukasi.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
