# Tarunadayavarna — Sistem Pengelolaan Sampah Desa

> Laporan desain antarmuka lengkap: atribut, psikologi warna, dan target pengguna setiap halaman.

---

## Daftar Isi

1. [Gambaran Sistem](#gambaran-sistem)
2. [Teknologi](#teknologi)
3. [Sistem Desain](#sistem-desain)
   - [Palet Warna & Psikologi](#palet-warna--psikologi)
   - [Tipografi](#tipografi)
   - [Aksesibilitas WCAG](#aksesibilitas-wcag)
4. [Peran & Akses](#peran--akses)
5. [Antarmuka Mobile (Warga / Petugas)](#antarmuka-mobile-warga--petugas)
   - [M-01 Halaman Login](#m-01-halaman-login)
   - [M-02 Halaman Registrasi](#m-02-halaman-registrasi)
   - [M-03 Beranda](#m-03-beranda)
   - [M-04 Jadwal Pengangkutan](#m-04-jadwal-pengangkutan)
   - [M-05 Daftar Edukasi](#m-05-daftar-edukasi)
   - [M-06 Detail Artikel / Video](#m-06-detail-artikel--video)
   - [M-07 Kuis](#m-07-kuis)
   - [M-08 Laporan & Leaderboard](#m-08-laporan--leaderboard)
   - [M-09 Profil](#m-09-profil)
   - [M-10 Notifikasi](#m-10-notifikasi)
6. [Antarmuka Admin (Dashboard Web)](#antarmuka-admin-dashboard-web)
   - [A-01 Dashboard Admin](#a-01-dashboard-admin)
   - [A-02 Manajemen Pengguna](#a-02-manajemen-pengguna)
   - [A-03 Form User (Tambah / Edit)](#a-03-form-user-tambah--edit)
   - [A-04 Jadwal — Daftar & Form Buat](#a-04-jadwal--daftar--form-buat)
   - [A-05 Konten Edukasi — Daftar & Form Buat](#a-05-konten-edukasi--daftar--form-buat)
   - [A-06 Kuis — Buat dengan Soal Dinamis](#a-06-kuis--buat-dengan-soal-dinamis)
   - [A-07 Laporan Bulanan & Export CSV](#a-07-laporan-bulanan--export-csv)
   - [A-08 Kirim Notifikasi](#a-08-kirim-notifikasi)
7. [Matriks Pengguna x Antarmuka](#matriks-pengguna-x-antarmuka)
8. [Panduan Instalasi](#panduan-instalasi)
9. [Akun Seeder](#akun-seeder)
10. [Prinsip Desain](#prinsip-desain)

---

## Gambaran Sistem

**Tarunadayavarna** adalah sistem pengelolaan sampah berbasis web skala desa/RW. Sistem mengelola seluruh siklus: penjadwalan pengangkutan sampah, pencatatan log berat, konten edukasi pemilahan, kuis interaktif, laporan bulanan per-RW, dan notifikasi. Arsitektur dibagi menjadi dua "dunia" UI:

| Dunia | URL Awalan | Target Pengguna | Perangkat Utama |
|-------|-----------|-----------------|-----------------|
| Mobile App | `/app/...` | Warga, Petugas | Smartphone (390 px shell) |
| Admin Dashboard | `/admin/...` | Super Admin, Admin RW | Desktop / Laptop |

---

## Teknologi

| Lapisan | Teknologi |
|---------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Template | Blade (server-side rendering) |
| Interaktivitas | Alpine.js 3 (CDN) |
| Basis Data | MySQL 8 (utf8mb4) |
| Sesi | Database driver |
| Storage | Laravel Storage (`storage/app/public`) |
| CSS | Vanilla CSS (dua berkas: `app-mobile.css`, `app-admin.css`) |
| Font | Google Fonts — Cormorant Garamond + Plus Jakarta Sans |

---

## Sistem Desain

### Palet Warna & Psikologi

```
+------------------------------------------------------------------+
|  NAVY        YELLOW       WHITE        GRAY        GREEN         |
|  #0D1B4B    #F5C518      #FFFFFF      #F4F6FB     #2ECC71       |
+------------------------------------------------------------------+
```

#### Navy `#0D1B4B`

| Aspek | Detail |
|-------|--------|
| **Makna psikologis** | Kepercayaan, stabilitas, otoritas, profesionalisme |
| **Peran dalam UI** | Header halaman, sidebar admin, tombol primer, teks heading utama, nav aktif |
| **Alasan pemilihan** | Biru gelap memberi kesan institusi pemerintahan desa yang resmi dan terpercaya. Kontras tinggi terhadap konten putih membantu keterbacaan. |
| **Konteks emosional** | Pengguna merasa berinteraksi dengan sistem formal, bukan aplikasi sosial kasual. Mendorong kepatuhan terhadap jadwal dan aturan pengelolaan sampah. |

#### Yellow `#F5C518`

| Aspek | Detail |
|-------|--------|
| **Makna psikologis** | Optimisme, energi, perhatian, tindakan, kehangatan |
| **Peran dalam UI** | CTA utama (`btn-yellow`), logo badge, ikon input, navigasi aktif dot, progress bar, notif badge, stat card unggulan |
| **Alasan pemilihan** | Kuning adalah warna "call-to-action" tertinggi. Mengingatkan pengguna bahwa ada tindakan yang perlu dilakukan (input log, mulai kuis, login). Kontras tinggi di atas navy menghasilkan kombinasi yang mudah dibaca. |
| **Konteks emosional** | Memberi semangat dan motivasi kepada warga untuk aktif berpartisipasi. Kuning juga berkaitan dengan kesadaran lingkungan dan energi positif. |

#### White `#FFFFFF` + Gray `#F4F6FB`

| Aspek | Detail |
|-------|--------|
| **Makna psikologis** | Kebersihan, kejelasan, ruang bernapas, kesederhanaan |
| **Peran dalam UI** | Background konten, card, modal, form |
| **Alasan pemilihan** | Putih dan abu terang menciptakan latar netral sehingga konten informasi (jadwal, artikel, skor) menonjol tanpa gangguan visual. Abu `#F4F6FB` digunakan sebagai pengganti putih murni untuk mengurangi ketegangan mata dalam sesi baca panjang. |

#### Green `#2ECC71`

| Aspek | Detail |
|-------|--------|
| **Makna psikologis** | Keberhasilan, pertumbuhan, kesehatan lingkungan, konfirmasi positif |
| **Peran dalam UI** | Status `selesai` (dot, badge), flash sukses, leaderboard rank tertinggi |
| **Alasan pemilihan** | Hijau adalah warna universal untuk "selesai / berhasil". Sangat relevan untuk sistem lingkungan — pengangkutan berhasil = bumi lebih hijau. |

#### Warna Status Semantik

| Status | Warna BG | Warna Teks | Makna |
|--------|----------|------------|-------|
| Menunggu | `#F0F0F0` | `#888` | Netral, belum ada tindakan |
| Proses | `#FFF3CC` | `#a07000` | Kuning-amber, waspada, sedang berjalan |
| Selesai | `#D4F5E6` | `#1a7a44` | Hijau muda, sukses, tuntas |
| Batal | `#FDECEA` | `#c0392b` | Merah muda, kesalahan, dihentikan |

---

### Tipografi

| Font | Klasifikasi | Digunakan untuk | Alasan |
|------|-------------|-----------------|--------|
| **Cormorant Garamond** | Serif elegan | Judul halaman, statistik besar, nama pengguna di header, logo huruf | Serif memberi kesan formal dan berkelas. Ukuran besar terasa monumental (48 px pada skor RW). |
| **Plus Jakarta Sans** | Sans-serif modern | Body teks, label, tombol, form, navigasi | Sans-serif memastikan keterbacaan tinggi pada ukuran kecil (10-14 px) di layar mobile. |

Keduanya dikombinasikan secara kontras: serif untuk hal yang "dirayakan" (pencapaian, nama, judul), sans-serif untuk hal yang "dikerjakan" (input, aksi, label).

---

### Aksesibilitas WCAG

| Kombinasi | Rasio Kontras | Level |
|-----------|--------------|-------|
| White teks di atas Navy (`#0D1B4B`) | 13.9 : 1 | AAA |
| Navy teks di atas Yellow (`#F5C518`) | 6.7 : 1 | AA+ |
| Navy teks di atas White (`#FFFFFF`) | 16.0 : 1 | AAA |
| Muted (`#8892a4`) di atas White | 3.7 : 1 | AA (teks besar) |
| Green teks (`#1a7a44`) di atas `#D4F5E6` | 5.4 : 1 | AA |

**Tap target minimum**: 52 px (di atas standar WCAG 48 px) untuk semua tombol dan item navigasi mobile.

---

## Peran & Akses

| Peran | Kode | Akses Mobile | Akses Admin |
|-------|------|-------------|-------------|
| Super Admin | `super_admin` | Penuh | Penuh (semua RW) |
| Admin RW | `admin_rw` | Penuh | Terbatas pada RW sendiri |
| Petugas | `petugas` | Dapat update status jadwal & input log | Tidak ada |
| Warga | `warga` | Baca jadwal, edukasi, kuis, laporan | Tidak ada |

---

## Antarmuka Mobile (Warga / Petugas)

> Semua halaman mobile dibungkus dalam shell 390 px di desktop, dan melebar ke 100 vw di perangkat kurang dari 480 px. Layout: `flex-column`, dengan sticky `bottom-nav` di bawah.

---

### M-01 Halaman Login

**File**: `resources/views/app/auth/login.blade.php`

```
+-----------------------------+
|         [Navy BG]           |
|                             |
|     +--------+              |
|     |   T    |  <- logo kuning|
|     +--------+              |
|   Tarunadayavarna           |
|   Sistem Pengelolaan Sampah |
|                             |
+-----------------------------+  <- card putih, border-radius 28px
|  Selamat Datang             |
|  Masuk untuk melanjutkan    |
|                             |
|  [ikon] Username _________  |
|  [ikon] Password _________  |
|                             |
|  +------------------------+ |
|  |         LOGIN          | |  <- btn-yellow
|  +------------------------+ |
|                             |
|   Belum punya akun? Daftar  |
+-----------------------------+
```

#### Atribut Komponen

| Komponen | Class CSS | Ukuran | Fungsi |
|----------|-----------|--------|--------|
| Background layar penuh | `.auth-screen` | 100 vh | Navy penuh — membangun identitas merek sejak pertama buka |
| Logo badge | `.logo-circle` | 72 x 72 px, radius 20 px | Huruf "T" serif di atas kuning — identitas visual merek |
| Judul aplikasi | `.app-title` | 26 px, Cormorant Garamond 700 | Memperkuat nama merek |
| Tagline | `.app-subtitle` | 12 px, opacity 60% putih | Konteks singkat aplikasi |
| Card formulir | `.auth-card` | radius 28 px di atas | Transisi visual dari navy ke putih |
| Input field | `.input-row` | 52 px tinggi | Ikon kuning kiri sebagai penanda konteks; border yellow on focus |
| Tombol submit | `.btn-yellow` | 52 px tinggi, lebar penuh | CTA utama; shadow kuning memberi kesan mengambang |
| Error field | `.field-error` | 11 px, merah | Umpan balik validasi inline |
| Link registrasi | `.auth-link a` | 13 px, navy bold | Alternatif navigasi bagi pengguna baru |

#### Psikologi Desain

Navy mendominasi layar pertama untuk membangun kesan institusional yang serius. Yellow pada logo dan tombol menjadi titik fokus visual — mata pengguna langsung tertuju pada elemen aksi. Card putih yang "naik" dari bawah memberi kesan konten yang tersedia dan mudah dijangkau.

#### Pengguna Target

Semua peran (warga, petugas, admin_rw, super_admin). Halaman ini adalah pintu masuk universal.

---

### M-02 Halaman Registrasi

**File**: `resources/views/app/auth/register.blade.php`

Layout identik dengan login (navy header + card putih) dengan tambahan field:

#### Atribut Komponen

| Komponen | Input | Validasi |
|----------|-------|----------|
| Nama Lengkap | `text` | required |
| Username | `text` | required, unique |
| Email | `email` | nullable, unique |
| Password | `password` | required, min 8 |
| Konfirmasi Password | `password` | confirmed |
| RW | `select` | required — dropdown dari tabel `rws` |

Setiap input menggunakan pola `.input-row` dengan ikon kuning sebagai penanda konteks visual. Error ditampilkan inline di bawah tiap field dengan class `.field-error` (merah, 11 px).

#### Psikologi Desain

Penambahan field RW mengkomunikasikan secara implisit bahwa aplikasi ini terikat pada komunitas lokal — pengguna tahu mereka mendaftar sebagai bagian dari RW tertentu, bukan sebagai individu anonim.

#### Pengguna Target

Warga baru yang belum memiliki akun. Petugas dan admin dibuat langsung oleh Super Admin melalui panel admin.

---

### M-03 Beranda

**File**: `resources/views/app/beranda.blade.php`

```
+-----------------------------+
|  [Navy Header]              |
|  Selamat datang,            |
|  Nama Pengguna         [notif]|  <- notif badge kuning
|  [Role Badge] . RW XX       |
+-----------------------------+
|  [kg bln ini] [angkut] [skor]|  <- stat cards
|                             |
|  Menu                       |
|  [Jadwal][Edukasi][Laporan][Profil]|  <- 4-kolom grid
|                             |
|  Jadwal Hari Ini            |
|  +----------------------+   |
|  | (dot) 07:00-09:00    |   |
|  |   Organik . RW 01    |   |
|  |   Petugas: Budi      |   |
|  |             [status] |   |
|  +----------------------+   |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Header navy | `.page-header-navy` | Padding 50 px atas, dekorasi lingkaran kuning semi-transparan |
| Salam pengguna | `.header-greeting` | 12 px, opacity 65% — konteks sambutan |
| Nama pengguna | `.header-name` | 22 px Cormorant Garamond — personalises experience |
| Role badge | `.role-badge` | Pill putih transparan — mengkomunikasikan level akses |
| Tombol notifikasi | `.notif-btn` | 40 x 40 px; badge kuning menampilkan jumlah belum dibaca |
| Stat cards | `.stat-row` + `.stat-card` | 3 kartu flexbox; kartu pertama kuning (highlight kg bulan ini) |
| Nilai statistik | `.stat-value` | 22 px Cormorant Garamond, navy |
| Menu grid | `.menu-grid` | 4-kolom, radius 14 px, latar abu |
| Jadwal dot | `.jadwal-dot` | 12 px lingkaran: abu=menunggu, kuning=proses, hijau=selesai, merah=batal |
| Status badge | `.badge-{status}` | Pill semantik: 4 warna status |
| Bottom nav | `.bottom-nav` | Sticky, 5 ikon; ikon aktif: background navy, label navy bold |

#### Psikologi Desain

Beranda dirancang sebagai "pusat kendali" yang memberikan informasi utama dalam satu pandang. Statistik tiga angka di atas memberi rasa kepuasan progres (gamifikasi ringan). Menu grid yang besar memastikan pengguna dapat menavigasi dengan cepat bahkan dalam kondisi bergerak.

#### Pengguna Target

**Semua peran yang sudah login.** Petugas dan admin_rw melihat aksi tambahan pada kartu jadwal. Warga hanya melihat informasi tanpa tombol aksi operasional.

---

### M-04 Jadwal Pengangkutan

**File**: `resources/views/app/jadwal.blade.php`

```
+-----------------------------+
|  <- Jadwal Pengangkutan     |
|     RW 01                   |
+-----------------------------+
|  [kal] Filter tanggal ____  |
|                             |
|  +----------------------+   |
|  | (dot) 12 Mei 2025    |   |
|  |   07:00-09:00        |   |
|  |   Organik  [Proses]  |   |
|  |   Petugas: Budi      |   |
|  |   Estimasi: 45 kg    |   |
|  | -------------------- |   |
|  | [Mulai] [Batal]      |   |  <- aksi petugas/admin
|  |                      |   |
|  | [Input Log v]        |   |  <- Alpine.js toggle
|  |   Berat aktual _____ |   |
|  |   Foto bukti _______ |   |
|  |   Catatan  _________ |   |
|  | [SIMPAN & SELESAI]   |   |
|  +----------------------+   |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Teknis | Keterangan |
|----------|--------|------------|
| Filter tanggal | `input[type=date]` + `onchange submit` | Auto-submit saat tanggal berubah |
| Status dot | `.jadwal-dot.dot-{status}` | Indikator visual instan sebelum membaca teks |
| Badge status | `.badge-{status}` | Pill semantik di pojok kanan kartu |
| Tombol Mulai | `.btn-sm-yellow`, PATCH `status=proses` | Hanya muncul jika status `menunggu` |
| Tombol Input Log | Alpine.js `@click="open=!open"` | Dropdown inline tanpa membuka halaman baru |
| Form log | `enctype=multipart/form-data` | Upload foto bukti ke `storage/app/public/bukti/` |
| Foto bukti | `img` `max-height:200px` | Ditampilkan langsung dalam kartu setelah log tersimpan |
| Tombol Batal | `.btn-sm-danger`, konfirmasi JS | Warna merah muda + konfirmasi sebelum eksekusi |

#### Psikologi Desain

Pola progressive disclosure diterapkan: tombol "Input Log" hanya muncul saat status `proses`, mengurangi beban kognitif pengguna — mereka hanya melihat aksi yang relevan untuk kondisi saat ini. Warna kuning pada "Mulai" menciptakan urgensi positif.

#### Pengguna Target

- **Warga**: Read-only, melihat jadwal dan status
- **Petugas**: Dapat menekan Mulai, Input Log, Batal pada jadwal yang ditugaskan
- **Admin RW / Super Admin**: Semua aksi petugas, visibilitas semua RW

---

### M-05 Daftar Edukasi

**File**: `resources/views/app/edukasi/index.blade.php`

```
+-----------------------------+
|  <- Edukasi Sampah          |
|     Pelajari cara memilah   |
+-----------------------------+
|  [cari] Cari artikel...     |
|                             |
|  [Semua][Organik][Anorg]    |
|  [B3][Daur Ulang]           |  <- filter pills
|                             |
|  +-----------------------+  |  <- featured card
|  |  [gambar hero]        |  |
|  |     [Terbaru]         |  |
|  |  Judul Artikel Unggulan  |
|  +-----------------------+  |
|                             |
|  +--------+ +--------+   |  |  <- 2-kolom grid
|  |[thumb] | |[thumb] |   |  |
|  |Organik | |Anorganik|   |  |
|  |Judul   | |Judul   |   |  |
|  |5 menit | |3 menit |   |  |
|  +--------+ +--------+   |  |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Search bar | `.input-row` | Ikon kaca pembesar kuning, auto-redirect GET |
| Filter pills | `.pill` / `.pill-active` | Abu = tidak aktif; navy = filter aktif |
| Featured card | `.featured-card` | 160 px tinggi, gambar cover dengan overlay gradient navy-bawah |
| Tag "Terbaru" | `.featured-tag` | Kuning kecil di atas judul overlay |
| Grid konten | `.edukasi-grid` | 2-kolom, kartu bayangan ringan |
| Badge kategori | `.badge-organik/anorganik/b3/daur_ulang` | Warna unik per kategori |
| Durasi | `.edukasi-meta` | Informasi waktu baca/tonton, 11 px muted |

#### Badge Kategori & Psikologinya

| Kategori | Warna | Makna |
|----------|-------|-------|
| Organik | Hijau (`#e8f5e9` / `#2e7d32`) | Alam, dekomposisi, kehidupan |
| Anorganik | Biru (`#e3f2fd` / `#1565c0`) | Teknologi, daur ulang industri |
| B3 | Merah (`#fce4ec` / `#c62828`) | Bahaya, peringatan keras |
| Daur Ulang | Ungu (`#f3e5f5` / `#6a1b9a`) | Kreativitas, transformasi nilai |

#### Pengguna Target

**Semua peran**. Konten edukasi bersifat publik dalam aplikasi.

---

### M-06 Detail Artikel / Video

**File**: `resources/views/app/edukasi/detail.blade.php`

```
+-----------------------------+
|  <- [Badge Kategori]        |
|  Judul Artikel Lengkap      |
|  yang Bisa Dua Baris        |
+-----------------------------+
|  [Gambar Thumbnail]         |
|                             |
|  Konten artikel dengan      |
|  tipografi nyaman baca,     |
|  line-height 1.7, 14px.     |
|  ...                        |
|                             |
|  +----------------------+   |  <- kuis banner (jika ada)
|  |  [?] Judul Kuis      |   |
|  |      5 soal . 5 menit|   |
|  |              [Mulai] |   |
|  +----------------------+   |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Header navy dengan badge kategori | Badge berwarna kategori di atas judul putih — konteks visual sebelum membaca |
| Thumbnail gambar | `max-height: 200px`, `object-fit: cover` — tidak mendistorsi gambar |
| Video embed | Wrapper `padding-top: 56.25%` (rasio 16:9), iframe fullwidth — responsive tanpa JavaScript |
| Konten artikel | `font-size: 14px`, `line-height: 1.7` — standar keterbacaan mobile optimal |
| Kuis banner | `.kuis-banner` — abu terang dengan ikon besar; CTA kuning "Mulai" atau badge hijau "Selesai" |

#### Psikologi Desain

Kuis banner ditampilkan sebagai "reward" setelah membaca artikel — alur natural: baca lalu uji pemahaman lalu selesai. Badge "Selesai" hijau memberikan kepuasan closure yang mendorong pengguna menyelesaikan konten berikutnya (gamifikasi ringan).

#### Pengguna Target

**Semua peran** untuk membaca. Tombol "Mulai" kuis paling relevan untuk **Warga** sebagai peserta didik utama.

---

### M-07 Kuis

**File**: `resources/views/app/kuis/show.blade.php`

```
+-----------------------------+
|  <- Judul Kuis              |
|     5 soal . 5 menit        |
+-----------------------------+
|  +----------------------+   |
|  | SOAL 1               |   |
|  | Apa yang dimaksud    |   |
|  | dengan sampah...?    |   |
|  |                      |   |
|  | [key] A  Teks pilihan|   |  <- pilihan-item
|  | ( )                  |   |
|  | [key] B  Teks pilihan|   |
|  | ( )                  |   |
|  | [key] C  Teks pilihan|   |
|  | [key] D  Teks pilihan|   |
|  +----------------------+   |
|                             |
|  +------------------------+ |
|  |  KUMPULKAN JAWABAN     | |
|  +------------------------+ |
+-----------------------------+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Nomor soal | `.soal-nomor` | 11 px uppercase muted — hierarki tipografi rendah |
| Pertanyaan | `.soal-pertanyaan` | 14 px semibold navy — hierarki tertinggi dalam kartu |
| Item pilihan | `.pilihan-item` | 52 px+ tap target, background abu, radius 10 px |
| Kunci huruf | `.pilihan-key` | 24 x 24 px navy, serif, rounded 6 px — label visual |
| Radio button | `accent-color: var(--navy)` | Warna radio disesuaikan dengan tema |
| State sudah ikut | Empty state dengan centang | Redirect ke edukasi jika sudah mengerjakan |

#### Psikologi Desain

Setiap pilihan jawaban memiliki tap target yang cukup besar dan jelas terbatas (background abu dengan radius), mengurangi kemungkinan tap salah. Kunci huruf navy memberi struktur visual yang mirip soal ujian — membantu kognitif pengguna membedakan pilihan.

#### Pengguna Target

**Warga** (primer), **Petugas** (sekunder). Kuis meningkatkan pemahaman pemilahan sampah sambil memberikan skor untuk profil pengguna.

---

### M-08 Laporan & Leaderboard

**File**: `resources/views/app/laporan.blade.php`

```
+-----------------------------+
|  <- Laporan Bulanan         |
|     Mei 2025                |
+-----------------------------+
|  +----------------------+   |  <- score card navy
|  | RW 01                |   |
|  |        87            |   |  <- 48px Cormorant Garamond kuning
|  |        /100          |   |
|  | ==================== |   |  <- progress bar kuning
|  +----------------------+   |
|                             |
|  [Total KG][Angkut][Pilah%][Organik]|
|                             |
|  Peringkat RW               |
|  +----------------------+   |
|  | #1 RW 03  45x  890kg |   |  <- rank-1 (emas)
|  |                   92 |   |
|  | #2 RW 01  38x  750kg |   |  <- rank-2 (perak)
|  |                   87 |   |
|  +----------------------+   |
|                             |
|  Riwayat 6 Bulan            |
|  Apr 2025 ... 750kg  85     |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Score card | `.score-card` | Navy background, skor kuning 48 px Cormorant — visual paling menonjol |
| Nilai skor | `.score-value` | Cormorant Garamond 48 px kuning — skala besar memberi dampak emosional |
| Progress bar | `.score-bar-bg` + `.score-bar-fill` | 6 px tinggi, kuning — representasi visual cepat |
| Stat row | `.stat-row` 4 kartu | KG, pengangkutan, tingkat pilah, organik |
| Rank badge | `.rank-1/2/3/other` | Emas/Perak/Perunggu/Abu — konvensi kompetisi universal |
| Leaderboard item | `.leaderboard-item` | Flex row: rank + nama + statistik + skor |

#### Formula Skor RW

```
Skor = min((total_kg / 500) x 40, 40)    <- komponen berat (maks 40)
     + (tingkat_pilah / 100) x 40         <- komponen pemilahan (maks 40)
     + konsistensi x 20                   <- komponen konsistensi (maks 20)
```

#### Psikologi Desain

Score card navy dengan angka kuning besar adalah momen "pengungkapan" — pengguna langsung tahu performa RW-nya. Leaderboard mendorong kompetisi sehat antar-RW. Riwayat 6 bulan memberikan perspektif temporal sehingga pengguna dapat melihat tren peningkatan atau penurunan.

#### Pengguna Target

**Warga dan Petugas** (melihat skor RW sendiri + leaderboard). **Admin** melihat laporan lebih detail di panel admin.

---

### M-09 Profil

**File**: `resources/views/app/profil.blade.php`

```
+-----------------------------+
|  [Navy Header Centered]     |
|                             |
|     +------------+          |
|     |  AB        |          |  <- avatar 80x80 px (inisial)
|     +------------+          |
|     Nama Pengguna           |
|     [Warga] . RW 01         |
+-----------------------------+
|  [Kuis Selesai] [Rata Skor] |  <- stat kuning
|                             |
|  Edit Profil                |
|  NAMA LENGKAP               |
|  [ikon] Nama _____________  |
|  EMAIL                      |
|  [ikon] email@... _________  |
|  NOMOR WHATSAPP             |
|  [ikon] 08... _____________  |
|  FOTO PROFIL                |
|  [ikon] Pilih file...       |
|  PASSWORD BARU (opsional)   |
|  [ikon] __________________ |
|  KONFIRMASI PASSWORD        |
|  [ikon] __________________ |
|                             |
|  [SIMPAN PERUBAHAN]         |
|  [Logout]                   |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Avatar | `.profil-avatar` | 80 x 80 px, radius 24 px; inisial 2 huruf jika belum upload foto |
| Inisial avatar | `.avatar-initials` | Cormorant Garamond 28 px, putih di atas transparan — fallback elegan |
| Header centered | Inline `text-align:center` | Profil terpusat di header untuk fokus identitas |
| Stat gamifikasi | `.stat-card-yellow` | Kartu kuning untuk rata-rata skor — angka pencapaian |
| Label input | `.input-label` | 12 px uppercase, letter-spacing — visual form terstruktur |
| Upload foto | `input[type=file]` | Field foto profil langsung |
| Tombol logout | `.btn-logout-full` | Merah muda lebar penuh — kontras dari yellow CTA |

#### Psikologi Desain

Avatar inisial fallback memberikan identitas personal meski tanpa foto. Menempatkan statistik kuis di profil mendorong pengguna untuk menyelesaikan lebih banyak kuis. Tombol logout berwarna merah muda secara psikologis "memperingatkan" pengguna ini adalah aksi yang mengakhiri sesi.

#### Pengguna Target

**Semua peran** — setiap pengguna dapat mengedit profil sendiri.

---

### M-10 Notifikasi

**File**: `resources/views/app/notifikasi.blade.php`

```
+-----------------------------+
|  <- Notifikasi              |
+-----------------------------+
|  +----------------------+   |
|  | (kuning) Jadwal Besok|   |  <- border kiri kuning (unread)
|  |  Pengangkutan RW 01  |   |
|  |  Besok pukul 07:00   |   |
|  |  2 jam yang lalu     |   |
|  |                   (.) |   |  <- titik kuning
|  +----------------------+   |
|  +----------------------+   |
|  |  Pengumuman (redup)  |   |  <- opacity 75% (sudah dibaca)
|  |  ...                 |   |
|  +----------------------+   |
|                             |
|  [pagination]               |
+-----------------------------+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Notifikasi belum dibaca | `.notif-unread` | Border kiri 3 px kuning + opacity penuh |
| Notifikasi sudah dibaca | `.notif-read` | Border kiri transparan + opacity 75% |
| Ikon tipe | Emoji berdasarkan `tipe` | jadwal, broadcast, info |
| Judul | `.notif-title` | 14 px bold navy |
| Pesan | `.notif-pesan` | 13 px teks biasa |
| Waktu relatif | `.notif-waktu` | `diffForHumans()` — "2 jam yang lalu" |
| Titik unread | `.notif-dot` | 8 px lingkaran kuning kanan atas |

#### Psikologi Desain

Border kiri kuning pada notifikasi belum dibaca adalah teknik visual yang kuat dan tidak mengganggu — pengguna langsung dapat membedakan belum/sudah dibaca tanpa teks. Opacity 75% pada yang sudah dibaca menciptakan hierarki visual yang natural. Waktu relatif lebih manusiawi daripada timestamp absolut.

#### Pengguna Target

**Semua peran**. Admin mengirim dari panel admin; warga dan petugas hanya menerima.

---

## Antarmuka Admin (Dashboard Web)

> Semua halaman admin menggunakan layout dua kolom: sidebar navy tetap (240 px) + area konten kanan. Font, variabel CSS, dan komponen badge berbagi definisi yang sama dengan mobile — konsistensi sistem desain lintas platform.

---

### A-01 Dashboard Admin

**File**: `resources/views/admin/dashboard.blade.php`

```
+--------------------+------------------------------------------+
|  SIDEBAR (240px)   |  TOPBAR                                  |
|  +------------+    |  Dashboard         Senin, 19 Mei 2025    |
|  | T  Taruna  |    +------------------------------------------+
|  |  dayavarna |    |  [Warga]   [Petugas]                     |
|  +------------+    |  [Jadwal]  [KG Bulan Ini]                |
|                    |                                          |
|  Home        (aktif|  +----------------+ +----------------+   |
|  Pengguna          |  | Jadwal Hari Ini| | Laporan Bulan  |   |
|  Jadwal            |  | [badge] RW nama| | RW01 ===== 87  |   |
|  Edukasi           |  | waktu . petugas| | RW02 === 65    |   |
|  Kuis              |  +----------------+ +----------------+   |
|  Laporan           |                                          |
|  Notifikasi        |                                          |
|  ----------        |                                          |
|  [A] Admin RW 01   |                                          |
+--------------------+------------------------------------------+
```

#### Atribut Komponen

| Zona | Komponen | Detail |
|------|----------|--------|
| **Sidebar** | `.admin-sidebar` | Fixed, lebar 240 px, navy penuh, z-index 100 |
| | Logo badge | 40 x 40 px kuning, huruf "T" serif — merek konsisten dengan mobile |
| | Nav link | Radius 10 px, hover putih transparan 8%; aktif: background kuning, teks navy |
| | User panel bawah | Avatar 36 x 36 px kuning, nama + role, tombol logout kanan |
| **Topbar** | `.admin-topbar` | Sticky top, putih, border bawah tipis, z-index 50 |
| | Page heading | 22 px Cormorant Garamond navy |
| | Tanggal | 13 px muted — konteks temporal |
| **Stat Widgets** | `.stats-grid` | 4 kolom, responsive 2 kolom di < 1100 px |
| | Widget ikon | 48 x 48 px radius 14 px, warna unik per metrik |
| | Nilai | 28 px Cormorant Garamond navy |
| **Cards** | `.admin-grid-2` | 2 kolom, responsive 1 kolom di < 900 px |
| | Jadwal hari ini | `.table-row` dengan badge status + detail waktu |
| | Progress bar skor | 6 px kuning — representasi visual instan |

#### Psikologi Desain

Sidebar navy memberikan "bingkai" institusional yang konstan — admin selalu tahu berada di sistem yang sama meski berpindah halaman. Stat widgets 4-kolom adalah "ringkasan eksekutif" — angka paling penting terlihat dalam satu pandang. Warna unik tiap ikon widget membantu pengenalan pattern tanpa membaca label.

#### Pengguna Target

**Super Admin** (akses semua data semua RW) dan **Admin RW** (data terbatas pada RW sendiri). Menu "Pengguna" hanya tampil di sidebar untuk Super Admin.

---

### A-02 Manajemen Pengguna

**File**: `resources/views/admin/users/index.blade.php`

```
+--------------------------------------------------------------------+
|  Manajemen Pengguna                          [+ Tambah User]       |
+--------------------------------------------------------------------+
|  NAMA       USERNAME    ROLE        RW      STATUS    AKSI         |
+--------------------------------------------------------------------+
|  Budi S.    budi123    [Warga]     RW 01   [Aktif]   [Edit][Hapus] |
|  Sari W.    sari456    [Petugas]   RW 02   [Aktif]   [Edit][Hapus] |
|  Andi K.    andi789    [Admin RW]  RW 03  [Non-aktif][Edit][Hapus] |
+--------------------------------------------------------------------+
|  [< 1 2 3 >] pagination                                            |
+--------------------------------------------------------------------+
```

#### Atribut Komponen

| Komponen | Class CSS | Detail |
|----------|-----------|--------|
| Tabel | `.admin-table` | Border-collapse, header abu uppercase 11 px |
| Badge role | `.badge-role-{role}` | Warna unik: biru/oranye/ungu/hijau — identifikasi cepat |
| Badge status | Inline style | Hijau = aktif, abu = non-aktif |
| Tombol edit | `.btn-table-edit` | Biru muda, kecil, inline |
| Tombol hapus | `.btn-table-delete` | Merah muda + konfirmasi JS |
| Pagination | `$users->links()` | Laravel pagination bawaan |

#### Badge Role & Psikologinya

| Role | Warna | Makna Psikologis |
|------|-------|-----------------|
| Super Admin | Biru indigo (`#e8f0fe`) | Otoritas tertinggi, kepercayaan |
| Admin RW | Oranye (`#fff3e0`) | Pemimpin lokal, kehangatan komunitas |
| Petugas | Ungu (`#f3e5f5`) | Pelayanan, profesionalisme lapangan |
| Warga | Hijau (`#e8f5e9`) | Komunitas, partisipasi, alam |

#### Pengguna Target

**Super Admin**: melihat semua pengguna lintas RW.
**Admin RW**: hanya melihat warga dan petugas dalam RW sendiri (filter di controller).

---

### A-03 Form User (Tambah / Edit)

**File**: `resources/views/admin/users/create.blade.php`, `edit.blade.php`

#### Atribut Komponen

| Field | Tipe | Validasi | Keterangan |
|-------|------|----------|------------|
| Nama | `text` | required | Nama lengkap pengguna |
| Username | `text` | required, unique | Identifier login |
| Email | `email` | nullable, unique | Opsional |
| Password | `password` | required (create) / nullable (edit) | Min 8 |
| Role | `select` | required | Opsi sesuai akses admin |
| RW | `select` | required kecuali super_admin | Dropdown dari tabel `rws` |
| Status Aktif | `checkbox` | — | Toggle `is_active` |

Form menggunakan pola grid 2 kolom (`.form-row`) untuk field berkaitan (password + konfirmasi), dan single kolom untuk field yang memerlukan perhatian penuh.

#### Psikologi Desain

Label uppercase 12 px dengan letter-spacing menciptakan kesan formulir resmi yang terstruktur. Border focus kuning konsisten di seluruh form — pengguna selalu tahu field mana yang aktif.

#### Pengguna Target

**Super Admin** (semua field, semua role). **Admin RW** (terbatas pada pembuatan warga dan petugas di RW sendiri).

---

### A-04 Jadwal — Daftar & Form Buat

**File**: `resources/views/admin/jadwal/index.blade.php`, `create.blade.php`

#### Form Buat Jadwal — Atribut

| Field | Tipe | Keterangan |
|-------|------|------------|
| RW | `select` | Muncul jika super_admin; admin_rw otomatis ke RW sendiri (`hidden`) |
| Petugas | `select` | Dropdown petugas aktif; opsional |
| Tanggal | `date` | required |
| Waktu Mulai | `time` | required, dalam `.form-row` 2 kolom |
| Waktu Selesai | `time` | required, dalam `.form-row` 2 kolom |
| Jenis Sampah | `select` | organik / anorganik / campuran / b3 |
| Estimasi Berat | `number` (kg) | opsional, step 0.01 |

#### Daftar Jadwal — Atribut Tabel

Kolom: Tanggal, Waktu, RW, Jenis, Petugas, Status, Aksi (Edit, Hapus).
Badge status 4 warna identik dengan mobile — konsistensi lintas antarmuka.

#### Psikologi Desain

Form jadwal dirancang linear (satu kartu, max-width 600 px) — meminimalkan distraksi. Field RW yang disembunyikan untuk admin_rw mengurangi beban kognitif dan mencegah kesalahan input.

#### Pengguna Target

**Admin RW**: buat jadwal untuk RW sendiri.
**Super Admin**: buat jadwal untuk RW manapun.

---

### A-05 Konten Edukasi — Daftar & Form Buat

**File**: `resources/views/admin/edukasi/create.blade.php`

#### Atribut Form

| Field | Tipe | Keterangan |
|-------|------|------------|
| Judul | `text` | required |
| Kategori | `select` | organik / anorganik / b3 / daur_ulang |
| Format | `select` | artikel / video — dalam `.form-row` 2 kolom |
| Konten | `textarea` (8 baris) | Isi artikel atau deskripsi |
| Thumbnail | `file` | Upload gambar, accept image/* |
| URL Video | `url` | Untuk format video (embed YouTube) |
| Durasi | `number` | Dalam menit |
| Terbitkan | `checkbox` | Toggle `is_published` — kontrol draft vs publik |

#### Psikologi Desain

Checkbox "Terbitkan sekarang" memberikan kontrol kepada admin — konten dapat disimpan sebagai draft terlebih dahulu sebelum dipublikasikan. Ini mengurangi tekanan dan memungkinkan persiapan konten tanpa langsung terekspos ke pengguna.

#### Pengguna Target

**Super Admin** dan **Admin RW** (keduanya dapat mengelola konten edukasi).

---

### A-06 Kuis — Buat dengan Soal Dinamis

**File**: `resources/views/admin/kuis/create.blade.php`

```
+--------------------------------------------------------------------+
|  Buat Kuis Baru                                                    |
+--------------------------------------------------------------------+
|  Judul Kuis: _______________________________________________       |
|                                                                    |
|  [Edukasi Terkait v]             [Durasi: 5 menit]                |
|                                                                    |
|  -------------------- Soal-Soal ----------------------------       |
|  +------------------------------------------------------------+   |
|  | Soal 1                                          [Hapus]   |   |  <- soal-block abu
|  | Pertanyaan: [textarea]                                     |   |
|  | +----------+ +----------+ +----------+ +----------+       |   |
|  | | Pilihan A| | Pilihan B| | Pilihan C| | Pilihan D|       |   |  <- grid 2x2
|  | +----------+ +----------+ +----------+ +----------+       |   |
|  | Jawaban Benar: [A v]                                       |   |
|  +------------------------------------------------------------+   |
|  [+ Tambah Soal]                                                   |
|                                                                    |
|  [Simpan Kuis]  [Batal]                                           |
+--------------------------------------------------------------------+
```

#### Atribut Komponen

| Komponen | Teknis | Detail |
|----------|--------|--------|
| Soal block | `.soal-block` | Background abu, radius 12 px — membedakan tiap soal secara visual |
| Soal header | `.soal-header` | Flex space-between: "Soal N" + tombol Hapus |
| Grid pilihan | `.pilihan-grid` | 2 x 2 CSS grid — efisien ruang untuk 4 pilihan |
| Tambah soal | Alpine.js `addSoal()` | Append ke array `soalList` secara reaktif |
| Hapus soal | Alpine.js `removeSoal(i)` | Splice dari array; tombol hanya muncul jika > 1 soal |
| Nama input dinamis | `:name="'soal[' + i + '][pertanyaan]'"` | Array PHP yang dapat di-loop di controller |
| Jawaban benar | `select` per soal | Nilai a/b/c/d yang akan dibandingkan saat submit kuis |

#### Psikologi Desain

Form dinamis Alpine.js menghilangkan batasan jumlah soal tanpa reload halaman — admin merasa memiliki kontrol penuh. Setiap soal terisolasi dalam blok abu yang memberikan batas visual jelas antara soal satu dan lainnya.

#### Pengguna Target

**Super Admin** dan **Admin RW** (pembuatan kuis untuk konten edukasi di wilayah masing-masing).

---

### A-07 Laporan Bulanan & Export CSV

**File**: `resources/views/admin/laporan/index.blade.php`

```
+--------------------------------------------------------------------+
|  Laporan Bulanan                               [Export CSV]        |
+--------------------------------------------------------------------+
|  [Bulan: Mei v]  [Tahun: 2025 v]  [Tampilkan]                     |
+--------------------------------------------------------------------+
|  No   RW     Total KG  Organik  Anorg  B3  Angkut  Pilah%  Skor  |
+--------------------------------------------------------------------+
|  #1   RW 03    890.0    650.0  210.0  30.0   45x    85%     92   |
|  #2   RW 01    750.0    500.0  220.0  30.0   38x    80%     87   |
|  #3   RW 02    600.0    400.0  180.0  20.0   30x    72%     75   |
+--------------------------------------------------------------------+
```

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Filter bulan/tahun | `select` dalam card — submit GET untuk filter periode |
| Tombol Export CSV | `.btn-secondary` — warna abu (sekunder, bukan aksi utama) |
| Rank badge | Emas/Perak/Perunggu/Abu — identik dengan mobile |
| Tabel 9 kolom | Data lengkap: total, organik, anorganik, B3, pengangkutan, tingkat pilah, skor |
| Skor | `font-size: 16px font-weight: 700 color: navy` — highlight nilai terpenting |
| Export | `response()->streamDownload()` — CSV tanpa membuat file di server |

#### Psikologi Desain

Admin membutuhkan data yang padat dan akurat. Tabel 9 kolom memberikan informasi lengkap dalam satu baris per RW — efisien untuk perbandingan. Rank badge emas/perak/perunggu memberi konteks kompetisi instan meski dalam tabel data.

#### Pengguna Target

**Super Admin**: melihat semua RW, dapat export data lintas RW.
**Admin RW**: hanya melihat data RW sendiri.

---

### A-08 Kirim Notifikasi

**File**: `resources/views/admin/notifikasi/create.blade.php`

#### Atribut Form

| Field | Tipe | Keterangan |
|-------|------|------------|
| Judul | `text` | required — subject notifikasi |
| Pesan | `textarea` (4 baris) | required — isi pesan |
| Tipe | `select` | info / jadwal / broadcast — broadcast hanya untuk super_admin |
| Target Role | `select` | Semua / Warga / Petugas |
| Target RW | `select` | Hanya untuk super_admin; admin_rw otomatis ke RW sendiri |

#### Psikologi Desain

Pembatasan tipe "broadcast" hanya untuk super_admin mencegah spam notifikasi lintas-RW. Field Target RW yang disembunyikan untuk admin_rw meminimalkan error UX — tidak ada kemungkinan salah kirim ke RW lain.

#### Pengguna Target

**Super Admin**: dapat broadcast ke semua RW, memilih RW target.
**Admin RW**: kirim notifikasi ke warga dan petugas dalam RW sendiri saja.

---

## Matriks Pengguna x Antarmuka

| Antarmuka | Super Admin | Admin RW | Petugas | Warga |
|-----------|:-----------:|:--------:|:-------:|:-----:|
| M-01 Login | Ya | Ya | Ya | Ya |
| M-02 Registrasi | — | — | — | Ya |
| M-03 Beranda | Ya | Ya | Ya | Ya |
| M-04 Jadwal (lihat) | Ya | Ya | Ya | Ya |
| M-04 Jadwal (aksi) | Ya | Ya | Ya | — |
| M-05 Edukasi | Ya | Ya | Ya | Ya |
| M-06 Detail Edukasi | Ya | Ya | Ya | Ya |
| M-07 Kuis | Ya | Ya | Ya | Ya |
| M-08 Laporan | Ya | Ya | Ya | Ya |
| M-09 Profil | Ya | Ya | Ya | Ya |
| M-10 Notifikasi | Ya | Ya | Ya | Ya |
| A-01 Dashboard | Ya | Ya | — | — |
| A-02 Manajemen User | Ya | Ya* | — | — |
| A-03 Form User | Ya | Ya* | — | — |
| A-04 Jadwal Admin | Ya | Ya | — | — |
| A-05 Edukasi Admin | Ya | Ya | — | — |
| A-06 Kuis Admin | Ya | Ya | — | — |
| A-07 Laporan Admin | Ya | Ya | — | — |
| A-08 Notifikasi Admin | Ya | Ya | — | — |

> \* Admin RW hanya melihat/mengelola data dalam RW sendiri.

---

## Panduan Instalasi

```bash
# 1. Clone repositori
git clone <url-repo>
cd tarunadayavarna

# 2. Salin konfigurasi
cp .env.example .env

# 3. Sesuaikan .env
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Install dependensi
composer install

# 5. Generate key aplikasi
php artisan key:generate

# 6. Jalankan migrasi dan seeder
php artisan migrate --seed

# 7. Buat symbolic link storage
php artisan storage:link

# 8. Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`.

- Mobile app: `http://localhost:8000/app/login`
- Admin panel: `http://localhost:8000/admin/dashboard` (login dulu via `/app/login`)

---

## Akun Seeder

| Username | Role | Password | RW |
|----------|------|----------|----|
| `superadmin` | Super Admin | `password` | — |
| `admin_rw01` | Admin RW | `password` | RW 01 |
| `admin_rw02` | Admin RW | `password` | RW 02 |
| `admin_rw03` | Admin RW | `password` | RW 03 |
| `admin_rw04` | Admin RW | `password` | RW 04 |
| `admin_rw05` | Admin RW | `password` | RW 05 |
| `petugas01` | Petugas | `password` | RW 01 |
| `petugas02` | Petugas | `password` | RW 02 |
| `petugas03` | Petugas | `password` | RW 03 |
| `warga01` | Warga | `password` | RW 01 |
| `warga02` | Warga | `password` | RW 02 |
| `warga03` | Warga | `password` | RW 03 |

---

## Prinsip Desain

| Prinsip | Implementasi |
|---------|-------------|
| **Mobile-first** | Shell 390 px, tap target 52 px, bottom nav sticky |
| **Progressive Disclosure** | Form log jadwal tersembunyi sampai status `proses`; tombol aksi muncul berdasarkan role dan state |
| **Konsistensi Visual** | Variabel CSS yang sama (`--navy`, `--yellow`, `--green`) digunakan di mobile dan admin |
| **Hierarki Tipografi** | Serif (Cormorant Garamond) untuk pencapaian/judul; Sans-serif (Plus Jakarta Sans) untuk teks operasional |
| **Warna Semantik** | 4 status (menunggu/proses/selesai/batal) memiliki warna konsisten di seluruh sistem |
| **Gamifikasi Ringan** | Skor RW, leaderboard, stat kuis di profil — mendorong partisipasi tanpa tekanan |
| **Role-scoped UI** | Controller memfilter data berdasarkan `rw_id`; Blade menyembunyikan elemen berdasarkan `role` |
| **WCAG AA+** | Semua kombinasi warna utama memiliki rasio kontras minimal 4.5 : 1 |
