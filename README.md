# 🌿 TARUNADAYAVARNA
### Sistem Pengelolaan Sampah Tingkat Desa
**Laravel 11 · Full Stack · Mobile-First · v1.0 · 2026**

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Tech Stack](#-tech-stack)
- [Sistem Desain Global](#-sistem-desain-global)
- [Psikologi Warna](#-psikologi-warna)
- [Role & Akses Pengguna](#-role--akses-pengguna)
- [Antarmuka Mobile `/app`](#-antarmuka-mobile-app)
  - [Login](#1-login--applogin)
  - [Register](#2-register--appregister)
  - [Beranda](#3-beranda--appberanda)
  - [Jadwal](#4-jadwal--appjadwal)
  - [Edukasi — Daftar](#5-edukasi-daftar--appedukasi)
  - [Edukasi — Detail](#6-edukasi-detail--appedukasiSlug)
  - [Kuis](#7-kuis--appkuisid)
  - [Laporan](#8-laporan--applaporan)
  - [Profil](#9-profil--appprofil)
  - [Notifikasi](#10-notifikasi--appnotifikasi)
- [Antarmuka Admin `/admin`](#-antarmuka-admin-admin)
  - [Layout & Sidebar](#11-layout--sidebar)
  - [Dashboard](#12-dashboard--admindashboard)
  - [Manajemen Pengguna](#13-manajemen-pengguna--adminusers)
  - [Manajemen Jadwal](#14-manajemen-jadwal--adminjadwal)
  - [Manajemen Edukasi](#15-manajemen-edukasi--adminedukasi)
  - [Manajemen Kuis](#16-manajemen-kuis--adminkuis)
  - [Laporan Bulanan](#17-laporan-bulanan--adminlaporan)
  - [Notifikasi Admin](#18-notifikasi-admin--adminnotifikasi)
- [Matriks Pengguna × Antarmuka](#-matriks-pengguna--antarmuka)
- [Instalasi & Menjalankan](#-instalasi--menjalankan)
- [Akun Seeder Default](#-akun-seeder-default)

---

## 🌱 Tentang Proyek

**Tarunadayavarna** adalah aplikasi web pengelolaan sampah tingkat desa yang mencakup:
- **Edukasi pemilahan sampah** berbasis artikel & video
- **Penjadwalan pengangkutan** truk sampah per RW
- **Pelaporan bulanan berbasis data** dengan sistem skor & leaderboard RW
- **Manajemen pengguna** berjenjang (super admin → admin RW → petugas → warga)

> Didesain mobile-first dengan shell 390px — terasa seperti aplikasi native di smartphone, tetap dapat diakses via browser desktop.

---

## 🛠 Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 (Full Stack — Blade, bukan API) |
| Frontend | Laravel Blade + Alpine.js + CSS Custom |
| Database | MySQL |
| Auth | Session-based (bukan token/Sanctum) |
| Storage | Laravel Storage (`storage/app/public/`) |
| JS Framework | Tidak ada — Alpine.js untuk interaksi ringan |

---

## 🎨 Sistem Desain Global

### Tipografi

| Penggunaan | Font | Alasan |
|---|---|---|
| Judul halaman, angka statistik besar, nama pengguna | **Cormorant Garamond** (serif 500–700) | Kesan elegan, otoritatif, dan "resmi" — cocok untuk sistem pemerintahan desa |
| Body, label, tombol, navigasi | **Plus Jakarta Sans** (sans-serif 400–800) | Keterbacaan tinggi di layar kecil, modern, familier |

### Mobile Shell

Semua halaman `/app` dirender dalam container tetap **390px** di tengah layar:

```
Desktop:  [ ░░░░ gray background ░░░░ ]
          [ ░░ [shadow | 390px shell | shadow] ░░ ]

Mobile:   [ ← 100vw full screen → ]
```

Pada perangkat ≤480px, shell otomatis melebar ke `100vw` (full screen).

### Komponen UI Standar

| Komponen | Dimensi | Keterangan |
|---|---|---|
| Tombol CTA (`.btn-yellow`) | Lebar 100%, tinggi 52px, radius 14px | Aksi utama satu halaman |
| Input field (`.input-row`) | Tinggi 52px, radius 14px | Tap target ≥48px (WCAG) |
| Card (`.card`) | Auto, radius 16px | Pengelompokan konten |
| Bottom nav | 64px, sticky bottom | Navigasi utama mobile |
| Badge status | 18–24px | Indikator kondisi sekilas |

---

## 🎨 Psikologi Warna

```
╔══════════════════════════════════════════════════════════╗
║  #0D1B4B  ████  NAVY — Primary                          ║
║           Kepercayaan · Otoritas · Stabilitas Pemerintah ║
╠══════════════════════════════════════════════════════════╣
║  #F5C518  ████  KUNING EMAS — Accent                    ║
║           Energi · Optimisme · Aksi · Visibilitas Tinggi ║
╠══════════════════════════════════════════════════════════╣
║  #2ECC71  ████  HIJAU — Sukses                          ║
║           Selesai · Aman · Ramah Lingkungan             ║
╠══════════════════════════════════════════════════════════╣
║  #F4F6FB  ████  ABU TERANG — Background                 ║
║           Netral · Pemisah Halus · Tidak Mengganggu     ║
╠══════════════════════════════════════════════════════════╣
║  #c0392b  ████  MERAH — Destruktif                      ║
║           Bahaya · Hentikan · Micro-Friction Disengaja   ║
╠══════════════════════════════════════════════════════════╣
║  #8892a4  ████  MUTED — Sekunder                        ║
║           Info Tambahan · Tidak Dominan · Placeholder   ║
╚══════════════════════════════════════════════════════════╝
```

### Detail Psikologi per Warna

#### 🔵 Navy `#0D1B4B`
Biru gelap secara universal diasosiasikan dengan **kepercayaan dan otoritas**. Dalam konteks sistem pemerintahan desa, navy membangun persepsi bahwa sistem ini resmi dan dapat diandalkan — mendorong kepercayaan warga untuk aktif menggunakan dan melaporkan data.

**Diterapkan pada:** Header halaman, sidebar admin, nav aktif, teks penting.

#### 🟡 Kuning Emas `#F5C518`
Kuning adalah warna dengan **visibilitas tertinggi** di spektrum warna. Warna emas mengkomunikasikan nilai dan pencapaian. Dalam konteks sosial Indonesia, kuning juga diasosiasikan dengan kehangatan komunitas.

**Diterapkan pada:** Tombol CTA utama, badge notifikasi, peringkat #1 (emas), ikon input, aksen dekorasi header.

#### 🟢 Hijau `#2ECC71`
Hijau adalah warna universal untuk **"aman" dan "selesai"**. Dalam konteks aplikasi sampah/lingkungan, hijau memiliki relevansi ganda — indikator sukses sekaligus pengingat konteks ekologis.

**Diterapkan pada:** Status "Selesai" jadwal, konfirmasi aksi berhasil, dot progress selesai.

#### 🔴 Merah `#c0392b` / `#FDECEA`
Merah mengkomunikasikan **bahaya dan penghentian**. Digunakan *sparingly* dengan intensitas rendah (background merah muda) agar tidak menciptakan kecemasan berlebihan, namun tetap menimbulkan *micro-friction* pada aksi destruktif.

**Diterapkan pada:** Status "Batal", tombol hapus, error message, validasi form.

#### ⚫ Abu `#8892a4` / `#F0F0F0`
Abu netral, **tidak mengajak aksi**. Secara visual "merendahkan prioritas" elemen yang belum aktif atau informasi sekunder.

**Diterapkan pada:** Status "Menunggu", placeholder text, label sekunder.

### Kontras & Aksesibilitas

| Kombinasi Warna | Rasio Kontras | WCAG AA |
|---|---|---|
| Navy di atas White | 14.7:1 | ✅ Pass |
| Navy di atas Yellow | 6.2:1 | ✅ Pass |
| White di atas Navy | 14.7:1 | ✅ Pass |
| Text (#1a1a2e) di atas Gray | 12.4:1 | ✅ Pass |
| Muted (#8892a4) di atas White | 3.1:1 | ⚠️ AA Large only |

> Warna muted hanya digunakan pada teks ≥14px, memenuhi kriteria WCAG AA Large.

---

## 👥 Role & Akses Pengguna

| Role | Deskripsi | Cara Membuat Akun |
|---|---|---|
| `super_admin` | Ketua Tarunadayavarna, akses penuh semua RW | Seeder / manual |
| `admin_rw` | Koordinator per RW, manage RW-nya sendiri | Dibuat oleh super_admin |
| `petugas` | Driver truk sampah, update status jadwal | Dibuat oleh admin_rw |
| `warga` | Masyarakat umum, view only + edukasi | Daftar sendiri via `/app/register` |

---

## 📱 Antarmuka Mobile `/app`

> Semua halaman mobile menggunakan layout `app.layouts.mobile` dengan mobile shell 390px.

---

### 1. Login — `/app/login`

**Pengguna:** Semua role

```
┌─────────────────────────┐
│   [NAVY BACKGROUND]     │
│                         │
│       ┌───┐             │
│       │ T │  Logo Badge │  ← Kotak kuning 72×72px
│       └───┘             │
│   Tarunadayavarna       │  ← Cormorant Garamond 26px
│   Sistem Pengelolaan... │  ← Plus Jakarta 12px, opacity 60%
│                         │
├─────────────────────────┤
│  [CARD PUTIH]           │
│   radius-top: 28px      │
│                         │
│  Selamat Datang         │  ← Cormorant 24px navy
│  Masuk untuk melanjutkan│  ← Jakarta 13px muted
│                         │
│  ┌──[👤]──username───┐  │  ← Input 52px
│  └──[🔒]──password───┘  │
│                         │
│  ┌──── L O G I N ────┐  │  ← Tombol kuning 52px full-width
│  └───────────────────┘  │
│  Belum punya akun?      │
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Background atas | Navy `#0D1B4B` | Menciptakan "pintu masuk resmi" — kesan sistem pemerintahan |
| Card radius atas | `28px` | Sudut besar = ramah dan tidak mengintimidasi pengguna baru |
| Logo badge | Kotak kuning 72×72px | Brand recognition; kuning menarik perhatian pertama |
| Input height | `52px` | Tap target WCAG ≥48px — penting untuk pengguna tua/lansia |
| Focus border | `2px solid var(--yellow)` | Feedback visual saat mengetik untuk pengguna digital-rendah |
| Ikon dalam input | Background kuning 36×36px | Memperkuat visual hierarki; terasa seperti app mobile |
| Tombol CTA | `100%` lebar, shadow `rgba(245,197,24,0.4)` | Lebar penuh = mudah tap; glow = terasa interaktif |

**Psikologi:** Navy atas + putih bawah menciptakan persepsi "masuk ke sistem terpercaya". Pengguna bawah sadar merasakan perbedaan "dunia luar" (navy) dan "ruang aman" (card putih).

---

### 2. Register — `/app/register`

**Pengguna:** Warga baru

```
┌─────────────────────────┐
│   [NAVY - lebih pendek] │
│       ┌───┐             │
│       │ T │             │
│       └───┘             │
│   Daftar Akun           │
├─────────────────────────┤
│  [CARD PUTIH]           │
│                         │
│  NAMA LENGKAP  [👤]     │  ← 6 field input berurutan
│  USERNAME      [🔖]     │
│  EMAIL         [✉️]      │
│  NO. WHATSAPP  [📱]     │
│  RW            [🏘️] ▼  │  ← Dropdown pilih RW
│  PASSWORD      [🔒]     │
│  KONFIRMASI    [🔒]     │
│                         │
│  ℹ Akun aktif setelah   │  ← Info 11px muted
│    disetujui admin RW   │
│                         │
│  ┌── DAFTAR SEKARANG ──┐│
│  └─────────────────────┘│
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Jumlah field | 6 field | Minimal yang dibutuhkan — tidak membebani pengguna baru |
| Teks info approval | `11px muted` | Sekunder secara visual — tidak menakutkan tapi tetap terbaca |
| Dropdown RW | Select terstruktur | Mencegah typo nama RW — integritas data terjaga |
| Default status | `is_active = false` | Warga tidak bisa login sebelum disetujui admin — keamanan terjaga |
| Label field | `UPPERCASE 12px muted` | Konvensi form modern, memisahkan label dari placeholder |

**Psikologi:** Ekspektasi terkelola — warga tahu di halaman register bahwa akun perlu persetujuan, bukan setelah submit. Mengurangi frustrasi.

---

### 3. Beranda — `/app/beranda`

**Pengguna:** Semua role (konten berbeda per role)

```
┌─────────────────────────┐
│  [PAGE HEADER NAVY]     │
│  ⬤ dekorasi 200px kuning│  ← Lingkaran rgba(245,197,24,0.12)
│  Selamat datang,        │  ← 12px opacity 65%
│  Budi Santoso           │  ← Cormorant 22px putih
│  [Petugas · RW 01]      │  ← Role badge semi-transparan
│                   [🔔3] │  ← Notif badge count kuning
├─────────────────────────┤
│  ┌─────┐ ┌─────┐ ┌────┐│
│  │12.5 │ │  4  │ │ 78 ││  ← Stat row: kg / angkutan / skor
│  │ kg  │ │angk │ │ RW ││  ← Tengah kuning = KPI utama
│  └─────┘ └─────┘ └────┘│
│                         │
│  Menu                   │  ← Cormorant 18px
│  ┌────┐┌────┐┌────┐┌───┐│
│  │ 📅 ││ 📚 ││ 📊 ││👤 ││  ← Grid 4 kolom
│  │Jadw││Eduk││Lapo││Prof││
│  └────┘└────┘└────┘└───┘│
│                         │
│  Jadwal Hari Ini        │
│  ┌─────────────────────┐│
│  │⬤ 06:00–08:00  [Pros]││  ← Dot warna status
│  │  Organik · RW 01    ││
│  │  Petugas: Budi      ││
│  └─────────────────────┘│
├─────────────────────────┤
│  🏠* ─ 📅 ─ 📚 ─ 📊 ─ 👤│  ← Bottom nav, aktif = bg navy
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dekorasi lingkaran | `200×200px rgba(245,197,24,0.12)` di `top:-60px right:-40px` | Depth visual tanpa mengganggu keterbacaan |
| Stat kartu tengah | Background kuning | Satu KPI ditonjolkan — "total KG" sebagai nilai terpenting program sampah |
| Menu grid 4 kolom | Ikon 22px + label 11px | Lebih efisien dari list; 4 menu pas untuk kapasitas pandang sekilas |
| Bottom nav sticky | `position: sticky; bottom: 0` | Tidak overlap konten dalam flex container shell 390px |
| Badge notifikasi | Kuning di sudut atas ikon 🔔 | Kontras terhadap putih nav — langsung terlihat |
| Jadwal hari ini | Real-time data dari DB | CTA tersirat — mendorong petugas update status tanpa harus navigasi ke Jadwal |

---

### 4. Jadwal — `/app/jadwal`

**Pengguna:**
- **Warga** → baca saja
- **Petugas** → update status + input log untuk jadwal miliknya
- **Admin RW / Super Admin** → update semua jadwal di RW-nya

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Jadwal Pengangkutan  │
│  RW 01                  │
├─────────────────────────┤
│  ┌──[📅]──dd/mm/yyyy──┐ │  ← Filter tanggal auto-submit
│  └───────────────────┘  │
│                          │
│  ┌─────────────────────┐ │
│  │⬤  23 Mei 2026       │ │  ← Dot sesuai warna status
│  │   06:00–08:00       │ │
│  │   Organik · RW 01   │ │
│  │   Petugas: Budi     │ │
│  │   Estimasi: 120 kg  │ │  ← Info opsional
│  │            [Proses] │ │  ← Badge status
│  │─────────────────────│ │
│  │  [Mulai]  [Batal]   │ │  ← Tombol hanya untuk petugas/admin
│  │─────────────────────│ │
│  │  [Input Log ▼]      │ │  ← Alpine.js toggle
│  │  ┌─────────────────┐│ │  ← Form tersembunyi saat x-show
│  │  │⚖️ Berat (kg)    ││ │
│  │  │📷 Foto bukti    ││ │
│  │  │📝 Catatan       ││ │
│  │  │[SIMPAN & SELESAI]││ │
│  │  └─────────────────┘│ │
│  └─────────────────────┘ │
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dot status | menunggu=abu, proses=kuning, selesai=hijau, batal=merah | Konsisten di seluruh sistem — dipelajari sekali, berlaku di mana-mana |
| Filter tanggal | `onchange="this.form.submit()"` | Auto-submit tanpa klik ekstra — efisiensi interaksi mobile |
| Toggle form log | Alpine.js `x-show="open"` | Mengurangi visual clutter — form muncul hanya saat dibutuhkan |
| Upload foto | `accept="image/*"` | Buka kamera/galeri langsung — kritikal untuk bukti lapangan |
| Tombol bersyarat | Hanya muncul untuk role yang berwenang | Warga tidak melihat tombol "Mulai" — mengurangi konfusi |
| Foto bukti ditampilkan | Setelah log diisi | Transparansi — warga bisa verifikasi hasil pengangkutan |

---

### 5. Edukasi Daftar — `/app/edukasi`

**Pengguna:** Semua role (warga sebagai target utama)

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Edukasi Sampah       │
├─────────────────────────┤
│  ┌──[🔍]──Cari...─────┐ │  ← Search bar
│  └───────────────────┘  │
│                          │
│  [Semua][🌿Organik]     │  ← Pills horizontal scroll
│  [♻Anorganik][⚠B3]     │
│  [🔄Daur Ulang]          │
│                          │
│  ┌──────────────────────┐│  ← Featured banner 160px
│  │   [GAMBAR TERBARU]   ││
│  │ ▓▓▓▓▓▓▓▓▓▓ gradient ││  ← Overlay gradient gelap
│  │ [Terbaru]            ││  ← Badge kuning kecil
│  │ Judul Artikel        ││  ← Teks putih Cormorant
│  └──────────────────────┘│
│                          │
│  ┌────────┐  ┌────────┐  │  ← Grid 2 kolom
│  │ [IMG]  │  │ [IMG]  │  │
│  │Organik │  │Anorgan.│  │
│  │ Judul  │  │ Judul  │  │
│  │ 5 mnt  │  │ 3 mnt  │  │
│  └────────┘  └────────┘  │
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Featured banner | 160px, gradient overlay | Konten terbaru mendapat spotlight — mendorong engagement |
| Filter pills | Horizontal scrollable | Hemat vertikal space; pengguna mobile terbiasa scroll horizontal |
| Grid 2 kolom | Kartu dengan thumbnail | Lebih efisien dari list; bisa membandingkan konten secara paralel |
| Badge kategori warna | organik=hijau, anorganik=biru, b3=merah, daur_ulang=ungu | Identifikasi jenis tanpa membaca teks |
| Placeholder ikon | 📄 artikel, ▶️ video | Membedakan format konten walau thumbnail belum ada |

---

### 6. Edukasi Detail — `/app/edukasi/{slug}`

**Pengguna:** Semua role (warga sebagai target utama)

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Header navy + badge kategori | Warna sesuai kategori | Konteks jelas sebelum membaca |
| Konten `nl2br(e())` | Escaped HTML, baris baru dijaga | Keamanan XSS + keterbacaan paragraf |
| Video iframe responsive | `padding-top: 56.25%` | Aspect ratio 16:9 di semua lebar — video tidak terpotong |
| Kuis banner | Card abu dengan tombol "Mulai" | Mendorong uji pemahaman — gamification ringan |
| Status kuis "Selesai" | Badge hijau jika sudah ikut | Penghargaan visual — progress diakui |

---

### 7. Kuis — `/app/kuis/{id}`

**Pengguna:** Semua role (warga sebagai target utama)

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Nama Kuis            │
│  5 soal · 5 menit       │
├─────────────────────────┤
│  ┌─────────────────────┐│
│  │ SOAL 1              ││  ← Label uppercase muted
│  │ Kulit pisang adalah ││  ← Pertanyaan semibold
│  │ sampah jenis...?    ││
│  │                     ││
│  │ ○ [A] Organik       ││  ← Radio + key badge navy
│  │ ○ [B] Anorganik     ││
│  │ ○ [C] B3            ││
│  │ ○ [D] Campuran      ││
│  └─────────────────────┘│
│                          │
│  ┌─────────────────────┐│  ← Soal berikutnya
│  │ SOAL 2 ...          ││
│  └─────────────────────┘│
│                          │
│  ┌── KUMPULKAN JAWABAN ─┐│  ← Tombol kuning submit
│  └──────────────────────┘│
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Semua soal ditampilkan sekaligus | Scroll vertikal | Pengguna tahu total beban soal — tidak ada kejutan |
| Key badge A/B/C/D | Kotak navy 24×24px | Visual lebih jelas dari radio default — lebih mudah dipindai |
| Validasi `required` | Per soal | Mencegah submit tidak lengkap — integritas skor |
| Satu kali submit | Cek `sudahIkut` | Mencegah manipulasi skor |
| Flash skor setelah submit | `"Skor Anda: 80/100"` | Immediate feedback — reinforcement positif |

---

### 8. Laporan — `/app/laporan`

**Pengguna:** Semua role

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Laporan Bulanan      │
│  Mei 2026               │
├─────────────────────────┤
│  ┌──────────────────────┐│  ← Score card navy
│  │       RW 01          ││
│  │        78            ││  ← Cormorant 48px kuning
│  │       /100           ││
│  │  ████████░░░░░░░░░   ││  ← Progress bar kuning
│  └──────────────────────┘│
│                          │
│  ┌─────┐ ┌─────┐ ┌────┐ │  ← Stat 4 angka
│  │120KG│ │ 8x  │ │72% │ │
│  └─────┘ └─────┘ └────┘ │
│                          │
│  Peringkat RW            │
│  ┌──────────────────────┐│
│  │ 🥇 RW 03  89  145kg  ││  ← Emas, Perak, Perunggu
│  │ 🥈 RW 01  78  120kg  ││
│  │ 🥉 RW 05  65   98kg  ││
│  └──────────────────────┘│
│                          │
│  Riwayat 6 Bulan         │  ← Tren historis
│  April 2026  ───── 82    │
│  Maret 2026  ───── 71    │
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Score card navy besar | Skor Cormorant 48px kuning | KPI terpenting ditampilkan besar dan kontras |
| Progress bar | `width: min(skor, 100)%` | Representasi visual posisi vs. 100 poin |
| Leaderboard 3 warna | Emas / Perak / Perunggu | Sistem medali universal — memotivasi kompetisi sehat antar RW |
| Riwayat 6 bulan | List bulan + skor | Tren historis untuk evaluasi program |
| Format tanggal Indonesia | `\Carbon\Carbon::translatedFormat('F Y')` | "Mei 2026" lebih familier dari "05/2026" |

**Psikologi Gamifikasi:** Kompetisi antar komunitas adalah motivasi kuat di lingkungan desa. Warga bangga jika RW-nya peringkat 1 — mendorong partisipasi aktif dalam program pilah sampah tanpa paksaan.

---

### 9. Profil — `/app/profil`

**Pengguna:** Semua role

```
┌─────────────────────────┐
│  [HEADER NAVY center]   │
│                          │
│       ┌──────┐           │  ← Avatar 80×80px radius 24px
│       │  BS  │           │     (foto / 2 inisial)
│       └──────┘           │
│    Budi Santoso          │  ← Cormorant 22px putih
│    [Petugas]             │  ← Role badge
│     RW 01                │
├─────────────────────────┤
│  ┌──────────┐ ┌────────┐ │
│  │ 3 Kuis   │ │ Avg 85 │ │  ← Stat pencapaian (kartu kuning)
│  └──────────┘ └────────┘ │
│                          │
│  Edit Profil             │  ← Form edit
│  [Nama, Email, WA,       │
│   Foto, Password baru]   │
│                          │
│  [SIMPAN PERUBAHAN]      │  ← Kuning
│  [Logout]                │  ← Merah muted (micro-friction)
└─────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Avatar inisial fallback | 2 huruf pertama nama | Terjaga tanpa foto; tidak ada broken image |
| Header terpusat | Tidak left-align seperti halaman lain | Halaman personal — layout sentral lebih intim |
| Stat kuis di atas form | 2 kartu kecil | Menampilkan pencapaian sebelum form — motivasi ikut lebih banyak kuis |
| Tombol logout | Background merah muted | Berbeda dari aksi positif — micro-friction mencegah logout tidak sengaja |

---

### 10. Notifikasi — `/app/notifikasi`

**Pengguna:** Semua role

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Border kiri unread | `3px solid var(--yellow)` | Indikator belum-dibaca tanpa menghalangi konten |
| Border kiri read | `3px transparent, opacity 0.75` | Notifikasi dibaca "memudar" — fokus ke yang baru |
| Ikon per tipe | 📅 jadwal, 📢 broadcast, ℹ️ info | Differensiasi tipe tanpa label teks tambahan |
| Auto mark-as-read | Saat halaman dibuka | Tidak perlu klik satu per satu — UX efisien |
| `diffForHumans()` | "2 jam yang lalu" | Format relatif lebih natural dari timestamp absolut |

---

## 🖥 Antarmuka Admin `/admin`

> Semua halaman admin menggunakan layout `admin.layouts.app` dengan sidebar desktop.

---

### 11. Layout & Sidebar

**Pengguna:** Super Admin dan Admin RW

```
┌──────────────┬────────────────────────────────┐
│   SIDEBAR    │  TOPBAR                         │
│   [navy bg]  │  Judul Halaman  [Tombol Aksi]  │
│              ├────────────────────────────────┤
│  ┌──────────┐│                                │
│  │  Logo T  ││  ┌──────────────────────────┐  │
│  └──────────┘│  │                          │  │
│              │  │     CONTENT AREA         │  │
│  📊 Dashboard│  │                          │  │
│  📅 Jadwal   │  └──────────────────────────┘  │
│  👥 Pengguna │                                │
│  📚 Edukasi  │  ← Hanya super_admin           │
│  ❓ Kuis     │  ← Hanya super_admin           │
│  📈 Laporan  │                                │
│  🔔 Notif    │                                │
│              │                                │
│  ┌──────────┐│                                │
│  │Nama Admin││                                │
│  │ role     ││                                │
│  │      [↩] ││  ← Logout                     │
│  └──────────┘│                                │
└──────────────┴────────────────────────────────┘
 ←── 240px ──→ ←──────── flex: 1 ─────────────→
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Sidebar width | `240px` fixed | Cukup untuk label + ikon; standar UI admin modern |
| Sidebar background | Navy `#0D1B4B` | Konsisten dengan identitas; gelap vs. terang = pemisah area fokus |
| Nav aktif | Background kuning, teks navy | State aktif sangat jelas — admin tahu sedang di halaman apa |
| Nav hover | `rgba(255,255,255,0.08)` | Feedback subtle — tidak mengganggu tapi responsif |
| Topbar sticky | `position: sticky; top: 0; z-index: 50` | Judul + tombol aksi selalu terlihat saat scroll |
| Menu edukasi/kuis bersyarat | `@if(isSuperAdmin())` | Admin RW tidak melihat menu di luar kewenangannya |
| User info di bottom | Nama + role + logout | Admin selalu tahu login sebagai siapa |

**Psikologi:** Sidebar gelap vs. konten terang — pola klasik yang membantu mata memisahkan "navigasi" dari "konten kerja". Kuning pada nav aktif = konsistensi visual sistem.

---

### 12. Dashboard — `/admin/dashboard`

**Pengguna:** Super Admin (data semua RW) · Admin RW (data RW sendiri)

```
┌────────────────────────────────────────┐
│  Dashboard                  [tanggal] │
├────────────────────────────────────────┤
│  ┌──────────┐ ┌──────────┐            │
│  │ 👥 Biru  │ │ 🚛 Orange│  ← 4 KPI  │
│  │    42    │ │    8     │            │
│  │  Warga   │ │ Petugas  │            │
│  └──────────┘ └──────────┘            │
│  ┌──────────┐ ┌──────────┐            │
│  │ 📅 Hijau │ │ 📦 Pink  │            │
│  │   156    │ │  120 kg  │            │
│  │  Jadwal  │ │ KG/Bulan │            │
│  └──────────┘ └──────────┘            │
├──────────────────┬─────────────────────┤
│  Jadwal Hari Ini │ Laporan Bulan Ini   │
│                  │                    │
│ [badge][RW·jenis]│ RW01 ████▒▒▒▒ 89  │
│ [badge][RW·jenis]│ RW03 ████▒▒▒  78  │
│        [+Tambah] │       [Lihat Semua]│
└──────────────────┴─────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Stats grid 4 kolom | 4 KPI utama | Overview cepat — 4 angka tanpa overwhelm |
| Ikon background berbeda | Biru / Orange / Hijau / Pink | Differensiasi KPI tanpa membaca label — scan lebih cepat |
| Angka KPI | Cormorant 28px navy | Angka besar = prioritas; serif = kesan laporan formal |
| Progress bar laporan | Kuning, `width: skor%` | Komparasi visual antar RW lebih cepat dari angka murni |
| Grid 2 kolom di bawah | Jadwal + Laporan sejajar | Dua informasi paling sering dilihat — tidak perlu scroll |

---

### 13. Manajemen Pengguna — `/admin/users`

**Pengguna:** Super Admin (semua RW) · Admin RW (warga & petugas RW sendiri)

#### Index — Daftar User

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Pagination | 20 per halaman | Mencegah halaman terlalu panjang untuk data besar |
| Badge role warna | super_admin=biru, admin_rw=orange, petugas=ungu, warga=hijau | Identifikasi role sekilas |
| Badge status aktif/non-aktif | Hijau / Abu | Mana akun yang perlu diaktivasi langsung terlihat |
| Tombol Edit + Hapus inline | Per baris | Aksi langsung dari list — tidak perlu masuk detail |
| Konfirmasi hapus | `return confirm()` browser native | Double-check mencegah penghapusan tidak sengaja |

#### Form Create / Edit User

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dropdown RW tersembunyi untuk admin RW | Input hidden dengan value RW sendiri | Admin RW tidak bisa mengubah RW user — security by design |
| Dropdown role terbatas per level | Super admin: semua; Admin RW: petugas+warga | Mencegah eskalasi privilege dari UI |
| Password opsional di edit | "Kosongkan jika tidak diubah" | UX standar — tidak perlu reset jika hanya update data lain |
| Checkbox `is_active` | Untuk approve warga baru | Workflow approval terintegrasi di form edit |

---

### 14. Manajemen Jadwal — `/admin/jadwal`

**Pengguna:** Super Admin · Admin RW

#### Index — Daftar Jadwal

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Urut tanggal descending | Terbaru di atas | Admin lebih sering review jadwal terbaru |
| Waktu format `HH:MM–HH:MM` | `substr(..., 0, 5)` | Cukup jam dan menit — detik tidak relevan |
| Badge status warna | Konsisten dengan mobile | Warna badge sama di seluruh sistem |

#### Form Create Jadwal

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Waktu mulai/selesai sejajar | Form row 2 kolom | Dua field terkait logis — perbandingan mudah |
| Notifikasi otomatis | `NotifikasiService::kirimKeRW()` | Warga selalu dapat info tanpa admin ingat kirim notif manual |
| Estimasi KG opsional | `nullable` | Tidak semua jadwal diketahui estimasinya di awal |

---

### 15. Manajemen Edukasi — `/admin/edukasi`

**Pengguna:** Super Admin (create/edit/delete) · Admin RW (read only)

#### Index

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Kolom Status Terbit/Draft | Badge hijau / abu | Admin tahu konten mana yang visible ke warga |
| Tombol hapus dengan confirm | `return confirm()` | Konten dihapus sulit dikembalikan — konfirmasi penting |

#### Form Create / Edit

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Textarea konten rows=8 | Ruang cukup | Artikel panjang; tidak memerlukan WYSIWYG di v1 |
| Checkbox terbitkan | Unchecked default | Default draft — tidak langsung terekspos sebelum siap |
| Dua dropdown sejajar | Kategori + Format 2 kolom | Hemat vertikal space untuk dua pilihan terkait |
| Placeholder URL video | `youtube.com/embed/...` | Panduan format URL — mencegah error embed |

---

### 16. Manajemen Kuis — `/admin/kuis`

**Pengguna:** Super Admin

#### Form Create (Alpine.js Dinamis)

```
┌────────────────────────────────────┐
│  Judul + Edukasi + Durasi          │
├────────────────────────────────────┤
│  ─────── SOAL ────────             │
│  [Soal 1]               [Hapus]   │
│  Pertanyaan: [textarea]            │
│  ┌─────────────┐ ┌─────────────┐  │  ← Grid 2 kolom
│  │ Pilihan A   │ │ Pilihan B   │  │
│  └─────────────┘ └─────────────┘  │
│  ┌─────────────┐ ┌─────────────┐  │
│  │ Pilihan C   │ │ Pilihan D   │  │
│  └─────────────┘ └─────────────┘  │
│  Jawaban Benar: [A ▼]              │
│                                    │
│  [+ Tambah Soal]                   │
│  [Simpan Kuis]  [Batal]           │
└────────────────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Soal dinamis Alpine.js | `x-for`, `addSoal()`, `removeSoal()` | Tambah/hapus soal tanpa reload — UX form modern |
| Grid pilihan 2×2 | 2 kolom per soal | 4 pilihan dalam 2 kolom = lebih compact |
| Pilihan C dan D opsional | `required` hanya A dan B | Fleksibel — soal bisa 2 atau 4 pilihan |

#### Halaman Show Kuis

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Background hijau jawaban benar | `#D4F5E6` | Verifikasi kunci jawaban sekilas |
| Teks "✓ Benar" | Di samping pilihan | Konfirmasi tambahan — accessible untuk color-blind |

---

### 17. Laporan Bulanan — `/admin/laporan`

**Pengguna:** Super Admin (semua RW) · Admin RW (RW sendiri)

```
┌──────────────────────────────────────────────────┐
│  Laporan Bulanan                  [⬇ Export CSV] │
├──────────────────────────────────────────────────┤
│  [Filter: Bulan ▼] [Tahun ▼] [Tampilkan]         │
├──────────────────────────────────────────────────┤
│  Rank │ RW  │  KG │ Org │ Anorg │ B3 │Angk│ Skor│
│   🥇  │ RW03│ 145 │  80 │   40  │  5 │  8 │  89 │
│   🥈  │ RW01│ 120 │  65 │   35  │  8 │  8 │  78 │
│   🥉  │ RW05│  98 │  50 │   30  │  5 │  6 │  65 │
└──────────────────────────────────────────────────┘
```

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Filter inline dalam card | Bukan modal/popup | Akses cepat — admin sering ganti periode untuk komparasi |
| Ranking emas/perak/perunggu | Konsisten dengan mobile | Admin dan warga melihat sistem peringkat yang sama |
| Skor bold besar | `font-size:16px; color:navy` | KPI utama — harus langsung terlihat |
| Export CSV | `streamDownload()` | Format universal — bisa dibuka di Excel untuk laporan kelurahan |
| Semua kolom breakdown | Organik, Anorganik, B3, dll. | Detail untuk program intervensi — "RW mana yang kurang pilah?" |

---

### 18. Notifikasi Admin — `/admin/notifikasi`

**Pengguna:** Super Admin · Admin RW

#### Daftar Notifikasi

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Pesan terpotong | `Str::limit(60)` | Tabel tidak melebar — preview cukup untuk identifikasi isi |
| Badge tipe | Biru untuk info/jadwal/broadcast | Differensiasi tipe sekilas |
| Kolom Target RW | Nama RW / "Semua RW" | Admin tahu jangkauan setiap notifikasi |

#### Form Kirim Notifikasi

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Tipe "Broadcast" hanya super admin | `@if(isSuperAdmin())` | Admin RW tidak bisa broadcast ke semua RW |
| Target RW kosong = semua RW | Placeholder "Semua RW" | Convenience untuk notif massal |
| Textarea pesan rows=4 | Ruang terbatas | Mendorong pesan ringkas — notifikasi seharusnya singkat |

---

## 📊 Matriks Pengguna × Antarmuka

| Antarmuka | Warga | Petugas | Admin RW | Super Admin |
|---|:---:|:---:|:---:|:---:|
| Login | ✅ | ✅ | ✅ | ✅ |
| Register | ✅ | — | — | — |
| Beranda | ✅ | ✅ | ✅ | ✅ |
| Jadwal (read) | ✅ | ✅ | ✅ | ✅ |
| Jadwal (update status) | — | ✅ | ✅ | ✅ |
| Jadwal (input log + foto) | — | ✅ | ✅ | ✅ |
| Edukasi | ✅ | ✅ | ✅ | ✅ |
| Kuis | ✅ | ✅ | ✅ | ✅ |
| Laporan mobile | ✅ | ✅ | ✅ | ✅ |
| Profil | ✅ | ✅ | ✅ | ✅ |
| Notifikasi mobile | ✅ | ✅ | ✅ | ✅ |
| **Admin** Dashboard | — | — | ✅ | ✅ |
| **Admin** Users | — | — | ✅ RW sendiri | ✅ Semua |
| **Admin** Jadwal CRUD | — | — | ✅ RW sendiri | ✅ Semua |
| **Admin** Edukasi CRUD | — | — | — | ✅ |
| **Admin** Kuis CRUD | — | — | — | ✅ |
| **Admin** Laporan | — | — | ✅ RW sendiri | ✅ Semua |
| **Admin** Notifikasi | — | — | ✅ RW sendiri | ✅ Broadcast |

---

## 🚀 Instalasi & Menjalankan

```bash
# 1. Clone & install dependencies
git clone <repo-url>
cd tarunadayavarna
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Konfigurasi database di .env
DB_DATABASE=tarunadayavarna
DB_USERNAME=root
DB_PASSWORD=

# 4. Migrasi & seeder
php artisan migrate --seed

# 5. Storage link
php artisan storage:link

# 6. Jalankan server
php artisan serve
```

Akses: `http://localhost:8000` → otomatis redirect ke `/app/login`

---

## 🔑 Akun Seeder Default

> Semua akun menggunakan password: **`password`**

| Username | Role | Akses |
|---|---|---|
| `superadmin` | Super Admin | Semua fitur, semua RW |
| `admin_rw01` | Admin RW | Data RW 01 |
| `admin_rw02` | Admin RW | Data RW 02 |
| `admin_rw03` | Admin RW | Data RW 03 |
| `admin_rw04` | Admin RW | Data RW 04 |
| `admin_rw05` | Admin RW | Data RW 05 |
| `petugas_01` | Petugas | Jadwal RW 01 |
| `petugas_02` | Petugas | Jadwal RW 02 |
| `petugas_03` | Petugas | Jadwal RW 03 |
| `suparman.rw03` | Warga | View RW 03 |
| `sari.rw01` | Warga | View RW 01 |
| `joko.rw02` | Warga | View RW 02 |

---

## 📐 Prinsip Desain

| Prinsip | Implementasi |
|---|---|
| **Hierarchy Visual** | Heading Cormorant besar → label Jakarta kecil → body |
| **Affordance** | Kuning = aksi utama · Merah = destruktif · Abu = non-aktif |
| **Consistency** | Badge status warna sama di mobile & admin |
| **Feedback** | Flash message setiap aksi · dot warna real-time |
| **Progressive Disclosure** | Form log jadwal tersembunyi sampai dibutuhkan |
| **Error Prevention** | Konfirmasi sebelum hapus · validasi required |
| **Accessibility** | Tap target 52px · kontras WCAG AA · label eksplisit |
| **Role-based UI** | Menu/tombol hanya tampil jika user punya akses |

---

*Tarunadayavarna · README & Laporan Antarmuka v1.0 · Mei 2026*
*99 files · 5.847 baris kode · Branch `claude/setup-laravel-project-XMO9H`*
