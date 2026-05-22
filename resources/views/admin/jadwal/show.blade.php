@extends('admin.layouts.app')

@section('title', 'Detail Jadwal')
@section('heading', 'Detail Jadwal')

@section('topbar-actions')
  <a href="{{ route('admin.jadwal.index') }}" class="btn-secondary">← Kembali</a>
  <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn-primary">Edit Jadwal</a>
@endsection

@section('content')

<div class="admin-grid-2">

  {{-- ── Info Jadwal ── --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>Informasi Jadwal</h3>
      <span class="badge badge-{{ $jadwal->status }}">{{ $jadwal->labelStatus() }}</span>
    </div>

    <table style="width:100%;font-size:13px;border-collapse:collapse">
      <tr>
        <td style="padding:8px 0;color:var(--muted);width:40%;border-bottom:1px solid var(--gray)">RW</td>
        <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">{{ $jadwal->rw?->nama ?? '—' }}</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Petugas</td>
        <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">{{ $jadwal->petugas?->nama ?? '—' }}</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Tanggal</td>
        <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">{{ $jadwal->tanggal->translatedFormat('d F Y') }}</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Waktu</td>
        <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">{{ substr($jadwal->waktu_mulai,0,5) }} – {{ substr($jadwal->waktu_selesai,0,5) }} WIB</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Jenis Sampah</td>
        <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">{{ $jadwal->labelJenisSampah() }}</td>
      </tr>
      <tr>
        <td style="padding:8px 0;color:var(--muted)">Estimasi Berat</td>
        <td style="padding:8px 0;font-weight:600">{{ $jadwal->estimasi_kg ? number_format($jadwal->estimasi_kg, 1) . ' kg' : '—' }}</td>
      </tr>
    </table>
  </div>

  {{-- ── Log Pengangkutan ── --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>Log Pengangkutan</h3>
      @if($jadwal->pengangkutanLog)
        <span style="font-size:11px;font-weight:700;background:#D4F5E6;color:#1a7a44;padding:3px 10px;border-radius:20px">Tersedia</span>
      @else
        <span style="font-size:11px;font-weight:700;background:#F0F0F0;color:#888;padding:3px 10px;border-radius:20px">Belum Ada</span>
      @endif
    </div>

    @if($jadwal->pengangkutanLog)
      {{-- ── Data log yang sudah ada ── --}}
      <table style="width:100%;font-size:13px;border-collapse:collapse">
        <tr>
          <td style="padding:8px 0;color:var(--muted);width:40%;border-bottom:1px solid var(--gray)">Berat Aktual</td>
          <td style="padding:8px 0;border-bottom:1px solid var(--gray)">
            <strong style="font-size:16px;color:var(--navy)">{{ number_format($jadwal->pengangkutanLog->berat_actual_kg, 1) }} kg</strong>
            @if($jadwal->estimasi_kg)
              <span style="font-size:11px;color:var(--muted);margin-left:6px">
                (estimasi {{ number_format($jadwal->estimasi_kg, 1) }} kg)
              </span>
            @endif
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Selesai Pada</td>
          <td style="padding:8px 0;font-weight:600;border-bottom:1px solid var(--gray)">
            {{ $jadwal->pengangkutanLog->selesai_at?->translatedFormat('d F Y, H:i') ?? '—' }}
          </td>
        </tr>
        @if($jadwal->pengangkutanLog->catatan)
        <tr>
          <td style="padding:8px 0;color:var(--muted);border-bottom:1px solid var(--gray)">Catatan</td>
          <td style="padding:8px 0;border-bottom:1px solid var(--gray)">{{ $jadwal->pengangkutanLog->catatan }}</td>
        </tr>
        @endif
        <tr>
          <td style="padding:8px 0;color:var(--muted)">Foto Bukti</td>
          <td style="padding:8px 0">
            @if($jadwal->pengangkutanLog->foto_bukti_url)
              <a href="{{ $jadwal->pengangkutanLog->foto_bukti_url }}" target="_blank">
                <img src="{{ $jadwal->pengangkutanLog->foto_bukti_url }}" alt="Bukti Pengangkutan"
                     style="width:100%;max-width:280px;border-radius:10px;object-fit:cover;cursor:pointer;
                            border:2px solid var(--gray);transition:opacity 0.2s"
                     onmouseover="this.style.opacity=0.85" onmouseout="this.style.opacity=1">
              </a>
              <p style="font-size:11px;color:var(--muted);margin-top:4px">Klik foto untuk membuka ukuran penuh</p>
            @else
              <span style="color:var(--muted);font-size:13px">Tidak ada foto</span>
            @endif
          </td>
        </tr>
      </table>

      {{-- Tombol update log (admin dapat menimpa log yang sudah ada) --}}
      <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--gray)">
        <p style="font-size:12px;color:var(--muted);margin-bottom:10px">Perbarui log jika ada koreksi data:</p>
        <a href="#form-log" style="font-size:12px;color:var(--navy);font-weight:600">→ Perbarui log pengangkutan</a>
      </div>

    @endif

    {{-- ── Form Input / Update Log ── --}}
    @if(!$jadwal->pengangkutanLog || in_array($jadwal->status, ['menunggu','proses','selesai']))
      <div id="form-log" style="{{ $jadwal->pengangkutanLog ? 'margin-top:20px;padding-top:16px;border-top:1px solid var(--gray)' : '' }}">
        @if(!$jadwal->pengangkutanLog)
          <p style="font-size:13px;color:var(--muted);margin-bottom:14px">
            Input log manual untuk mencatat hasil pengangkutan. Status jadwal akan otomatis diubah ke <strong>Selesai</strong>.
          </p>
        @else
          <h4 style="font-size:13px;font-weight:700;color:var(--navy);margin-bottom:12px">Perbarui Log</h4>
        @endif

        <form method="POST" action="{{ route('admin.jadwal.inputLog', $jadwal->id) }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Berat Aktual (kg) <span style="color:#e74c3c">*</span></label>
            <input type="number"
                   name="berat_actual_kg"
                   class="form-control"
                   step="0.01" min="0"
                   value="{{ old('berat_actual_kg', $jadwal->pengangkutanLog?->berat_actual_kg) }}"
                   required>
            @error('berat_actual_kg')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3"
                      placeholder="Kondisi pengangkutan, kendala, dll (opsional)">{{ old('catatan', $jadwal->pengangkutanLog?->catatan) }}</textarea>
            @error('catatan')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Foto Bukti <span style="font-size:11px;color:var(--muted)">(opsional, maks 2 MB)</span></label>
            <input type="file" name="foto_bukti" class="form-control" accept="image/*">
            @if($jadwal->pengangkutanLog?->foto_bukti_url)
              <p style="font-size:11px;color:var(--muted);margin-top:4px">Upload foto baru untuk mengganti foto yang sudah ada.</p>
            @endif
            @error('foto_bukti')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-primary">
              {{ $jadwal->pengangkutanLog ? 'Perbarui Log' : 'Simpan & Tandai Selesai' }}
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    @endif
  </div>

</div>

@endsection
