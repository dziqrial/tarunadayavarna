@extends('app.layouts.mobile')

@section('title', $kuis->judul)

@section('content')
<div class="page-header-navy">
  <a href="javascript:history.back()" class="back-btn">←</a>
  <h2 class="page-header-title">{{ $kuis->judul }}</h2>
  <p class="page-header-sub">{{ $kuis->soal->count() }} soal · {{ $kuis->durasi_menit }} menit</p>
</div>

<div class="page-content">
  @if($sudahIkut)
    <div class="empty-state">
      <div class="empty-icon">✅</div>
      <p>Anda sudah mengikuti kuis ini.</p>
      <a href="{{ route('app.edukasi') }}" class="btn-yellow" style="display:inline-block;margin-top:12px;width:auto;padding:0 24px">
        Kembali ke Edukasi
      </a>
    </div>
  @else
    <form method="POST" action="{{ route('app.kuis.submit', $kuis->id) }}">
      @csrf

      @foreach($kuis->soal as $i => $soal)
        <div class="card" style="margin-bottom:12px">
          <p class="soal-nomor">Soal {{ $i + 1 }}</p>
          <p class="soal-pertanyaan">{{ $soal->pertanyaan }}</p>

          <div class="pilihan-list">
            @foreach(['a' => $soal->pilihan_a, 'b' => $soal->pilihan_b, 'c' => $soal->pilihan_c, 'd' => $soal->pilihan_d] as $key => $pilihan)
              @if($pilihan)
                <label class="pilihan-item">
                  <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $key }}" required>
                  <span class="pilihan-key">{{ strtoupper($key) }}</span>
                  <span class="pilihan-text">{{ $pilihan }}</span>
                </label>
              @endif
            @endforeach
          </div>
        </div>
      @endforeach

      <button type="submit" class="btn-yellow">KUMPULKAN JAWABAN</button>
    </form>
  @endif
</div>
@endsection
