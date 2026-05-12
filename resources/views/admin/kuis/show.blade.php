@extends('admin.layouts.app')

@section('title', 'Detail Kuis')
@section('heading', $kuis->judul)

@section('topbar-actions')
  <a href="{{ route('admin.kuis.edit', $kuis->id) }}" class="btn-primary">Edit</a>
@endsection

@section('content')
<div class="admin-card" style="max-width:700px">
  <div style="margin-bottom:16px">
    <p><strong>Edukasi:</strong> {{ $kuis->edukasi?->judul ?? 'Kuis Umum' }}</p>
    <p><strong>Durasi:</strong> {{ $kuis->durasi_menit }} menit</p>
    <p><strong>Status:</strong>
      <span class="badge" style="{{ $kuis->is_active ? 'background:#D4F5E6;color:#1a7a44' : 'background:#F0F0F0;color:#888' }}">
        {{ $kuis->is_active ? 'Aktif' : 'Nonaktif' }}
      </span>
    </p>
    <p><strong>Jumlah Soal:</strong> {{ $kuis->soal->count() }}</p>
  </div>

  <hr style="margin:16px 0">

  @foreach($kuis->soal as $i => $soal)
    <div class="soal-block">
      <p class="soal-nomor">Soal {{ $i+1 }}</p>
      <p class="soal-pertanyaan">{{ $soal->pertanyaan }}</p>
      <div class="pilihan-list" style="margin-top:8px">
        @foreach(['a'=>$soal->pilihan_a,'b'=>$soal->pilihan_b,'c'=>$soal->pilihan_c,'d'=>$soal->pilihan_d] as $key=>$val)
          @if($val)
            <div class="pilihan-item" style="{{ $key==$soal->jawaban_benar ? 'background:#D4F5E6' : '' }};padding:6px 10px;border-radius:8px;margin-bottom:4px;display:flex;gap:8px">
              <strong style="color:var(--navy)">{{ strtoupper($key) }}</strong>
              <span>{{ $val }}</span>
              @if($key==$soal->jawaban_benar)
                <span style="margin-left:auto;color:#1a7a44;font-size:12px">✓ Benar</span>
              @endif
            </div>
          @endif
        @endforeach
      </div>
    </div>
  @endforeach

  <div class="form-actions" style="margin-top:20px">
    <a href="{{ route('admin.kuis.index') }}" class="btn-secondary">Kembali</a>
  </div>
</div>
@endsection
