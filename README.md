# Tarunadayavarna
### Sistem Pengelolaan Sampah Tingkat Desa

**Laravel 11 · Full-Stack Blade · Mobile-First · v1.0**

> Laporan lengkap seluruh antarmuka yang diimplementasikan: atribut komponen, fitur, psikologi warna, dan pengguna target setiap halaman.

---

## Daftar Isi

1. [Gambaran Sistem](#1-gambaran-sistem)
2. [Teknologi](#2-teknologi)
3. [Sistem Desain Global](#3-sistem-desain-global)
   - [Palet Warna & Psikologi](#palet-warna--psikologi)
   - [Tipografi](#tipografi)
   - [WCAG & Aksesibilitas](#wcag--aksesibilitas)
4. [Peran & Hak Akses](#4-peran--hak-akses)
5. [Fitur Sistem (Ringkasan)](#5-fitur-sistem-ringkasan)
6. [Antarmuka Mobile — `/app`](#6-antarmuka-mobile--app)
   - [M-01 Login](#m-01-login)
   - [M-02 Registrasi](#m-02-registrasi)
   - [M-03 Beranda](#m-03-beranda)
   - [M-04 Jadwal Pengangkutan](#m-04-jadwal-pengangkutan)
   - [M-05 Daftar Edukasi](#m-05-daftar-edukasi)
   - [M-06 Detail Artikel / Video](#m-06-detail-artikel--video)
   - [M-07 Kuis](#m-07-kuis)
   - [M-08 Laporan & Leaderboard](#m-08-laporan--leaderboard)
   - [M-09 Profil](#m-09-profil)
   - [M-10 Notifikasi](#m-10-notifikasi)
   - [M-11 Pengaturan](#m-11-pengaturan)
7. [Antarmuka Admin — `/admin`](#7-antarmuka-admin--admin)
   - [A-01 Dashboard](#a-01-dashboard)
   - [A-02 Manajemen Pengguna](#a-02-manajemen-pengguna)
   - [A-03 Form Tambah / Edit User](#a-03-form-tambah--edit-user)
   - [A-04 Daftar Jadwal (+ Kolom Log Bukti)](#a-04-daftar-jadwal--kolom-log-bukti)
   - [A-05 Detail Jadwal & Input Log Manual](#a-05-detail-jadwal--input-log-manual)
   - [A-06 Form Buat / Edit Jadwal](#a-06-form-buat--edit-jadwal)
   - [A-07 Daftar Konten Edukasi](#a-07-daftar-konten-edukasi)
   - [A-08 Form Buat / Edit Edukasi](#a-08-form-buat--edit-edukasi)
   - [A-09 Daftar Kuis](#a-09-daftar-kuis)
   - [A-10 Detail Kuis (Lihat Soal & Jawaban)](#a-10-detail-kuis-lihat-soal--jawaban)
   - [A-11 Form Buat Kuis — Soal Dinamis](#a-11-form-buat-kuis--soal-dinamis)
   - [A-12 Laporan Bulanan & Export CSV](#a-12-laporan-bulanan--export-csv)
   - [A-13 Daftar & Kirim Notifikasi](#a-13-daftar--kirim-notifikasi)
8. [Matriks Pengguna × Antarmuka](#8-matriks-pengguna--antarmuka)
9. [Panduan Instalasi](#9-panduan-instalasi)
10. [Akun Demo (Seeder)](#10-akun-demo-seeder)
11. [Prinsip Desain](#11-prinsip-desain)

---

## 1. Gambaran Sistem

**Tarunadayavarna** adalah platform pengelolaan sampah berbasis web skala kelurahan/RW. Sistem mengelola siklus penuh: penjadwalan pengangkutan, pencatatan log berat dan foto bukti, konten edukasi pemilahan, kuis interaktif, laporan skor bulanan per-RW, notifikasi, serta profil dan pengaturan pengguna.

Arsitektur UI terbagi dua:

| Dunia | Prefix | Target Pengguna | Perangkat |
|-------|--------|----------------|-----------|
| Mobile App | `/app/...` | Warga, Petugas | Smartphone (shell 390 px) |
| Admin Panel | `/admin/...` | Super Admin, Admin RW | Desktop / Laptop |

---

## 2. Teknologi

| Lapisan | Stack |
|---------|-------|
| Framework | Laravel 11 (PHP 8.2+) |
| Template Engine | Blade (server-side) |
| Interaktivitas | Alpine.js 3 (CDN, tanpa build step) |
| Database | MySQL 8 — utf8mb4 |
| Sesi | Driver: database |
| Storage | Laravel Storage (`storage/app/public/bukti/`) |
| CSS | Vanilla CSS — `app-mobile.css` + `app-admin.css` |
| Font | Cormorant Garamond + Plus Jakarta Sans (Google Fonts) |
| Logo | SVG custom (`public/images/logo.svg`) |
| Auth | Session-based, middleware `RoleMiddleware` |

---

## 3. Sistem Desain Global

### Palet Warna & Psikologi

```
Navy      Yellow    White     Gray      Green
#0D1B4B   #F5C518   #FFFFFF   #F4F6FB   #2ECC71
```

#### Navy `#0D1B4B` — Kepercayaan & Otoritas
Digunakan sebagai warna dominan pada semua header, sidebar admin, tombol primer, dan elemen navigasi aktif. Biru gelap secara psikologis mengkomunikasikan **institusi formal, kepercayaan, dan stabilitas** — sesuai dengan sistem pemerintahan desa. Kontras tinggi terhadap putih memastikan keterbacaan maksimal.

#### Yellow `#F5C518` — Aksi & Energi
Warna CTA utama: tombol LOGIN, SIMPAN, logo badge. Kuning menstimulasi **perhatian dan dorongan untuk bertindak** — secara naluriah mata manusia tertarik ke warna ini. Digunakan secara selektif agar tidak kehilangan dampaknya. Kombinasi navy-di-atas-kuning menghasilkan rasio kontras 6.7:1 (WCAG AA+).

#### Green `#2ECC71` — Konfirmasi & Keberhasilan
Eksklusif untuk status positif: badge `selesai`, flash sukses, rank teratas leaderboard. Hijau adalah warna universal untuk "berhasil/aman" — pengguna tidak perlu membaca teks untuk memahami kondisi positif.

#### Gray `#F4F6FB` — Ketenangan & Netralitas
Background konten, kartu abu, input field. Sedikit lebih gelap dari putih murni untuk mengurangi kelelahan mata dalam sesi baca panjang. Tidak mengganggu konten utama.

#### Warna Status Semantik

| Status | Background | Teks | Psikologi |
|--------|------------|------|-----------|
| `menunggu` | `#F0F0F0` | `#888` | Netral — belum ada tindakan |
| `proses` | `#FFF3CC` | `#a07000` | Amber/waspada — sedang berjalan |
| `selesai` | `#D4F5E6` | `#1a7a44` | Hijau — sukses, tuntas |
| `batal` | `#FDECEA` | `#c0392b` | Merah — error, dihentikan |

Keempat warna ini konsisten di seluruh sistem (mobile dan admin), menciptakan **bahasa visual yang seragam** tanpa perlu membaca label.

---

### Tipografi

| Font | Klasifikasi | Digunakan Pada | Alasan |
|------|-------------|----------------|--------|
| **Cormorant Garamond** | Serif elegan | Heading halaman, nilai statistik, nama di header, judul auth | Serif menciptakan kesan **formal dan berkelas** seperti lembaga resmi. Pada ukuran besar (48 px skor RW) terasa monumental. |
| **Plus Jakarta Sans** | Sans-serif modern | Body teks, label, tombol, navigasi, form | Sans-serif memastikan **keterbacaan tinggi** di ukuran 10–14 px pada layar mobile. |

Kontras serif/sans-serif yang disengaja: serif untuk "momen pencapaian", sans-serif untuk "tindakan operasional".

---

### WCAG & Aksesibilitas

| Kombinasi | Rasio | Level |
|-----------|-------|-------|
| Putih di atas Navy `#0D1B4B` | 13.9:1 | AAA |
| Navy di atas Yellow `#F5C518` | 6.7:1 | AA+ |
| Navy di atas White `#FFFFFF` | 16.0:1 | AAA |
| Muted `#8892a4` di atas White | 3.7:1 | AA (teks besar) |
| Green `#1a7a44` di atas `#D4F5E6` | 5.4:1 | AA |

**Tap target minimum**: 52 px (melampaui standar WCAG 48 px) untuk semua tombol dan item navigasi mobile.

---

## 4. Peran & Hak Akses

| Peran | Kode | Akses Mobile | Akses Admin |
|-------|------|-------------|-------------|
| Super Admin | `super_admin` | Penuh + aksi jadwal | Penuh — semua RW |
| Admin RW | `admin_rw` | Penuh + aksi jadwal | Terbatas RW sendiri |
| Petugas | `petugas` | Baca + update status + input log | Tidak ada |
| Warga | `warga` | Baca saja + kuis + profil | Tidak ada |

Kontrol akses diterapkan di dua lapisan:
- **Controller**: query difilter `where rw_id = user->rw_id` untuk admin_rw
- **Blade**: `@if(in_array($user->role, [...]))` untuk tombol aksi

---

## 5. Fitur Sistem (Ringkasan)

### Fitur Mobile

| Fitur | Deskripsi |
|-------|-----------|
| **Autentikasi** | Login/logout session-based; registrasi mandiri untuk warga |
| **Beranda Dashboard** | Stat bulan ini (kg, pengangkutan, skor RW), menu shortcut, jadwal hari ini |
| **Jadwal Pengangkutan** | Lihat jadwal dengan filter tanggal + filter jenis sampah (5 pills); petugas/admin dapat update status & input log dengan foto |
| **Edukasi** | Daftar artikel/video dengan search, filter kategori (4 warna), featured article |
| **Kuis** | Kuis pilihan ganda terikat artikel; skor tersimpan di profil |
| **Laporan & Leaderboard** | Skor RW bulan ini + progress bar, leaderboard semua RW dengan medali emas/perak/perunggu, riwayat 6 bulan |
| **Profil** | Edit nama, email, WhatsApp, foto profil, ganti password; statistik kuis |
| **Notifikasi** | Inbox notifikasi dengan indikator belum/sudah dibaca; waktu relatif; pagination |
| **Pengaturan** | Ganti password (validasi password lama), info akun, tentang aplikasi, tombol keluar dengan konfirmasi |

### Fitur Admin

| Fitur | Deskripsi |
|-------|-----------|
| **Dashboard** | 4 stat widget (warga, petugas, jadwal, kg); jadwal hari ini; progress skor laporan |
| **Manajemen User** | CRUD pengguna; badge role berwarna; filter tampilan berdasarkan scope RW |
| **Manajemen Jadwal** | CRUD jadwal; kolom log bukti di tabel (berat + ikon foto); detail halaman + input log manual |
| **Log Bukti Manual** | Admin input berat, catatan, foto bukti langsung dari panel; otomatis set status selesai + update laporan |
| **Manajemen Edukasi** | CRUD artikel/video; toggle terbitkan/draft; upload thumbnail |
| **Manajemen Kuis** | Buat kuis dengan soal dinamis (Alpine.js); lihat soal + jawaban benar di detail |
| **Laporan Bulanan** | Filter bulan/tahun; tabel 9 kolom terurut skor; export CSV |
| **Notifikasi** | Kirim ke role tertentu, RW tertentu, atau broadcast semua; riwayat pengiriman |

---

## 6. Antarmuka Mobile — `/app`

> Shell 390 px di desktop, melebar ke 100 vw di perangkat ≤ 480 px. Setiap halaman memiliki sticky `bottom-nav` 5 ikon.

---

### M-01 Login

**Route**: `GET /app/login` | **File**: `app/auth/login.blade.php`

```
+-----------------------------+
|  [Navy full-screen BG]      |
|                             |
|  +--------+                 |
|  | [LOGO] |  <- yellow box  |
|  +--------+                 |
|  Tarunadayavarna            |
|  Sistem Pengelolaan Sampah  |
|                             |
+-----------------------------+  <- card putih naik dari bawah
|  Selamat Datang             |
|  Masuk untuk melanjutkan    |
|                             |
|  [ikon] Username _________  |
|  [ikon] Password _________  |
|                             |
|  [        LOGIN           ] |
|                             |
|  Belum punya akun? Daftar   |
+-----------------------------+
```

#### Fitur
- Validasi username + password; cek `is_active = true`
- Jika role `super_admin` atau `admin_rw` → redirect otomatis ke `/admin/dashboard`
- Jika role `petugas` atau `warga` → redirect ke `/app/beranda`
- Error inline per field dengan `@error`
- Link ke halaman registrasi

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Background layar | `.auth-screen` | Navy 100 vh — membangun identitas merek sejak pertama buka |
| Logo | `.logo-circle` | 72×72 px, border-radius 20 px, background kuning; berisi SVG logo custom |
| Judul | `.app-title` | 26 px Cormorant Garamond putih |
| Tagline | `.app-subtitle` | 12 px, opacity 60% |
| Card formulir | `.auth-card` | border-radius 28 px kiri-atas kanan-atas; melayang di atas navy |
| Input field | `.input-row` | 52 px tinggi; ikon kuning kiri; border-color kuning saat focus |
| Tombol login | `.btn-yellow` | 52 px, lebar penuh, uppercase, shadow kuning |
| Error | `.field-error` | 11 px merah, inline di bawah field |

#### Psikologi Desain
Navy mendominasi seluruh layar untuk menanamkan kesan institusional sebelum pengguna melakukan apapun. Kuning pada logo dan tombol menjadi satu-satunya titik energi — mata pengguna langsung tertuju pada aksi. Card putih yang "naik dari bawah" secara visual mengundang interaksi.

#### Pengguna Target
Semua peran — halaman ini adalah pintu masuk universal.

---

### M-02 Registrasi

**Route**: `GET /app/register` | **File**: `app/auth/register.blade.php`

Layout identik dengan Login (navy + card putih). Tambahan field:

#### Fitur
- Registrasi mandiri hanya untuk **warga baru**
- Validasi: username unik, password min 8 karakter, konfirmasi password
- Pilih RW dari dropdown (data dari tabel `rw`)
- Setelah berhasil → login otomatis + redirect ke `/app/beranda`

#### Atribut Komponen

| Field | Tipe | Validasi |
|-------|------|----------|
| Nama Lengkap | `text` | required |
| Username | `text` | required, unique |
| Email | `email` | nullable, unique |
| Password | `password` | required, min:8 |
| Konfirmasi Password | `password` | confirmed |
| RW | `select` | required |

#### Psikologi Desain
Field RW mengkomunikasikan secara implisit bahwa sistem ini berbasis komunitas lokal — pengguna sadar mereka mendaftar sebagai bagian dari RW tertentu, bukan individu anonim.

#### Pengguna Target
**Warga baru** yang belum memiliki akun. Petugas dan admin dibuat oleh Super Admin dari panel admin.

---

### M-03 Beranda

**Route**: `GET /app/beranda` | **File**: `app/beranda.blade.php`

```
+-----------------------------+
|  [Navy Header]              |
|  Selamat datang,            |
|  [Nama User]          [notif]|
|  [Role] · RW XX             |
+-----------------------------+
|  [KG bln ini][Angkut][Skor] |
|                             |
|  Menu                       |
|  [Jadwal][Edukasi][Laporan][Profil]
|  [Notif ][Pengaturan]       |
|                             |
|  Jadwal Hari Ini            |
|  [dot] 07:00–09:00 Organik  |
|        Petugas: Budi   [badge]
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Fitur
- **Stat cards** tiga angka: total kg bulan ini, jumlah pengangkutan, skor RW — diambil dari `laporan_bulanan` bulan berjalan
- **Notif badge**: penghitung notifikasi belum dibaca, muncul di tombol lonceng kanan atas
- **Menu grid dua baris**: Jadwal, Edukasi, Laporan, Profil (baris 1) + Notifikasi, Pengaturan (baris 2)
- **Jadwal hari ini**: daftar jadwal `tanggal = today` untuk RW pengguna; dot warna sesuai status
- **Role badge**: menampilkan peran dan nama RW pengguna

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Header navy | `.page-header-navy` | Padding top 50 px; lingkaran dekorasi kuning semi-transparan kanan atas |
| Nama pengguna | `.header-name` | 22 px Cormorant Garamond putih |
| Role badge | `.role-badge` | Pill putih transparan 15% |
| Tombol notif | `.notif-btn` | 40×40 px; `.notif-badge` kuning 18 px bulat |
| Stat card | `.stat-card` | Kartu abu; kartu pertama `.stat-card-yellow` (kuning) |
| Nilai stat | `.stat-value` | 22 px Cormorant Garamond navy |
| Menu grid | `.menu-grid` | 4-kolom CSS grid, radius 14 px, background abu |
| Jadwal dot | `.jadwal-dot.dot-{status}` | 12 px bulat; abu/kuning/hijau/merah |
| Status badge | `.badge-{status}` | Pill semantik 4 warna |
| Bottom nav | `.bottom-nav` | Sticky bottom; ikon aktif background navy |

#### Psikologi Desain
Beranda adalah "pusat kendali" — tiga angka statistik memberikan kepuasan progres instan (gamifikasi ringan). Menu grid besar memastikan navigasi cepat bahkan saat bergerak. Dot warna pada jadwal memungkinkan pengguna membaca status tanpa membaca teks.

#### Pengguna Target
Semua peran. Petugas/admin melihat tombol aksi di kartu jadwal; warga hanya melihat informasi.

---

### M-04 Jadwal Pengangkutan

**Route**: `GET /app/jadwal` | **File**: `app/jadwal.blade.php`

```
+-----------------------------+
|  <- Jadwal Pengangkutan     |
|     RW 01                   |
+-----------------------------+
|  [kal] Filter tanggal _____ |  <- auto-submit onchange
|                             |
|  [Semua][Organik][Anorganik]|  <- filter pills
|  [Campuran][B3]             |
|                             |
|  [dot] 12 Mei 2025          |
|   07:00–09:00  Organik      |
|   Petugas: Budi  [Proses]   |
|  ─────────────────────────  |
|  [Mulai] [Batal]            |  <- aksi petugas/admin
|  [Input Log v]              |  <- Alpine.js expand
|    Berat (kg): _____        |
|    Foto: _______            |
|    Catatan: ______          |
|  [SIMPAN & SELESAI]         |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Fitur
- **Filter tanggal**: `input[type=date]` auto-submit `onchange` tanpa tombol terpisah
- **Filter jenis sampah** (pills): `Semua | Organik | Anorganik | Campuran | B3` via query `?jenis=`; kedua filter berjalan bersamaan
- Default tampil jadwal 7 hari terakhir jika tidak ada filter tanggal
- **Petugas**: hanya melihat jadwal yang di-assign ke dirinya
- **Tombol Mulai**: PATCH `status → proses` (muncul hanya saat `menunggu`)
- **Input Log**: expand/collapse Alpine.js; upload foto bukti ke `storage/app/public/bukti/`; setelah submit → status `selesai` + `LaporanService::updateBulanan()` dipanggil
- **Foto bukti**: thumbnail ditampilkan langsung di kartu setelah log tersimpan
- **Tombol Batal**: konfirmasi JS `confirm()` sebelum eksekusi

#### Atribut Komponen

| Komponen | Teknis | Detail |
|----------|--------|--------|
| Filter tanggal | `input[type=date]` + `onchange submit` | Preserve query `?jenis` via hidden input |
| Filter pills | `.pill` / `.pill-active` | Navy aktif, abu tidak aktif; overflow-x auto |
| Status dot | `.jadwal-dot.dot-{status}` | 12 px bulat — indikator visual instan |
| Tombol Mulai | `.btn-sm-yellow` | Muncul hanya jika `status === 'menunggu'` |
| Form log | Alpine.js `x-data="{ open: false }"` | Progressive disclosure — tidak membuka halaman baru |
| Upload foto | `input[type=file] accept="image/*"` | `enctype=multipart/form-data` |
| Foto thumbnail | `img max-height:200px` | Tampil langsung di kartu setelah log tersimpan |
| Tombol Batal | `.btn-sm-danger` | Merah muda + `onclick confirm()` |

#### Psikologi Desain
Progressive disclosure: form Input Log hanya muncul saat status `proses` — pengguna tidak melihat aksi yang tidak relevan untuk kondisi saat ini. Filter pills horizontal memungkinkan scan cepat tanpa dropdown. Warna kuning pada "Mulai" menciptakan urgensi positif.

#### Pengguna Target
- **Warga**: read-only, lihat jadwal dan status
- **Petugas**: update status + input log jadwal yang di-assign
- **Admin RW / Super Admin**: semua aksi, semua jadwal RW

---

### M-05 Daftar Edukasi

**Route**: `GET /app/edukasi` | **File**: `app/edukasi/index.blade.php`

```
+-----------------------------+
|  <- Edukasi Sampah          |
+-----------------------------+
|  [cari] Cari artikel...     |
|  [Semua][Organik][Anorganik]|
|  [B3][Daur Ulang]           |
|                             |
|  +-------------------------+|  <- featured card
|  |    [gambar hero]        ||
|  |  [Terbaru]              ||
|  |  Judul Artikel Unggulan ||
|  +-------------------------+|
|                             |
|  +--------+  +--------+    |  <- 2-kolom grid
|  |[thumb] |  |[thumb] |    |
|  |[badge] |  |[badge] |    |
|  |Judul   |  |Judul   |    |
|  |5 menit |  |3 menit |    |
|  +--------+  +--------+    |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Fitur
- **Search**: query `?q=` filter berdasarkan judul artikel
- **Filter kategori** (pills): `Semua | Organik | Anorganik | B3 | Daur Ulang` via `?kategori=`; search dan filter berjalan bersamaan
- **Featured card**: artikel terbaru tampil sebagai hero card (160 px tinggi, overlay gradient), tersembunyi saat ada search/filter aktif
- **Grid 2 kolom**: artikel lainnya dalam card kompak dengan thumbnail, badge kategori, judul, dan durasi baca/tonton
- Placeholder emoji jika tidak ada thumbnail

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Search | `.input-row` | Ikon kaca pembesar kuning; auto-redirect GET |
| Filter pills | `.pill` / `.pill-active` | overflow-x auto; navbar horizontal scrollable |
| Featured card | `.featured-card` | 160 px, `object-fit:cover`, gradient overlay navy |
| Tag "Terbaru" | `.featured-tag` | Kuning kecil; selalu tampil di featured |
| Grid kartu | `.edukasi-grid` | 2-kolom, `box-shadow` ringan |
| Badge kategori | `.badge-organik/anorganik/b3/daur_ulang` | Warna unik per kategori |

#### Badge Kategori & Psikologi

| Kategori | Warna | Makna |
|----------|-------|-------|
| Organik | Hijau `#e8f5e9 / #2e7d32` | Alam, pertumbuhan, dekomposisi alami |
| Anorganik | Biru `#e3f2fd / #1565c0` | Teknologi, industri daur ulang |
| B3 | Merah `#fce4ec / #c62828` | Bahaya, peringatan keras |
| Daur Ulang | Ungu `#f3e5f5 / #6a1b9a` | Kreativitas, transformasi nilai |

#### Pengguna Target
Semua peran — konten edukasi bersifat publik dalam aplikasi.

---

### M-06 Detail Artikel / Video

**Route**: `GET /app/edukasi/{slug}` | **File**: `app/edukasi/detail.blade.php`

#### Fitur
- **Artikel**: gambar thumbnail full-width + konten teks `nl2br(e($konten))`
- **Video**: wrapper responsive 16:9 (padding-top 56.25%) + iframe embed
- **Kuis banner**: muncul di bawah konten jika artikel memiliki kuis aktif; tombol "Mulai" atau badge "Selesai" (hijau) jika sudah dikerjakan
- Badge kategori berwarna di header halaman

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Header navy | Badge kategori di atas judul putih |
| Thumbnail | `max-height: 200px`, `object-fit: cover` |
| Video wrapper | `padding-top: 56.25%` — responsive 16:9 tanpa JS |
| Konten artikel | 14 px, `line-height: 1.7` — standar keterbacaan mobile |
| Kuis banner | `.kuis-banner` abu; CTA kuning "Mulai" atau badge hijau "Selesai" |

#### Psikologi Desain
Kuis banner adalah reward setelah membaca — alur alami: baca → uji → selesai. Badge hijau "Selesai" memberikan kepuasan closure dan mendorong pengguna mengikuti artikel berikutnya.

#### Pengguna Target
Semua peran untuk membaca. Kuis paling relevan untuk **Warga**.

---

### M-07 Kuis

**Route**: `GET /app/kuis/{id}` | **File**: `app/kuis/show.blade.php`

#### Fitur
- Tampilkan semua soal sekaligus dalam satu form (scroll)
- Setiap soal: nomor, pertanyaan, 4 pilihan dengan kunci huruf (A/B/C/D)
- Submit semua jawaban sekaligus: `POST /app/kuis/{id}/submit`
- Skor dihitung di `KuisController::submit()` → disimpan ke `kuis_hasil`
- Jika sudah pernah ikut: tampilkan empty state "Sudah mengerjakan" + link kembali ke edukasi
- Radio button `accent-color: var(--navy)`

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Nomor soal | `.soal-nomor` | 11 px uppercase muted — hierarki rendah |
| Pertanyaan | `.soal-pertanyaan` | 14 px semibold navy |
| Item pilihan | `.pilihan-item` | 52 px+ tap target; background abu; radius 10 px |
| Kunci huruf | `.pilihan-key` | 24×24 px navy, rounded 6 px |
| Tombol submit | `.btn-yellow` | Lebar penuh, uppercase |

#### Psikologi Desain
Kunci huruf navy memberi struktur visual seperti soal ujian formal — membantu kognitif membedakan pilihan. Tap target besar mengurangi kesalahan tap pada layar kecil.

#### Pengguna Target
**Warga** (primer) — **Petugas** dan **Admin** dapat ikut kuis juga.

---

### M-08 Laporan & Leaderboard

**Route**: `GET /app/laporan` | **File**: `app/laporan.blade.php`

```
+-----------------------------+
|  <- Laporan Bulanan         |
|     Mei 2026                |
+-----------------------------+
|  +---------------------+   |  <- score card navy
|  | RW 01               |   |
|  |      87             |   |  <- 48px kuning
|  |      /100           |   |
|  | =================== |   |  <- progress bar
|  +---------------------+   |
|  [KG][Angkut][Pilah%][Organik]
|                             |
|  Peringkat RW               |
|  [#1 emas]  RW 04  97      |
|  [#2 perak] RW 02  94      |
|  [#3 perunggu] RW 01  88   |
|                             |
|  Riwayat 6 Bulan            |
|  Apr 2026 ... 420kg  82    |
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Fitur
- **Score card**: skor RW pengguna dengan angka besar + progress bar; diambil dari `laporan_bulanan` bulan dan tahun berjalan
- **4 stat**: total kg, jumlah pengangkutan, tingkat pilah %, organik kg
- **Leaderboard**: semua RW terurut skor bulan ini; medali emas/perak/perunggu untuk rank 1-3
- **Riwayat 6 bulan**: history laporan RW sendiri untuk melihat tren
- Jika belum ada laporan bulan ini: empty state dengan pesan informatif

#### Formula Skor RW

```
Skor = min((total_kg / 500) × 40, 40)     <- berat: maks 40 poin
     + (tingkat_pilah / 100) × 40          <- pemilahan: maks 40 poin
     + min(jumlah_angkut / 4, 1) × 20      <- konsistensi: maks 20 poin
                                            = total maks 100 poin
```

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Score card | `.score-card` | Navy background, skor 48 px Cormorant kuning |
| Progress bar | `.score-bar-bg + .score-bar-fill` | 6 px tinggi, kuning |
| Rank badge | `.rank-1/2/3/other` | Emas `#FFD700`, Perak `#C0C0C0`, Perunggu `#CD7F32` |

#### Psikologi Desain
Angka skor 48 px di atas navy adalah momen "pengungkapan" — pengguna langsung tahu performa RW-nya. Leaderboard mendorong kompetisi sehat antar-RW. Riwayat 6 bulan memberikan perspektif temporal yang memotivasi peningkatan.

#### Pengguna Target
**Warga dan Petugas** (lihat skor RW + leaderboard). Admin melihat data lebih detail di panel admin.

---

### M-09 Profil

**Route**: `GET /app/profil` | **File**: `app/profil.blade.php`

#### Fitur
- **Avatar**: foto profil dari storage jika ada, atau inisial 2 huruf nama sebagai fallback
- **Statistik gamifikasi**: jumlah kuis selesai + rata-rata skor (dari `kuis_hasil`)
- **Form edit profil**: nama, email, nomor WhatsApp, foto profil (upload), ganti password (opsional — hanya diproses jika diisi)
- **Logout** dari halaman profil

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Avatar | `.profil-avatar` | 80×80 px, radius 24 px, border putih transparan |
| Inisial fallback | `.avatar-initials` | Cormorant Garamond 28 px putih — fallback elegan |
| Stat kuis | `.stat-card-yellow` | Kartu kuning untuk rata-rata skor |
| Label input | `.input-label` | 12 px uppercase, letter-spacing |
| Tombol logout | `.btn-logout-full` | Merah muda lebar penuh — kontras dari CTA kuning |

#### Psikologi Desain
Inisial fallback memberikan identitas personal meski belum upload foto. Statistik kuis di profil mendorong pengguna menyelesaikan lebih banyak kuis. Tombol logout merah muda secara psikologis memperingatkan ini adalah aksi akhir sesi.

#### Pengguna Target
Semua peran.

---

### M-10 Notifikasi

**Route**: `GET /app/notifikasi` | **File**: `app/notifikasi.blade.php`

#### Fitur
- Daftar notifikasi milik pengguna (via tabel `notifikasi_user`)
- Indikator visual belum/sudah dibaca: border kiri 3 px kuning + opacity penuh vs border transparan + opacity 75%
- Titik kuning 8 px di kanan atas untuk yang belum dibaca
- Ikon emoji per tipe: `📅` jadwal, `📢` broadcast, `ℹ️` info
- Waktu relatif `diffForHumans()` — "2 jam yang lalu"
- Pagination Laravel standar

#### Atribut Komponen

| Komponen | Class | Detail |
|----------|-------|--------|
| Belum dibaca | `.notif-unread` | Border kiri 3 px kuning |
| Sudah dibaca | `.notif-read` | Border transparan, opacity 75% |
| Judul | `.notif-title` | 14 px bold navy |
| Pesan | `.notif-pesan` | 13 px teks biasa |
| Waktu | `.notif-waktu` | 11 px muted, `diffForHumans()` |
| Titik unread | `.notif-dot` | 8 px kuning bulat |

#### Psikologi Desain
Border kiri kuning adalah teknik visual yang kuat — pengguna membedakan belum/sudah dibaca secara instan tanpa membaca teks. Opacity 75% pada yang sudah dibaca menciptakan hierarki visual alami.

#### Pengguna Target
Semua peran menerima notifikasi. Admin mengirim dari panel admin.

---

### M-11 Pengaturan

**Route**: `GET /app/pengaturan` | **File**: `app/pengaturan.blade.php`

```
+-----------------------------+
|  <- Pengaturan              |
|     Kelola akun & preferensi|
+-----------------------------+
|  Ganti Password             |
|  +-----------------------+  |
|  | PASSWORD LAMA         |  |
|  | [ikon] ______________ |  |
|  | PASSWORD BARU         |  |
|  | [ikon] ______________ |  |
|  | KONFIRMASI            |  |
|  | [ikon] ______________ |  |
|  | [SIMPAN PASSWORD]     |  |
|  +-----------------------+  |
|                             |
|  Tentang Aplikasi           |
|  Versi .......... 1.0.0     |
|  Organisasi ....  Kel. TDV  |
|                             |
|  Akun                       |
|  Username ....  superadmin  |
|  Peran ........ Super Admin |
|  RW ........... —           |
|                             |
|  [Keluar dari Aplikasi]     |  <- merah, konfirmasi JS
+--[Home][Jadwal][Edu][Lap][Profil]--+
```

#### Fitur
- **Ganti Password**: validasi password lama (`Hash::check`) sebelum update; error inline jika tidak cocok
- **Tentang Aplikasi**: nama, versi, organisasi, kontak email
- **Info Akun**: username, peran, RW (read-only — tidak bisa diedit di sini)
- **Tombol Keluar**: `form POST` ke `app.logout` dengan `onsubmit confirm('...')` — konfirmasi sebelum logout
- Tombol keluar styling berbeda dari CTA utama: `background: #fff; border: 2px solid #FFE5E5; color: #e74c3c`

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Kartu ganti password | `.card` putih, margin-bottom 20 px |
| Input password | `.input-row` 52 px + ikon kunci |
| Info rows | `display:flex justify-content:space-between` — label muted kiri, nilai navy kanan |
| Tombol Keluar | Background putih, border merah muda `#FFE5E5`, teks merah `#e74c3c` |

#### Psikologi Desain
Memisahkan "Keluar" dari "Simpan" di halaman berbeda (bukan di bawah form sama) memberi pengguna kontrol penuh atas sesi. Konfirmasi JS sebelum logout mencegah logout tidak sengaja. Warna merah muda (bukan merah penuh) pada tombol keluar menghindari kesan alarm berlebihan.

#### Pengguna Target
Semua peran.

---

## 7. Antarmuka Admin — `/admin`

> Semua halaman admin menggunakan layout sidebar navy 240 px + area konten kanan dengan sticky topbar putih.

---

### A-01 Dashboard

**Route**: `GET /admin/dashboard` | **File**: `admin/dashboard.blade.php`

```
+--------------------+-------------------------------------+
|  SIDEBAR (240px)   | TOPBAR: Dashboard  | Senin, 26 Mei  |
|  [LOGO] Taruna     +-------------------------------------+
|  dayavarna         | [Warga] [Petugas] [Jadwal] [KG/bln] |  <- 4 widget
|                    +-------------------------------------+
|  Dashboard (aktif) | +------------------+ +-----------+ |
|  Jadwal            | | Jadwal Hari Ini  | | Laporan   | |
|  Pengguna*         | | [badge] RW nama  | | RW01 ==87 | |
|  Edukasi           | | waktu petugas    | | RW02 ==65 | |
|  Kuis              | +------------------+ +-----------+ |
|  Laporan           |                                     |
|  Notifikasi        |                                     |
|  ──────────────    |                                     |
|  [A] Nama User  [>]|                                     |
+--------------------+-------------------------------------+
* Hanya super_admin
```

#### Fitur
- **4 stat widgets**: Total Warga aktif, Petugas aktif, Total Jadwal bulan ini, KG bulan ini
- **Jadwal hari ini**: `tanggal = today` untuk scope RW user; setiap baris: badge status + nama RW + jenis + waktu + petugas
- **Laporan bulan ini**: progress bar kuning per RW + nilai skor, urut skor tertinggi
- Topbar: heading halaman + tanggal hari ini (translatedFormat Indonesia)

#### Atribut Komponen Sidebar

| Komponen | Class | Detail |
|----------|-------|--------|
| Sidebar | `.admin-sidebar` | Fixed, 240 px, navy, z-index 100 |
| Logo badge | `.logo-badge` | 40×40 px kuning; berisi SVG logo custom |
| Nav link | `.nav-link` | Hover: putih transparan 8%; aktif: background kuning, teks navy bold |
| User panel | `.sidebar-user` | Avatar 36×36 px kuning + nama + role + tombol logout |
| Topbar | `.admin-topbar` | Sticky top, putih, border bawah `#eaecf0` |

#### Psikologi Desain
Sidebar navy yang konstan memberi "bingkai" institusional — admin selalu tahu di sistem mana mereka berada. Nav link aktif kuning menciptakan orientasi posisi yang jelas tanpa teks "Anda di sini". 4 stat widgets adalah "ringkasan eksekutif" — angka terpenting terlihat tanpa scroll.

#### Pengguna Target
**Super Admin** (semua data semua RW) dan **Admin RW** (data terbatas RW sendiri). Menu "Pengguna" hanya terlihat untuk Super Admin.

---

### A-02 Manajemen Pengguna

**Route**: `GET /admin/users` | **File**: `admin/users/index.blade.php`

#### Fitur
- Tabel semua pengguna dengan kolom: Nama, Username, Role, RW, Status, Aksi
- **Super Admin**: melihat semua pengguna semua RW
- **Admin RW**: hanya melihat warga dan petugas dalam RW sendiri (filter di controller)
- Badge role berwarna unik per peran
- Badge status: hijau = aktif, abu = non-aktif
- Tombol Edit + Hapus (hapus dengan `confirm()`)
- Pagination

#### Atribut Badge Role

| Role | Warna BG | Warna Teks | Psikologi |
|------|----------|------------|-----------|
| Super Admin | `#e8f0fe` | `#3d5afe` biru | Otoritas tertinggi |
| Admin RW | `#fff3e0` | `#e65100` oranye | Pemimpin lokal, kehangatan |
| Petugas | `#f3e5f5` | `#6a1b9a` ungu | Pelayanan, profesional |
| Warga | `#e8f5e9` | `#2e7d32` hijau | Komunitas, alam |

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-03 Form Tambah / Edit User

**Route**: `GET /admin/users/create`, `/admin/users/{id}/edit` | **File**: `admin/users/create.blade.php`, `edit.blade.php`

#### Fitur
- Field: Nama, Username, Email (opsional), Password (required saat create, nullable saat edit), Role, RW, Status Aktif
- **Admin RW**: pilihan role dibatasi (tidak bisa buat super_admin); RW otomatis RW sendiri via hidden input
- Validasi: username unik, email unik, password min 8
- `.form-row` dua kolom untuk field berkaitan (password + konfirmasi)
- Error inline dengan `.field-error`

#### Pengguna Target
**Super Admin** (semua field) dan **Admin RW** (terbatas warga + petugas di RW sendiri).

---

### A-04 Daftar Jadwal (+ Kolom Log Bukti)

**Route**: `GET /admin/jadwal` | **File**: `admin/jadwal/index.blade.php`

#### Fitur
- Tabel 8 kolom: Tanggal, Waktu, RW, Jenis Sampah, Petugas, Status, **Log Bukti**, Aksi
- **Kolom Log Bukti** (fitur baru):
  - Ada log → tampilkan berat_actual_kg bold + ikon 📷 jika ada foto + tombol "Lihat Detail"
  - Belum ada log + status aktif → tampilkan "Belum ada log" muted + tombol "Input Log"
- Tombol Aksi: Detail (biru), Edit (ungu), Hapus (merah)
- Pagination 20 item per halaman

#### Psikologi Desain
Kolom Log Bukti di tabel memberi admin visibilitas penuh status pengangkutan tanpa harus masuk ke detail setiap jadwal. Ikon 📷 adalah sinyal visual instan bahwa bukti foto tersedia.

#### Pengguna Target
**Super Admin** (semua jadwal) dan **Admin RW** (jadwal RW sendiri).

---

### A-05 Detail Jadwal & Input Log Manual

**Route**: `GET /admin/jadwal/{id}` | `POST /admin/jadwal/{id}/log` | **File**: `admin/jadwal/show.blade.php`

```
+---------------------------------------+
| <- Kembali    |   [Edit Jadwal]        |
+------------------+--------------------+
| Informasi Jadwal | Log Pengangkutan   |
|                  |                    |
| RW     : RW 01   | Berat Aktual       |
| Petugas: Budi    | 142.5 kg           |
| Tanggal: 12 Mei  | (estimasi 120 kg)  |
| Waktu  : 07–09   |                    |
| Jenis  : Organik | Selesai: 12 Mei    |
| Estimasi: 120 kg | 09:15              |
| Status : [badge] |                    |
|                  | Catatan: ...       |
|                  |                    |
|                  | [foto thumbnail]   |
|                  | (klik buka penuh)  |
|                  +--------------------+
|                  | FORM INPUT LOG     |
|                  | Berat (kg): ___    |
|                  | Catatan:   ___     |
|                  | Foto:      ___     |
|                  | [Simpan & Selesai] |
+------------------+--------------------+
```

#### Fitur
- **Layout 2 kartu** berdampingan: info jadwal (kiri) + log pengangkutan (kanan)
- **Kartu info**: RW, petugas, tanggal (translatedFormat), waktu, jenis sampah, estimasi kg, status badge
- **Kartu log — jika ada**: berat aktual (vs estimasi), waktu selesai, catatan, foto bukti (thumbnail klikable buka tab baru)
- **Form input/perbarui log**: selalu tersedia di bawah data log; admin dapat menimpa log yang sudah ada
- Submit form: `updateOrCreate` log + `status → selesai` + `LaporanService::updateBulanan()`
- **Akses**: Super Admin semua RW; Admin RW hanya RW sendiri (`abort(403)`)

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Layout | `.admin-grid-2` — 2 kolom, responsive 1 kolom di < 900 px |
| Info table | `table` simple tanpa border, `padding: 8px 0`, `border-bottom: 1px solid var(--gray)` |
| Foto thumbnail | `max-width: 280px`, `border-radius: 10px`, hover opacity 85%, link ke foto penuh |
| Form | `enctype=multipart/form-data`; validasi max 2 MB |
| Tombol simpan | `.btn-primary` navy — visual berbeda dari `.btn-yellow` untuk membedakan konteks |

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-06 Form Buat / Edit Jadwal

**Route**: `GET /admin/jadwal/create` | **File**: `admin/jadwal/create.blade.php`

#### Fitur
- **RW**: dropdown semua RW (super_admin) atau hidden input RW sendiri (admin_rw)
- **Petugas**: dropdown petugas aktif, filter RW sesuai scope
- **Tanggal**: `input[type=date]`
- **Waktu Mulai + Selesai**: dua kolom `.form-row`
- **Jenis Sampah**: select 4 opsi
- **Estimasi Berat**: number opsional
- Setelah store → kirim notifikasi ke warga RW via `NotifikasiService::kirimKeRW()`

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-07 Daftar Konten Edukasi

**Route**: `GET /admin/edukasi` | **File**: `admin/edukasi/index.blade.php`

#### Fitur
- Tabel: Judul, Kategori, Format (Artikel/Video), Status (Terbit/Draft), Tanggal Dibuat, Aksi
- Badge status: hijau `Terbit`, abu `Draft`
- Edit + Hapus per baris
- Tombol "+ Tambah Konten"
- Pagination

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-08 Form Buat / Edit Edukasi

**Route**: `GET /admin/edukasi/create` | **File**: `admin/edukasi/create.blade.php`

#### Fitur
- **Judul**: text, required
- **Kategori + Format**: dua kolom `.form-row`
- **Konten**: textarea 8 baris
- **Thumbnail**: upload gambar
- **URL Video**: url field (muncul untuk format video)
- **Durasi**: number dalam menit
- **Checkbox "Terbitkan sekarang"**: toggle `is_published` — konten bisa disimpan sebagai draft

#### Psikologi Desain
Checkbox "Terbitkan sekarang" memberi kontrol persiapan konten — admin bisa draft dulu sebelum dipublikasikan, mengurangi tekanan "harus sempurna sebelum submit".

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-09 Daftar Kuis

**Route**: `GET /admin/kuis` | **File**: `admin/kuis/index.blade.php`

#### Fitur
- Tabel: Judul, Edukasi Terkait, Soal (jumlah), Durasi, Status Aktif, Aksi
- Tombol: Lihat Detail, Edit, Hapus
- Pagination

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-10 Detail Kuis (Lihat Soal & Jawaban)

**Route**: `GET /admin/kuis/{id}` | **File**: `admin/kuis/show.blade.php`

#### Fitur
- Metadata kuis: judul, edukasi terkait, durasi, status aktif, jumlah soal
- Daftar semua soal: pertanyaan + 4 pilihan
- **Jawaban benar ditandai hijau** dengan tanda centang — untuk keperluan review tanpa harus edit
- Tidak bisa diubah dari sini (hanya lihat)

#### Psikologi Desain
Halaman detail kuis memungkinkan admin mereview kualitas soal sebelum/setelah dipublikasikan. Jawaban benar ditampilkan eksplisit — mengurangi risiko soal dengan jawaban salah lolos ke warga.

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-11 Form Buat Kuis — Soal Dinamis

**Route**: `GET /admin/kuis/create` | **File**: `admin/kuis/create.blade.php`

```
+------------------------------------------------+
| Judul Kuis: ___________________________        |
|                                                |
| [Edukasi Terkait v]      [Durasi: 5 mnt]       |
|                                                |
| ──────────── Soal-Soal ───────────────         |
| +--------------------------------------------+ |
| | Soal 1                        [Hapus]      | |  <- soal-block abu
| | Pertanyaan: [textarea]                     | |
| | [Pilihan A] [Pilihan B]                    | |  <- 2x2 grid
| | [Pilihan C] [Pilihan D]                    | |
| | Jawaban Benar: [A v]                       | |
| +--------------------------------------------+ |
| [+ Tambah Soal]                                |
|                                                |
| [Simpan Kuis]  [Batal]                         |
+------------------------------------------------+
```

#### Fitur
- **Alpine.js reactive form**: `soalList` array, `addSoal()` append, `removeSoal(i)` splice
- Soal bertambah tanpa reload halaman
- Tombol Hapus hanya muncul jika > 1 soal
- Nama input dinamis: `:name="'soal[' + i + '][pertanyaan]'"` → array PHP di controller
- Pilihan A + B required, C + D opsional
- Jawaban benar: select a/b/c/d per soal

#### Atribut Komponen

| Komponen | Class/Teknis | Detail |
|----------|--------------|--------|
| Soal block | `.soal-block` | Background abu, radius 12 px |
| Grid pilihan | `.pilihan-grid` | 2×2 CSS grid |
| Tambah soal | `@click="addSoal()"` | Alpine.js reactive |
| Hapus soal | `x-show="soalList.length > 1"` | Tersembunyi jika hanya 1 soal |

#### Psikologi Desain
Form dinamis tanpa reload memberi admin rasa kontrol penuh atas jumlah soal. Isolasi tiap soal dalam blok abu yang terpisah mencegah kebingungan antara soal satu dengan lainnya.

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-12 Laporan Bulanan & Export CSV

**Route**: `GET /admin/laporan` | `GET /admin/laporan/export` | **File**: `admin/laporan/index.blade.php`

```
+--------------------------------------------------------+
| Laporan Bulanan                       [Export CSV]     |
+--------------------------------------------------------+
| [Bulan: Mei v] [Tahun: 2026 v] [Tampilkan]            |
+--------------------------------------------------------+
| No   RW     Total  Organik  Anorg  B3  Angkut Pilah Skor|
| #1   RW 04  680.0  450.0   200.0  30.0  26x   93%   97 |
| #2   RW 02  530.0  350.0   160.0  20.0  22x   91%   94 |
| #3   RW 01  420.5  280.0   120.0  20.5  18x   85%   88 |
+--------------------------------------------------------+
```

#### Fitur
- **Filter bulan + tahun**: submit GET; default bulan dan tahun berjalan
- **Tabel 9 kolom**: Peringkat (emas/perak/perunggu), RW, Total KG, Organik, Anorganik, B3, Pengangkutan, Tingkat Pilah %, Skor
- Terurut skor tertinggi ke terendah
- **Export CSV**: `response()->streamDownload()` — tanpa menyimpan file di server; buka langsung di Excel
- **Super Admin**: semua RW; **Admin RW**: hanya RW sendiri

#### Atribut Komponen

| Komponen | Detail |
|----------|--------|
| Filter | Card form `display:flex` — inline row |
| Export button | `.btn-secondary` abu — aksi sekunder, bukan CTA utama |
| Rank badge | Emas/Perak/Perunggu/Abu — identik dengan mobile |
| Skor | 16 px bold navy — nilai terpenting di tabel |

#### Psikologi Desain
Admin membutuhkan data padat dan akurat, bukan dekorasi. Tabel 9 kolom memberikan semua informasi dalam satu baris per RW — efisien untuk perbandingan antar-RW. Export CSV memenuhi kebutuhan pelaporan ke atasan tanpa perlu akses ke sistem.

#### Pengguna Target
**Super Admin** dan **Admin RW**.

---

### A-13 Daftar & Kirim Notifikasi

**Route**: `GET /admin/notifikasi` | `POST /admin/notifikasi` | **File**: `admin/notifikasi/index.blade.php`, `create.blade.php`

#### Fitur — Daftar
- Tabel: Judul, Tipe, Target RW, Dikirim oleh, Waktu
- Preview pesan 60 karakter
- Badge tipe notifikasi

#### Fitur — Form Kirim

| Field | Tipe | Keterangan |
|-------|------|------------|
| Judul | `text` | required |
| Pesan | `textarea` 4 baris | required |
| Tipe | `select` | `info / jadwal / broadcast` — broadcast hanya untuk super_admin |
| Target Role | `select` | Semua / Warga / Petugas |
| Target RW | `select` | Semua RW atau RW tertentu — hanya super_admin; admin_rw otomatis RW sendiri |

- `NotifikasiService` menyimpan ke tabel `notifikasi` + membuat record `notifikasi_user` untuk setiap penerima

#### Psikologi Desain
Field Target RW yang disembunyikan untuk admin_rw menghilangkan kemungkinan salah kirim ke RW lain — prinsip "least privilege" pada UI. Pembatasan tipe "broadcast" ke super_admin mencegah spam lintas RW.

#### Pengguna Target
**Super Admin** (broadcast semua RW, pilih target) dan **Admin RW** (kirim ke warga/petugas RW sendiri).

---

## 8. Matriks Pengguna × Antarmuka

| Antarmuka | Super Admin | Admin RW | Petugas | Warga |
|-----------|:-----------:|:--------:|:-------:|:-----:|
| M-01 Login | Ya | Ya | Ya | Ya |
| M-02 Registrasi | — | — | — | Ya |
| M-03 Beranda | Ya | Ya | Ya | Ya |
| M-04 Jadwal (lihat) | Ya | Ya | Ya | Ya |
| M-04 Jadwal (aksi: mulai/log/batal) | Ya | Ya | Ya | — |
| M-05 Daftar Edukasi | Ya | Ya | Ya | Ya |
| M-06 Detail Edukasi | Ya | Ya | Ya | Ya |
| M-07 Kuis | Ya | Ya | Ya | Ya |
| M-08 Laporan & Leaderboard | Ya | Ya | Ya | Ya |
| M-09 Profil | Ya | Ya | Ya | Ya |
| M-10 Notifikasi | Ya | Ya | Ya | Ya |
| M-11 Pengaturan | Ya | Ya | Ya | Ya |
| A-01 Dashboard | Ya | Ya | — | — |
| A-02 Daftar User | Ya | Ya* | — | — |
| A-03 Form User | Ya | Ya* | — | — |
| A-04 Daftar Jadwal + Log Bukti | Ya | Ya | — | — |
| A-05 Detail Jadwal + Input Log | Ya | Ya | — | — |
| A-06 Form Buat/Edit Jadwal | Ya | Ya | — | — |
| A-07 Daftar Edukasi | Ya | Ya | — | — |
| A-08 Form Buat/Edit Edukasi | Ya | Ya | — | — |
| A-09 Daftar Kuis | Ya | Ya | — | — |
| A-10 Detail Kuis | Ya | Ya | — | — |
| A-11 Form Buat Kuis | Ya | Ya | — | — |
| A-12 Laporan + Export CSV | Ya | Ya | — | — |
| A-13 Kirim Notifikasi | Ya | Ya | — | — |

> `*` Admin RW hanya dapat melihat dan mengelola data dalam RW sendiri.

---

## 9. Panduan Instalasi

```bash
# 1. Clone repositori
git clone <url-repo>
cd tarunadayavarna

# 2. Salin file environment
cp .env.example .env

# 3. Sesuaikan konfigurasi database di .env
#    DB_DATABASE=tarunadayavarna
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Install dependensi PHP
composer install

# 5. Generate application key
php artisan key:generate

# 6. Jalankan migrasi dan data demo
php artisan migrate --seed

# 7. Buat symbolic link storage
php artisan storage:link

# 8. Jalankan development server
php artisan serve
```

Akses aplikasi:
- **Mobile App**: `http://localhost:8000/app/login`
- **Admin Panel**: Login via `/app/login` dengan akun admin, lalu otomatis redirect ke `/admin/dashboard`

---

## 10. Akun Demo (Seeder)

Semua akun menggunakan password: **`password`**

### Super Admin & Admin RW

| Username | Peran | RW |
|----------|-------|----|
| `superadmin` | Super Admin | — |
| `admin_rw01` | Admin RW | RW 01 |
| `admin_rw02` | Admin RW | RW 02 |
| `admin_rw03` | Admin RW | RW 03 |
| `admin_rw04` | Admin RW | RW 04 |
| `admin_rw05` | Admin RW | RW 05 |

### Petugas (1 per RW)

| Username | RW |
|----------|----|
| `petugas01` | RW 01 |
| `petugas02` | RW 02 |
| `petugas03` | RW 03 |
| `petugas04` | RW 04 |
| `petugas05` | RW 05 |

### Warga (3 per RW = 15 total)

| Username | RW |
|----------|----|
| `warga_rw01_1`, `warga_rw01_2`, `warga_rw01_3` | RW 01 |
| `warga_rw02_1`, `warga_rw02_2`, `warga_rw02_3` | RW 02 |
| `warga_rw03_1`, `warga_rw03_2`, `warga_rw03_3` | RW 03 |
| `warga_rw04_1`, `warga_rw04_2`, `warga_rw04_3` | RW 04 |
| `warga_rw05_1`, `warga_rw05_2`, `warga_rw05_3` | RW 05 |

### Data Demo yang Di-seed

| Data | Jumlah |
|------|--------|
| RW | 5 |
| Jadwal | 25 (5 per RW, status bervariasi) |
| Log pengangkutan | 10 (semua jadwal status `selesai`) |
| Konten edukasi | 6 (2 organik, 2 anorganik, 1 B3 video, 1 daur ulang) |
| Kuis | 2 (masing-masing 5 soal pilihan ganda) |
| Laporan bulanan | 10 (bulan ini + bulan lalu, 5 RW) |
| Notifikasi | 3 (jadwal, info, broadcast — dikirim ke semua warga) |

---

## 11. Prinsip Desain

| Prinsip | Implementasi |
|---------|-------------|
| **Mobile-First** | Shell 390 px fixed di desktop; melebar ke 100 vw ≤ 480 px; tap target 52 px |
| **Progressive Disclosure** | Form input log jadwal hanya muncul saat status `proses`; tombol aksi berdasarkan role dan state |
| **Konsistensi Visual** | Variabel CSS yang sama (`--navy`, `--yellow`, `--green`) digunakan di mobile dan admin |
| **Hierarki Tipografi** | Serif (Cormorant Garamond) untuk pencapaian dan heading; Sans-serif (Plus Jakarta Sans) untuk aksi operasional |
| **Warna Semantik** | 4 status (menunggu/proses/selesai/batal) memiliki warna identik di seluruh sistem |
| **Gamifikasi Ringan** | Skor RW, leaderboard emas/perak/perunggu, statistik kuis di profil |
| **Role-Scoped UI** | Controller memfilter query berdasarkan `rw_id`; Blade menyembunyikan elemen berdasarkan `role` |
| **WCAG AA+** | Semua kombinasi warna utama ≥ 4.5:1 rasio kontras |
| **Logo Konsisten** | SVG custom yang sama digunakan di mobile auth dan admin sidebar |
| **Feedback Instan** | Flash session (`success`/`error`) di setiap POST action; error inline per field |
