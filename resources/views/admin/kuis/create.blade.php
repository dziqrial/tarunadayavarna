@extends('admin.layouts.app')

@section('title', 'Buat Kuis')
@section('heading', 'Buat Kuis Baru')

@section('content')
<div class="admin-card" style="max-width:750px">
  <form method="POST" action="{{ route('admin.kuis.store') }}" x-data="kuisForm()">
    @csrf

    <div class="form-group">
      <label>Judul Kuis</label>
      <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
      @error('judul') <span class="field-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Edukasi Terkait (opsional)</label>
        <select name="edukasi_id" class="form-control">
          <option value="">Kuis Umum</option>
          @foreach($edukasi as $e)
            <option value="{{ $e->id }}" {{ old('edukasi_id') == $e->id ? 'selected' : '' }}>{{ $e->judul }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Durasi (menit)</label>
        <input type="number" name="durasi_menit" value="{{ old('durasi_menit', 5) }}" class="form-control" min="1" required>
      </div>
    </div>

    <hr style="margin:20px 0">
    <h3 style="font-size:15px;font-weight:600;margin-bottom:12px">Soal-Soal</h3>

    <template x-for="(soal, i) in soalList" :key="i">
      <div class="soal-block">
        <div class="soal-header">
          <span x-text="'Soal ' + (i+1)"></span>
          <button type="button" @click="removeSoal(i)" class="btn-table-delete" x-show="soalList.length > 1">Hapus</button>
        </div>

        <div class="form-group">
          <label>Pertanyaan</label>
          <textarea :name="'soal[' + i + '][pertanyaan]'" class="form-control" rows="2" required
                    x-model="soal.pertanyaan"></textarea>
        </div>

        <div class="pilihan-grid">
          <template x-for="opt in ['a','b','c','d']" :key="opt">
            <div class="form-group">
              <label x-text="'Pilihan ' + opt.toUpperCase()"></label>
              <input type="text" :name="'soal[' + i + '][pilihan_' + opt + ']'"
                     class="form-control" x-model="soal['pilihan_' + opt]"
                     :required="opt === 'a' || opt === 'b'">
            </div>
          </template>
        </div>

        <div class="form-group">
          <label>Jawaban Benar</label>
          <select :name="'soal[' + i + '][jawaban_benar]'" class="form-control" required x-model="soal.jawaban_benar">
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
          </select>
        </div>
      </div>
    </template>

    <button type="button" @click="addSoal()" class="btn-secondary" style="margin-bottom:20px">
      + Tambah Soal
    </button>

    <div class="form-actions">
      <button type="submit" class="btn-primary">Simpan Kuis</button>
      <a href="{{ route('admin.kuis.index') }}" class="btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function kuisForm() {
  return {
    soalList: [{ pertanyaan:'', pilihan_a:'', pilihan_b:'', pilihan_c:'', pilihan_d:'', jawaban_benar:'a' }],
    addSoal() {
      this.soalList.push({ pertanyaan:'', pilihan_a:'', pilihan_b:'', pilihan_c:'', pilihan_d:'', jawaban_benar:'a' });
    },
    removeSoal(i) {
      this.soalList.splice(i, 1);
    }
  }
}
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
