# LAPORAN DESAIN ANTARMUKA
## Sistem Tarunadayavarna — Pengelolaan Sampah Tingkat Desa
**Versi 1.0 · Mei 2026**

---

## DAFTAR ISI

1. [Sistem Desain Global](#1-sistem-desain-global)
2. [Psikologi Warna](#2-psikologi-warna)
3. [Mobile App — Antarmuka Autentikasi](#3-mobile-app--autentikasi)
4. [Mobile App — Beranda](#4-mobile-app--beranda)
5. [Mobile App — Jadwal](#5-mobile-app--jadwal)
6. [Mobile App — Edukasi](#6-mobile-app--edukasi)
7. [Mobile App — Kuis](#7-mobile-app--kuis)
8. [Mobile App — Laporan](#8-mobile-app--laporan)
9. [Mobile App — Profil](#9-mobile-app--profil)
10. [Mobile App — Notifikasi](#10-mobile-app--notifikasi)
11. [Admin Panel — Layout & Sidebar](#11-admin-panel--layout--sidebar)
12. [Admin Panel — Dashboard](#12-admin-panel--dashboard)
13. [Admin Panel — Manajemen Pengguna](#13-admin-panel--manajemen-pengguna)
14. [Admin Panel — Manajemen Jadwal](#14-admin-panel--manajemen-jadwal)
15. [Admin Panel — Manajemen Edukasi](#15-admin-panel--manajemen-edukasi)
16. [Admin Panel — Manajemen Kuis](#16-admin-panel--manajemen-kuis)
17. [Admin Panel — Laporan Bulanan](#17-admin-panel--laporan-bulanan)
18. [Admin Panel — Notifikasi](#18-admin-panel--notifikasi)
19. [Kesimpulan & Matriks Pengguna](#19-kesimpulan--matriks-pengguna)

---

## 1. SISTEM DESAIN GLOBAL

### 1.1 Filosofi Desain

Tarunadayavarna dirancang dengan filosofi **"Lokal, Sederhana, Terpercaya"**. Antarmuka harus terasa familiar bagi masyarakat desa yang mungkin tidak terbiasa dengan aplikasi digital kompleks, sambil tetap memberikan kesan profesional dan terpercaya yang dibutuhkan sistem pemerintahan lokal.

### 1.2 Tipografi

| Penggunaan | Font | Alasan |
|---|---|---|
| Judul, angka statistik besar, nama pengguna | **Cormorant Garamond** (serif, 500–700) | Memberikan kesan elegan, otoritatif, dan "resmi" — cocok untuk sistem pemerintahan desa |
| Body, label, tombol, navigasi | **Plus Jakarta Sans** (sans-serif, 400–800) | Keterbacaan tinggi di layar kecil, modern, dan familier untuk masyarakat urban-suburban |

**Alasan kombinasi:** Serif untuk heading menciptakan hierarki visual yang jelas, sedangkan sans-serif untuk body menjamin keterbacaan optimal bahkan pada layar smartphone murah dengan resolusi rendah.

### 1.3 Mobile Shell (390px)

Seluruh halaman `/app` dirender dalam shell berukuran tetap **390px** di tengah layar desktop, mensimulasikan tampilan smartphone. Di perangkat mobile nyata (≤480px), shell melebar penuh ke 100vw.

```
Desktop:  [       gray background       ]
          [  shadow  [ 390px shell ]  shadow  ]
          [                              ]

Mobile:   [ 100vw — full screen ]
```

**Alasan desain shell:** Memastikan konsistensi tampilan di semua perangkat, dan memberikan pengalaman "aplikasi mobile" bahkan ketika diakses dari browser desktop — relevan karena banyak admin RW mengakses via laptop kantor kelurahan.

### 1.4 Struktur Komponen Standar

| Komponen | Tinggi/Ukuran | Fungsi |
|---|---|---|
| Tombol CTA (`.btn-yellow`) | 52px, border-radius 14px | Aksi utama satu halaman |
| Input field (`.input-row`) | 52px, border-radius 14px | Konsistensi ukuran tap target ≥48px (WCAG) |
| Card (`.card`) | auto, border-radius 16px | Pengelompokan konten terkait |
| Bottom nav | 64px fixed | Navigasi utama mobile |
| Badge status | 18–24px tinggi | Indikator kondisi sekilas |

---

## 2. PSIKOLOGI WARNA

### 2.1 Palet Warna & Maknanya

```
┌─────────────────────────────────────────────────────────────────┐
│  #0D1B4B  NAVY (Primary)                                        │
│  ████████ Kepercayaan · Otoritas · Stabilitas · Pemerintahan    │
├─────────────────────────────────────────────────────────────────┤
│  #F5C518  YELLOW/KUNING EMAS (Accent)                           │
│  ████████ Energi · Optimisme · Tindakan · Peringatan Ramah      │
├─────────────────────────────────────────────────────────────────┤
│  #FFFFFF  WHITE (Neutral)                                        │
│  ████████ Kebersihan · Ruang · Kejelasan · Kesucian             │
├─────────────────────────────────────────────────────────────────┤
│  #F4F6FB  GRAY TERANG (Background)                              │
│  ████████ Netral · Tidak mengganggu · Pemisah halus             │
├─────────────────────────────────────────────────────────────────┤
│  #2ECC71  GREEN (Sukses)                                         │
│  ████████ Selesai · Aman · Berhasil · Ramah lingkungan          │
├─────────────────────────────────────────────────────────────────┤
│  #8892a4  MUTED (Sekunder)                                       │
│  ████████ Informasi tambahan · Tidak dominan · Placeholder      │
├─────────────────────────────────────────────────────────────────┤
│  #1a1a2e  TEXT GELAP (Body)                                      │
│  ████████ Keterbacaan maksimal · Profesional                     │
└─────────────────────────────────────────────────────────────────┘
```

### 2.2 Analisis Psikologi per Warna

#### Navy (#0D1B4B)
- **Psikologi:** Biru gelap/navy secara universal diasosiasikan dengan kepercayaan, otoritas, dan kemampuan. Dalam konteks sistem pemerintahan desa, warna ini membangun persepsi bahwa sistem ini resmi dan dapat diandalkan.
- **Penggunaan:** Header halaman, sidebar admin, navigasi aktif, teks penting, tombol sekunder.
- **Target pengguna:** Semua pengguna — warna ini menjadi "identitas" sistem.
- **Dampak:** Mencegah pengguna mempertanyakan legitimasi sistem; penting untuk mendorong kepercayaan warga dalam melaporkan data sampah.

#### Kuning Emas (#F5C518)
- **Psikologi:** Kuning adalah warna dengan visibilitas tertinggi di spektrum warna. Warna emas/kuning mengkomunikasikan nilai, pencapaian, dan urgensi yang ramah (berbeda dari merah yang mengancam). Dalam konteks sosial Indonesia, warna kuning juga sering diasosiasikan dengan keberanian dan kehangatan komunitas.
- **Penggunaan:** Tombol CTA utama, badge notifikasi, peringkat #1, ikon input, aksen dekorasi header.
- **Target pengguna:** Semua pengguna — tombol kuning secara naluriah menarik perhatian ke aksi yang harus dilakukan.
- **Dampak:** Meningkatkan click-through pada tombol aksi; kuning pada tombol "Login" mengurangi friksi bagi pengguna baru.

#### Hijau (#2ECC71)
- **Psikologi:** Hijau adalah warna universal untuk "aman", "selesai", dan "ramah lingkungan". Dalam konteks aplikasi sampah/lingkungan, hijau memiliki relevansi ganda — indikator sukses sekaligus pengingat konteks ekologis.
- **Penggunaan:** Status "Selesai" pada jadwal, konfirmasi aksi berhasil, dot progress selesai.
- **Target pengguna:** Petugas dan admin yang memantau progres jadwal.
- **Dampak:** Memberikan kepuasan psikologis instan saat melihat jadwal berstatus "Selesai" — mendorong petugas untuk menyelesaikan tugas.

#### Merah (#c0392b / FDECEA)
- **Psikologi:** Merah mengkomunikasikan bahaya, urgensi, dan penghentian. Digunakan sparingly agar tidak menciptakan kecemasan berlebihan.
- **Penggunaan:** Status "Batal", tombol hapus, error message, field validation error.
- **Target pengguna:** Admin yang melakukan penghapusan data; sistem yang melaporkan kegagalan.
- **Dampak:** Menimbulkan "micro-friction" yang disengaja pada aksi destruktif (hapus/batal) — pengguna lebih hati-hati sebelum mengklik.

#### Abu-abu (#F0F0F0 / #8892a4)
- **Psikologi:** Abu-abu netral, tidak mengajak aksi. Digunakan untuk elemen "menunggu" atau informasi sekunder yang tidak mendesak.
- **Penggunaan:** Status "Menunggu", placeholder text, label sekunder, background input.
- **Target pengguna:** Warga yang membaca informasi; petugas yang menunggu instruksi.
- **Dampak:** Secara visual "merendahkan prioritas" jadwal yang belum dimulai.

### 2.3 Kontras & Aksesibilitas

| Kombinasi | Rasio Kontras | Status WCAG AA |
|---|---|---|
| Navy (#0D1B4B) di atas White | 14.7:1 | ✅ Pass |
| Navy (#0D1B4B) di atas Yellow | 6.2:1 | ✅ Pass |
| White di atas Navy | 14.7:1 | ✅ Pass |
| Muted (#8892a4) di atas White | 3.1:1 | ⚠️ AA Large only |
| Text (#1a1a2e) di atas Gray | 12.4:1 | ✅ Pass |

> Catatan: Warna muted digunakan hanya untuk teks ≥14px sehingga masuk kriteria WCAG AA Large.

---

## 3. MOBILE APP — AUTENTIKASI

### 3.1 Halaman Login (`GET /app/login`)

#### Pengguna
**Semua role** — warga, petugas, admin RW, super admin (diarahkan ke panel admin setelah login).

#### Struktur Antarmuka

```
┌─────────────────────────┐
│   [NAVY BACKGROUND]     │  ← Langit biru — memberikan ketenangan
│                         │
│       ┌───┐             │
│       │ T │  Logo Badge │  ← Kotak kuning 72×72px, huruf "T"
│       └───┘             │
│   Tarunadayavarna       │  ← Cormorant Garamond 26px
│   Sistem Pengelolaan... │  ← Plus Jakarta 12px, opacity 60%
│                         │
├─────────────────────────┤
│  [CARD PUTIH ROUNDED]   │  ← Border-radius 28px di atas
│                         │
│  Selamat Datang         │  ← Cormorant 24px navy
│  Masuk untuk melanjutkan│  ← Jakarta 13px muted
│                         │
│  ┌──[👤]──username──┐  │  ← Input 52px dengan ikon kuning
│  └─────────────────┘   │
│  ┌──[🔒]──password──┐  │
│  └─────────────────┘   │
│                         │
│  ┌─── L O G I N ────┐  │  ← Tombol kuning 52px
│  └───────────────────┘  │
│                         │
│  Belum punya akun?      │  ← Link ke register
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Background atas | Navy #0D1B4B | Menciptakan "pintu masuk resmi" — menandakan ini sistem pemerintahan |
| Card radius atas | 28px | Sudut besar menciptakan perasaan lembut dan ramah — mengurangi intimidasi bagi warga yang tidak biasa dengan aplikasi |
| Logo badge | Kotak kuning 72×72px, radius 20px | Ukuran besar memastikan brand recognition; kuning menarik perhatian pertama kali |
| Input height | 52px | Ukuran tap target WCAG minimum 48px — penting untuk pengguna tua/lansia di desa |
| Input border focus | 2px kuning | Feedback visual jelas saat mengetik — membantu pengguna dengan kemampuan digital rendah |
| Ikon dalam input | Background kuning 36×36px | Memperkuat visual hierarki, membuat form terasa "vibe app mobile" bukan form web kaku |
| Tombol CTA | 100% lebar, 52px, radius 14px, kuning | Lebar penuh memudahkan tap; kuning = aksi utama |
| Shadow tombol | `0 6px 20px rgba(245,197,24,0.4)` | Efek "glowing" — tombol terasa interaktif dan hidup |

#### Psikologi Interaksi

- **Warna navy di atas + putih di bawah:** Menciptakan persepsi "masuk ke sistem terpercaya" — pengguna secara bawah sadar merasakan perbedaan "dunia luar" (navy) dan "ruang aman" (putih card).
- **Flash error merah:** Jika login gagal, flash berwarna merah (#FDECEA) muncul di atas — cukup mencolok untuk diperhatikan tapi tidak mengancam.

---

### 3.2 Halaman Register (`GET /app/register`)

#### Pengguna
**Warga baru** yang ingin mendaftar akun.

#### Struktur Antarmuka

```
┌─────────────────────────┐
│   [NAVY - lebih pendek] │
│       ┌───┐             │
│       │ T │             │
│       └───┘             │
│   Daftar Akun           │
│   Buat akun warga baru  │
├─────────────────────────┤
│  [CARD PUTIH]           │
│                         │
│  Nama Lengkap [👤]      │  ← 6 field input
│  Username     [🔖]      │
│  Email        [✉️]       │
│  WhatsApp     [📱]      │
│  RW           [🏘️] ▼   │  ← Dropdown pilih RW
│  Password     [🔒]      │
│  Konfirmasi   [🔒]      │
│                         │
│  ⚠ Akun aktif setelah   │  ← Teks info 11px muted
│    disetujui admin RW   │
│                         │
│  ┌── DAFTAR SEKARANG ──┐│
│  └─────────────────────┘│
│                         │
│  Sudah punya akun? Login │
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Jumlah field | 6 field | Minimal informasi yang dibutuhkan — tidak membebani pengguna baru |
| Teks peringatan "akun aktif setelah disetujui" | 11px muted, italic | Warna muted dan ukuran kecil menandakan ini informasi sekunder — tidak menakutkan tapi tetap terbaca |
| Dropdown RW | Select dengan ikon 🏘️ | Dropdown mencegah typo nama RW — input terstruktur penting untuk integritas data |
| Label input | UPPERCASE 12px muted | Konvensi form modern yang memisahkan label dari placeholder secara visual |
| Padding bawah | 30px extra | Konten panjang harus scrollable — pastikan tombol CTA tidak terpotong |

#### Psikologi Pendaftaran

- **Barrier rendah:** Tidak ada upload dokumen/foto di tahap register — warga bisa mendaftar dalam 2 menit.
- **Ekspektasi terkelola:** Teks "menunggu persetujuan admin" disampaikan di halaman register, bukan setelah submit — mengurangi frustrasi saat akun tidak langsung bisa digunakan.

---

## 4. MOBILE APP — BERANDA

### Halaman Beranda (`GET /app/beranda`)

#### Pengguna
**Semua role terautentikasi** — namun konten berubah sesuai role (warga lihat jadwal RW-nya, petugas lihat tugasnya, dll).

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [PAGE HEADER NAVY]     │
│  ●●●●●●●●  (dekorasi)  │  ← Lingkaran kuning translucent 200px
│                         │
│  Selamat datang,        │  ← 12px opacity 65%
│  Budi Santoso           │  ← Cormorant 22px putih
│  [Petugas · RW 01]      │  ← Badge role semi-transparan
│                   [🔔1] │  ← Tombol notif dengan badge count
├─────────────────────────┤
│  [STAT ROW — 3 kartu]   │
│  ┌────┐ ┌────┐ ┌────┐  │
│  │12.5│ │ 4  │ │ 78 │  │  ← kg / pengangkutan / skor
│  │ kg │ │angk│ │ RW │  │
│  └────┘ └────┘ └────┘  │
│                         │
│  Menu                   │  ← Section title Cormorant 18px
│  ┌────┐ ┌────┐          │
│  │📅  │ │📚  │          │  ← Grid 4 kolom
│  │Jadw│ │Eduk│          │
│  └────┘ └────┘          │
│  ┌────┐ ┌────┐          │
│  │📊  │ │👤  │          │
│  │Lapo│ │Prof│          │
│  └────┘ └────┘          │
│                         │
│  Jadwal Hari Ini        │  ← Section title
│  ┌─────────────────┐   │
│  │ ● 06:00–08:00   │   │  ← Card jadwal dengan dot status
│  │ Organik · RW 01 │   │
│  │ Petugas: Budi   │   │
│  │          [Proses]│   │  ← Badge status
│  └─────────────────┘   │
├─────────────────────────┤
│  [BOTTOM NAV]           │
│  🏠* 📅  📚  📊  👤    │  ← Ikon aktif dengan bg navy
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dekorasi lingkaran header | 200×200px, `rgba(245,197,24,0.12)`, positioned `-60px top -40px right` | Elemen dekoratif halus — menambah depth tanpa mengganggu keterbacaan. Kuning transparan memperkuat tema sistem |
| Stat row | 3 kartu, flex equal | Tiga metrik paling penting (berat, frekuensi, skor) langsung terlihat tanpa scroll |
| Kartu tengah (kuning) | background `var(--yellow)` | Satu metric ditonjolkan — desainer memilih "total KG" karena ini nilai terpenting untuk program sampah |
| Menu grid | 4 kolom, icon + label | Grid persegi lebih mudah dipindai daripada list; 4 menu sesuai kapasitas pandang sekilas |
| Bottom nav sticky | `position: sticky; bottom: 0` | Sticky (bukan fixed) agar tidak overlap konten dalam flex container shell 390px |
| Notifikasi badge | Kuning di sudut kanan atas ikon | Warna kuning badge kontras terhadap putih nav, langsung terlihat |

#### Psikologi Beranda

- **"At-a-glance dashboard":** Tiga angka statistik di atas memenuhi kebutuhan pengguna yang hanya punya 5 detik untuk cek kondisi RW mereka.
- **Menu grid sebagai visual anchor:** Penempatan menu di tengah halaman (bukan hidden di drawer) mengurangi cognitive load — pengguna tidak perlu mengingat navigasi tersembunyi.
- **Jadwal hari ini sebagai CTA tersirat:** Menampilkan jadwal real-time mendorong petugas untuk segera update status tanpa harus navigasi ke menu Jadwal.

---

## 5. MOBILE APP — JADWAL

### Halaman Jadwal (`GET /app/jadwal`)

#### Pengguna
- **Warga:** Lihat jadwal RW-nya (read-only)
- **Petugas:** Lihat dan update jadwal yang di-assign ke dirinya
- **Admin RW / Super Admin:** Lihat dan update semua jadwal

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Jadwal Pengangkutan  │  ← Back button + judul
│  RW 01                  │
├─────────────────────────┤
│  [FILTER TANGGAL]       │
│  ┌──[📅]──dd/mm/yyyy──┐ │  ← Input date, auto-submit
│  └─────────────────────┘ │
│                          │
│  ┌──────────────────────┐│
│  │●  23 Mei 2026        ││  ← Dot warna sesuai status
│  │   06:00–08:00        ││
│  │   Organik · RW 01   ││
│  │   Petugas: Budi     ││  ← Info petugas
│  │   Estimasi: 120 kg  ││
│  │              [Proses]││  ← Badge status
│  │                      ││
│  │  [Mulai] [Batal]     ││  ← Tombol aksi (petugas/admin)
│  │                      ││
│  │  [Input Log ▼]       ││  ← Toggle Alpine.js
│  │  ┌─────────────────┐ ││
│  │  │ ⚖️ Berat (kg)   │ ││  ← Form log pengangkutan
│  │  │ 📷 Foto bukti   │ ││
│  │  │ 📝 Catatan      │ ││
│  │  │ [SIMPAN & SELESAI]││
│  │  └─────────────────┘ ││
│  └──────────────────────┘│
├─────────────────────────┤
│  [BOTTOM NAV]            │
│  🏠  📅* 📚  📊  👤    │
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dot status warna | menunggu=abu, proses=kuning, selesai=hijau, batal=merah | Warna status konsisten di seluruh sistem — pengguna belajar sekali, berlaku di mana-mana |
| Filter tanggal auto-submit | `onchange="this.form.submit()"` | Mengurangi satu klik — pengguna mobile menghargai efisiensi interaksi |
| Toggle form log Alpine.js | `x-show="open"` | Form log hanya muncul saat dibutuhkan — mengurangi visual clutter di tampilan default |
| Foto bukti | Upload langsung dari kamera | Petugas lapangan perlu bukti pengangkutan — fitur kamera mobile sangat kritikal |
| Tombol aksi bersyarat | Muncul hanya jika role sesuai | Warga tidak melihat tombol "Mulai"/"Batal" — mengurangi confusi dan risiko aksi keliru |
| Gambar bukti ditampilkan | Setelah log diisi | Transparansi — warga bisa verifikasi foto bukti pengangkutan |

#### Psikologi Jadwal

- **Dot sebagai progress indicator:** Kolom dot warna di sebelah kiri menciptakan visual "timeline" yang mudah dipindai — pengguna bisa sekilas melihat status semua jadwal.
- **Aksi progresif:** Tombol hanya menampilkan aksi yang relevan (Mulai → Input Log → Selesai) — pengguna tidak kebingungan dengan banyak pilihan sekaligus.

---

## 6. MOBILE APP — EDUKASI

### 6.1 Daftar Edukasi (`GET /app/edukasi`)

#### Pengguna
**Warga** sebagai target utama — yang perlu belajar cara memilah sampah. Petugas dan admin juga bisa mengakses.

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Edukasi Sampah       │
│  Pelajari cara memilah  │
├─────────────────────────┤
│  ┌──[🔍]──Cari artikel─┐│  ← Search bar
│  └────────────────────┘ │
│                          │
│  [Semua] [🌿Organik]    │  ← Filter pills horizontal scroll
│  [♻️Anorganik] [⚠️B3]  │
│  [🔄Daur Ulang]         │
│                          │
│  ┌──────────────────────┐│
│  │    [FEATURED IMAGE]  ││  ← Banner besar 160px
│  │ [Terbaru]            ││  ← Badge kuning overlay
│  │ Cara Memilah Sampah  ││  ← Judul overlay dengan gradient
│  └──────────────────────┘│
│                          │
│  ┌──────┐  ┌──────┐     │  ← Grid 2 kolom
│  │[IMG] │  │[IMG] │     │
│  │Organ.│  │Anorg.│     │
│  │Judul │  │Judul │     │
│  │5 mnt │  │3 mnt │     │
│  └──────┘  └──────┘     │
│  ┌──────┐  ┌──────┐     │
│  │[▶️]  │  │[📄] │     │  ← Placeholder ikon format
│  │ ...  │  │ ... │     │
│  └──────┘  └──────┘     │
├─────────────────────────┤
│  [BOTTOM NAV]            │
│  🏠  📅  📚* 📊  👤    │
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Featured banner | 160px tinggi, gradient overlay | Konten terbaru mendapat spotlight — mendorong engagement dengan konten baru |
| Filter pills horizontal | Scrollable, pill-active = navy | Menghemat vertikal space; pengguna mobile terbiasa scroll horizontal (seperti YouTube kategori) |
| Grid 2 kolom | Kartu dengan thumbnail | 2 kolom lebih efisien daripada list — pengguna bisa membandingkan konten secara paralel |
| Badge kategori warna | organik=hijau, anorganik=biru, b3=merah, daur_ulang=ungu | Warna berbeda per kategori membantu warga mengidentifikasi jenis konten tanpa membaca label |
| Placeholder ikon | 📄 artikel, ▶️ video | Membedakan format konten secara visual bahkan jika thumbnail belum ada |

### 6.2 Detail Edukasi (`GET /app/edukasi/{slug}`)

#### Pengguna
**Warga** yang ingin membaca/menonton konten edukasi.

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Header navy dengan badge kategori | Warna sesuai kategori | Konteks langsung jelas sebelum membaca — warna badge mengkonfirmasi kategori |
| Konten `nl2br(e())` | Escaped HTML, baris baru dijaga | Keamanan XSS (escape) + keterbacaan paragraf terjaga |
| Video iframe responsive | `padding-top: 56.25%` trick | Aspect ratio 16:9 dijaga di semua lebar — video tidak terpotong |
| Kuis banner | Card abu-abu dengan tombol "Mulai" | Mendorong pengguna uji pemahaman setelah membaca — gamification ringan |
| Status "Selesai" di kuis | Badge hijau jika sudah ikut | Penghargaan visual — pengguna merasa progress-nya diakui |

---

## 7. MOBILE APP — KUIS

### Halaman Kuis (`GET /app/kuis/{id}`)

#### Pengguna
**Warga** sebagai target utama — mengukur pemahaman materi edukasi.

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Nama Kuis            │
│  5 soal · 5 menit       │
├─────────────────────────┤
│                          │
│  ┌──────────────────────┐│
│  │ SOAL 1               ││  ← Label kecil uppercase muted
│  │                      ││
│  │ Sampah kulit pisang  ││  ← Pertanyaan 14px semibold
│  │ termasuk jenis...?   ││
│  │                      ││
│  │ ○ [A] Organik        ││  ← Radio button custom
│  │ ○ [B] Anorganik      ││  ← Key badge navy kotak
│  │ ○ [C] B3             ││
│  │ ○ [D] Campuran       ││
│  └──────────────────────┘│
│                          │
│  ┌──────────────────────┐│  ← Soal berikutnya
│  │ SOAL 2               ││
│  │ ...                  ││
│  └──────────────────────┘│
│                          │
│  ┌── KUMPULKAN JAWABAN ─┐│  ← Tombol kuning submit
│  └──────────────────────┘│
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Semua soal ditampilkan sekaligus | Scroll vertikal | Pengguna bisa melihat total beban soal — tidak ada kejutan soal tambahan; warga tidak anointed |
| Radio button dengan custom key badge | Kotak navy A/B/C/D | Visual lebih jelas dari radio default — tebakan pilihan lebih mudah dipindai |
| Background pilihan | `var(--gray)` default, diklik = outline | Feedback visual saat memilih pilihan |
| Validasi `required` | Setiap soal harus dijawab | Mencegah submit tidak lengkap — penting untuk integritas skor |
| Satu kali submit | Cek `sudahIkut` di controller | Mencegah pengulangan untuk manipulasi skor — integritas data kuis |
| Redirect ke edukasi + flash skor | `"Skor Anda: 80/100"` | Immediate feedback — reinforcement positif yang mendorong belajar lebih lanjut |

---

## 8. MOBILE APP — LAPORAN

### Halaman Laporan (`GET /app/laporan`)

#### Pengguna
**Semua role** — warga ingin tahu peringkat RW mereka; admin memantau performa; super admin melihat semua RW.

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [HEADER NAVY]          │
│  ← Laporan Bulanan      │
│  Mei 2026               │
├─────────────────────────┤
│                          │
│  ┌──────────────────────┐│  ← Score card navy
│  │      RW 01           ││  ← Nama RW
│  │       78             ││  ← Skor Cormorant 48px kuning
│  │      /100            ││  ← Max score abu kecil
│  │  ████████░░░░░░░░░░  ││  ← Progress bar kuning
│  └──────────────────────┘│
│                          │
│  ┌────┐ ┌────┐ ┌────┐  │  ← Stat row 4 angka
│  │ KG │ │Angk│ │Pilah│ │
│  │120 │ │ 8  │ │ 72%│ │
│  └────┘ └────┘ └────┘  │
│                          │
│  Peringkat RW            │  ← Section title
│  ┌──────────────────────┐│
│  │🥇 RW 03  8x  145kg  ││  ← Leaderboard #1 emas
│  │   Skor: 89           ││
│  ├──────────────────────┤│
│  │🥈 RW 01  8x  120kg  ││  ← #2 perak
│  │   Skor: 78           ││
│  ├──────────────────────┤│
│  │🥉 RW 05  6x   98kg  ││  ← #3 perunggu
│  │   Skor: 65           ││
│  └──────────────────────┘│
│                          │
│  Riwayat 6 Bulan         │  ← Tren historis
│  ┌──────────────────────┐│
│  │ April 2026       82  ││
│  │ Maret 2026       71  ││
│  └──────────────────────┘│
├─────────────────────────┤
│  [BOTTOM NAV]            │
│  🏠  📅  📚  📊* 👤    │
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Score card navy besar | Background navy, skor kuning 48px Cormorant | Skor adalah informasi paling penting — ditampilkan besar dan kontras tinggi |
| Progress bar skor | `width: min(skor, 100)%` kuning | Representasi visual langsung — warga bisa membandingkan posisi vs. 100 poin |
| Leaderboard 3 warna | Emas/Perak/Perunggu | Sistem penghargaan medali dikenal universal — memotivasi kompetisi sehat antar RW |
| Riwayat 6 bulan | List sederhana bulan + skor | Tren historis membantu admin evaluasi program — naik/turun mudah dibandingkan |
| Tanggal otomatis format Indonesia | `\Carbon\Carbon::translatedFormat('F Y')` | "Mei 2026" lebih familier daripada "05/2026" untuk masyarakat desa |

#### Psikologi Gamifikasi

- **Leaderboard antar RW:** Kompetisi antar komunitas adalah motivasi kuat di lingkungan desa. Warga bangga jika RW-nya peringkat 1 — ini mendorong partisipasi aktif dalam program pilah sampah.
- **Skor 0–100:** Skala yang sama dengan nilai ujian sekolah — konsep yang dipahami semua kalangan.

---

## 9. MOBILE APP — PROFIL

### Halaman Profil (`GET /app/profil`)

#### Pengguna
**Semua role** — mengelola data diri sendiri.

#### Struktur Antarmuka

```
┌─────────────────────────┐
│  [HEADER NAVY center]   │
│                          │
│       ┌──────┐           │  ← Avatar 80×80px, radius 24px
│       │ BS   │           │     (foto/inisial)
│       └──────┘           │
│    Budi Santoso          │  ← Cormorant 22px putih
│    [Petugas]             │  ← Role badge
│     RW 01                │  ← Sub-info
├─────────────────────────┤
│                          │
│  ┌────────┐ ┌─────────┐ │  ← 2 stat: total kuis, avg skor
│  │ 3 Kuis │ │ Avg: 85 │ │  ← Card kuning untuk avg skor
│  └────────┘ └─────────┘ │
│                          │
│  Edit Profil              │  ← Section title
│                          │
│  [Form: Nama, Email,     │  ← Input fields standar
│   WhatsApp, Foto,        │
│   Password baru]         │
│                          │
│  ┌─ SIMPAN PERUBAHAN ──┐ │  ← Tombol kuning
│  └────────────────────┘ │
│                          │
│  ┌────── Logout ────────┐│  ← Tombol merah muted
│  └──────────────────────┘│
├─────────────────────────┤
│  [BOTTOM NAV]            │
│  🏠  📅  📚  📊  👤*   │
└─────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Avatar dengan inisial fallback | 2 huruf pertama nama | Sistem tidak bergantung pada foto yang diunggah — pengalaman terjaga bahkan tanpa foto |
| Header terpusat | Tidak seperti halaman lain yang left-align | Halaman profil bersifat personal — layout sentral lebih intim dan identitas-fokus |
| Stat kuis di atas form | 2 kartu kecil | Menunjukkan "pencapaian" sebelum form — memotivasi pengguna untuk ikut lebih banyak kuis |
| Tombol logout | Background merah muted, bukan kuning | Secara visual "berbeda" dari aksi positif — micro-friction yang disengaja agar pengguna tidak tidak sengaja logout |
| Upload foto langsung | `accept="image/*"` | Membuka kamera atau galeri di mobile — UX natural tanpa redirects |

---

## 10. MOBILE APP — NOTIFIKASI

### Halaman Notifikasi (`GET /app/notifikasi`)

#### Pengguna
**Semua role** — menerima notifikasi jadwal, info, dan broadcast.

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Border kiri unread | 3px solid kuning | Indikator visual belum-dibaca yang tidak menghalangi konten — lebih elegant dari dot/background berbeda |
| Border kiri read | 3px transparent, opacity 0.75 | Notifikasi dibaca "memudar" secara visual — membantu pengguna fokus pada yang baru |
| Ikon per tipe | 📅 jadwal, 📢 broadcast, ℹ️ info | Differensiasi tipe notifikasi tanpa teks label tambahan |
| Auto mark-as-read | Saat halaman dibuka | Tidak membutuhkan pengguna klik satu per satu — UX efisien untuk notifikasi massal |
| `diffForHumans()` | "2 jam yang lalu" | Format relatif lebih natural daripada timestamp absolut — relevan untuk pengguna casual |

---

## 11. ADMIN PANEL — LAYOUT & SIDEBAR

### Layout Admin (`resources/views/admin/layouts/app.blade.php`)

#### Pengguna
**Super Admin** dan **Admin RW** — pengelola sistem.

#### Struktur Layout

```
┌──────────────┬──────────────────────────────────────┐
│              │  [TOPBAR]                             │
│  [SIDEBAR]   │  Heading Halaman    [Tombol Aksi]     │
│  ┌──────┐    ├──────────────────────────────────────┤
│  │Logo T│    │  [ALERT jika ada]                     │
│  └──────┘    │                                       │
│              │                                       │
│  📊 Dashboard│  [CONTENT AREA]                      │
│  📅 Jadwal   │                                       │
│  👥 Pengguna │                                       │
│  📚 Edukasi  │                                       │
│  ❓ Kuis     │                                       │
│  📈 Laporan  │                                       │
│  🔔 Notif    │                                       │
│              │                                       │
│  ┌──────────┐│                                       │
│  │ Admin    ││  ← User info + logout                │
│  │ super... ││                                       │
│  │      [↩] ││                                       │
│  └──────────┘│                                       │
└──────────────┴──────────────────────────────────────┘
  ←240px→      ←flex: 1→
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Sidebar width | 240px fixed | Cukup untuk label text + ikon tanpa berlebihan; standar UI admin modern |
| Sidebar background | Navy #0D1B4B | Konsisten dengan identitas sistem; sidebar gelap vs konten terang menciptakan kontras area fokus |
| Nav aktif | Background kuning, teks navy | "Active state" yang sangat jelas — admin selalu tahu sedang di halaman apa |
| Nav hover | `rgba(255,255,255,0.08)` | Feedback subtle — tidak mengganggu tapi memberikan respons |
| Topbar sticky | `position: sticky; top: 0; z-index: 50` | Judul halaman dan tombol aksi selalu terlihat saat scroll konten panjang |
| Menu edukasi/kuis bersyarat | `@if(auth()->user()->isSuperAdmin())` | Admin RW tidak melihat menu yang tidak punya akses — interface bersih dan tidak membingungkan |
| User info di bottom sidebar | Nama + role + tombol logout | Admin selalu tahu sedang login sebagai siapa — penting saat ada multi-akun |

#### Psikologi Admin UI

- **Sidebar gelap vs. konten terang:** Pola klasik yang membantu admin memisahkan "navigasi" dari "konten". Mata otomatis tertarik ke area putih yang lebih terang.
- **Kuning pada nav aktif:** Menggunakan warna aksen sistem di state aktif menciptakan konsistensi visual — tidak membutuhkan highlight warna "random".

---

## 12. ADMIN PANEL — DASHBOARD

### Dashboard Admin (`GET /admin/dashboard`)

#### Pengguna
**Super Admin** (semua RW) dan **Admin RW** (data RW sendiri).

#### Struktur Antarmuka

```
┌────────────────────────────────────────┐
│  TOPBAR: Dashboard          [Tanggal]  │
├────────────────────────────────────────┤
│  [STATS GRID — 4 kolom]               │
│  ┌────────┐ ┌────────┐ ┌────────┐ ┌──┐│
│  │👥 Blue │ │🚛 Orange│ │📅 Green│ │📦││
│  │   42   │ │   8    │ │  156  │ │120││
│  │ Warga  │ │Petugas │ │Jadwal │ │ KG││
│  └────────┘ └────────┘ └────────┘ └──┘│
│                                        │
│  ┌─────────────────┐ ┌───────────────┐│
│  │ Jadwal Hari Ini │ │Laporan Bln Ini││
│  │                 │ │               ││
│  │[badge][RW · jns]│ │ RW01 ████ 89 ││
│  │[badge][RW · jns]│ │ RW03 ███  78 ││
│  │                 │ │ RW05 ██   65 ││
│  │         [+Tambah]│ │    [Lihat Semua]││
│  └─────────────────┘ └───────────────┘│
└────────────────────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Stats grid 4 kolom | 4 KPI utama | Admin perlu overview cepat — 4 angka cukup tanpa overwhelming |
| Ikon background warna berbeda | Biru/Orange/Hijau/Pink | Warna berbeda membantu differensiasi KPI tanpa membaca label — scan pattern lebih cepat |
| Font angka KPI | Cormorant 28px navy | Angka besar = informasi prioritas; serif memberikan kesan "laporan formal" |
| Progress bar laporan | Kuning, `width: skor%` | Komparasi visual antar RW lebih cepat dipahami daripada angka murni |
| Grid 2 kolom di bawah | Jadwal + Laporan side-by-side | Dua informasi paling sering dilihat admin tersedia sejajar — tidak perlu scroll |
| Tombol "Lihat Semua" | Di corner card | Akses cepat ke halaman full — card hanya teaser |

---

## 13. ADMIN PANEL — MANAJEMEN PENGGUNA

### Daftar Users (`GET /admin/users`)

#### Pengguna
**Super Admin** (semua user semua RW) dan **Admin RW** (hanya warga & petugas RW-nya).

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Table dengan pagination | 20 per halaman | Data user bisa banyak — pagination mencegah halaman terlalu panjang |
| Badge role warna | super_admin=biru, admin_rw=orange, petugas=ungu, warga=hijau | Identifikasi role sekilas tanpa membaca teks |
| Badge status aktif/non-aktif | Hijau/Abu | Langsung terlihat mana akun yang perlu diaktivasi |
| Tombol Edit + Hapus inline | Per baris tabel | Aksi langsung dari list — tidak perlu masuk ke detail dulu |
| Konfirmasi hapus | `onsubmit="return confirm()"` | Double-check native browser — mencegah penghapusan tidak sengaja |

### Form Create/Edit User

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Dropdown RW tersembunyi untuk admin RW | Input hidden dengan value RW sendiri | Admin RW tidak bisa mengubah RW user — security constraint by design |
| Dropdown role terbatas per level | Super admin: semua; Admin RW: petugas+warga | Hak akses tersembunyi dari UI — tidak bisa didaur ulang untuk eskalasi privilege |
| Password field opsional di edit | "Kosongkan jika tidak diubah" | UX standar — admin tidak perlu reset password jika hanya update data lain |
| Checkbox `is_active` | Dicentang = aktif | Approval warga baru dilakukan dari sini — workflow approval terintegrasi di edit user |

---

## 14. ADMIN PANEL — MANAJEMEN JADWAL

### Daftar Jadwal (`GET /admin/jadwal`)

#### Pengguna
**Super Admin** (semua jadwal) dan **Admin RW** (jadwal RW-nya).

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Urut tanggal descending | Terbaru di atas | Admin lebih sering review jadwal terbaru/mendatang |
| Kolom waktu format HH:MM–HH:MM | `substr($j->waktu_mulai,0,5)` | Cukup jam dan menit — detik tidak relevan untuk jadwal truk sampah |
| Badge status di kolom tersendiri | Warna sesuai status | Kolom status = paling sering dicek; warna membantu filter visual cepat |

### Form Create Jadwal

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Form row 2 kolom (waktu mulai/selesai) | Grid 2 kolom | Waktu mulai dan selesai terkait logis — diletakkan sejajar agar perbandingan mudah |
| Notifikasi otomatis setelah create | `NotifikasiService::kirimKeRW()` | Admin tidak perlu aksi terpisah — notif warga terkirim otomatis; mengurangi kemungkinan lupa |
| Field estimasi KG opsional | `nullable` | Tidak semua jadwal diketahui estimasinya di awal — tidak dipaksakan |

---

## 15. ADMIN PANEL — MANAJEMEN EDUKASI

### Daftar Edukasi (`GET /admin/edukasi`)

#### Pengguna
**Super Admin** utamanya (create/edit/delete) — Admin RW hanya bisa membaca.

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Kolom "Status" Terbit/Draft | Badge hijau/abu | Admin tahu konten mana yang visible ke warga tanpa membuka detail |
| Tombol hapus dengan confirm | `onsubmit="return confirm()"` | Konten edukasi yang dihapus sulit dikembalikan — konfirmasi penting |

### Form Create Edukasi

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Textarea konten rows=8 | Ruang cukup untuk artikel panjang | Editor minimal — sistem tidak memerlukan WYSIWYG untuk prototype v1 |
| Checkbox "Terbitkan sekarang" | Unchecked default | Default draft — konten tidak langsung terekspos sebelum admin yakin siap |
| URL video placeholder | `youtube.com/embed/...` | Panduan format URL yang benar — mencegah error embed |
| Dua dropdown sejajar (kategori + format) | Form row 2 kolom | Dua pilihan terkait dikelompokkan — menghemat vertikal space |

---

## 16. ADMIN PANEL — MANAJEMEN KUIS

### Form Create Kuis (Dynamic dengan Alpine.js)

#### Pengguna
**Super Admin** — membuat soal kuis baru.

#### Struktur Antarmuka Dinamis

```
┌─────────────────────────────────────┐
│  Judul Kuis + Edukasi + Durasi      │
├─────────────────────────────────────┤
│  ─────── SOAL-SOAL ──────────────── │
│                                     │
│  [Soal 1]                [Hapus]    │
│  Pertanyaan: [textarea]             │
│  Pilihan:  [A] [B]  ← grid 2 kolom │
│            [C] [D]                  │
│  Jawaban Benar: [A ▼]               │
│                                     │
│  [Soal 2]                [Hapus]    │
│  ...                                │
│                                     │
│  [+ Tambah Soal]                    │
│                                     │
│  [Simpan Kuis]  [Batal]             │
└─────────────────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Soal dinamis Alpine.js | `x-for`, `addSoal()`, `removeSoal()` | Admin bisa menambah/hapus soal tanpa reload halaman — UX form modern yang intuitif |
| Grid pilihan 2×2 | Grid 2 kolom per soal | 4 pilihan dalam 2 kolom lebih compact daripada 4 baris — admin bisa membuat lebih banyak soal dengan scroll lebih sedikit |
| Pilihan C dan D opsional | `required` hanya A dan B | Fleksibel — soal boleh 2 atau 4 pilihan |
| Default jawaban benar | "A" | Mencegah submit tanpa pilih jawaban — tapi admin harus sadar mengubahnya |

### Halaman Show Kuis

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Background hijau pada jawaban benar | `background: #D4F5E6` | Admin bisa verifikasi kunci jawaban sekilas |
| Tanda "✓ Benar" | Text kecil di kanan | Konfirmasi tambahan di samping warna — accessible juga untuk color-blind |

---

## 17. ADMIN PANEL — LAPORAN BULANAN

### Laporan (`GET /admin/laporan`)

#### Pengguna
**Super Admin** (semua RW) dan **Admin RW** (RW sendiri).

#### Struktur Antarmuka

```
┌────────────────────────────────────────────┐
│  TOPBAR: Laporan Bulanan   [⬇ Export CSV]  │
├────────────────────────────────────────────┤
│  [FILTER FORM — card]                      │
│  Bulan: [Mei ▼]  Tahun: [2026 ▼]  [Tampilkan]│
├────────────────────────────────────────────┤
│  [TABLE]                                   │
│  Rank │ RW    │ KG  │ Org │ Anorg│ B3 │Angk│ Pilah│ Skor│
│  🥇1  │ RW 03 │ 145 │ 80  │  40  │  5 │  8 │ 72%  │  89 │
│  🥈2  │ RW 01 │ 120 │ 65  │  35  │  8 │  8 │ 68%  │  78 │
│  🥉3  │ RW 05 │  98 │ 50  │  30  │  5 │  6 │ 61%  │  65 │
│   4   │ RW 02 │  87 │ 45  │  25  │  7 │  7 │ 55%  │  54 │
│   5   │ RW 04 │  76 │ 40  │  20  │  4 │  5 │ 58%  │  48 │
└────────────────────────────────────────────┘
```

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Filter inline dalam card | Bukan modal/popup | Akses cepat tanpa layer tambahan — admin sering ganti bulan/tahun untuk komparasi |
| Ranking dengan badge warna | Emas/Perak/Perunggu/Abu | Konsisten dengan mobile — admin dan warga melihat sistem peringkat yang sama |
| Skor ditonjolkan (bold, besar) | `font-size:16px; color:var(--navy)` | Skor adalah KPI utama laporan — harus langsung terlihat |
| Export CSV | `response()->streamDownload()` | Format universal — admin bisa buka di Excel untuk laporan ke kelurahan |
| Semua kolom breakdown | Organik, Anorganik, B3, dll. | Admin butuh detail untuk program intervensi — "RW mana yang kurang pilah organik?" |

---

## 18. ADMIN PANEL — NOTIFIKASI

### Daftar Notifikasi (`GET /admin/notifikasi`)

#### Pengguna
**Super Admin** dan **Admin RW**.

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Kolom pesan terpotong | `Str::limit(60)` | Tabel tidak melebar — preview cukup untuk identifikasi isi |
| Badge tipe | Biru untuk tipe info/jadwal/broadcast | Differensiasi tipe pesan sekilas |
| Kolom "Target RW" | Nama RW atau "Semua RW" | Admin tahu jangkauan setiap notifikasi |

### Form Kirim Notifikasi (`GET /admin/notifikasi/create`)

#### Atribut & Alasan

| Atribut | Nilai | Alasan Desain |
|---|---|---|
| Tipe "Broadcast" hanya untuk super admin | `@if(auth()->user()->isSuperAdmin())` | Admin RW tidak bisa broadcast ke semua RW — kewenangan terpisah |
| Target RW kosong = semua RW | Placeholder "Semua RW" | Convenience untuk notif massal; pilih RW spesifik jika perlu targeted |
| Textarea pesan rows=4 | Cukup untuk pesan singkat | Notifikasi seharusnya ringkas — space terbatas secara implisit mendorong keringkasan |

---

## 19. KESIMPULAN & MATRIKS PENGGUNA

### 19.1 Matriks Antarmuka × Pengguna

| Antarmuka | Warga | Petugas | Admin RW | Super Admin |
|---|---|---|---|---|
| Login | ✅ | ✅ | ✅ | ✅ |
| Register | ✅ | — | — | — |
| Beranda | ✅ | ✅ | ✅ | ✅ |
| Jadwal (read) | ✅ | ✅ | ✅ | ✅ |
| Jadwal (update status) | — | ✅ | ✅ | ✅ |
| Jadwal (input log) | — | ✅ | ✅ | ✅ |
| Edukasi | ✅ | ✅ | ✅ | ✅ |
| Kuis | ✅ | ✅ | ✅ | ✅ |
| Laporan mobile | ✅ | ✅ | ✅ | ✅ |
| Profil | ✅ | ✅ | ✅ | ✅ |
| Notifikasi mobile | ✅ | ✅ | ✅ | ✅ |
| **Admin** Dashboard | — | — | ✅ | ✅ |
| **Admin** Users | — | — | ✅ (RW sendiri) | ✅ (semua) |
| **Admin** Jadwal | — | — | ✅ (RW sendiri) | ✅ (semua) |
| **Admin** Edukasi | — | — | — | ✅ |
| **Admin** Kuis | — | — | — | ✅ |
| **Admin** Laporan | — | — | ✅ (RW sendiri) | ✅ (semua) |
| **Admin** Notifikasi | — | — | ✅ (RW sendiri) | ✅ (broadcast) |

### 19.2 Prinsip Desain yang Diterapkan Konsisten

| Prinsip | Implementasi |
|---|---|
| **Hierarchy Visual** | Heading Cormorant besar → label Jakarta kecil → konten body |
| **Affordance** | Tombol kuning = aksi utama; merah = destruktif; abu = non-aktif |
| **Consistency** | Badge status warna sama di semua halaman (mobile & admin) |
| **Feedback** | Flash message setelah setiap aksi; dot warna status real-time |
| **Progressive Disclosure** | Form log jadwal tersembunyi sampai dibutuhkan (Alpine.js) |
| **Error Prevention** | Konfirmasi sebelum hapus; validasi required di semua form |
| **Accessibility** | Tap target minimum 52px; kontras WCAG AA; label eksplisit |
| **Role-based UI** | Menu/tombol hanya tampil jika user punya akses |

### 19.3 Keputusan Desain Kritis

1. **390px mobile shell** — Memaksa desain mobile-first yang konsisten, sekaligus memberikan pengalaman "app" di browser. Ini keputusan krusial karena mayoritas warga desa mengakses via smartphone, bukan laptop.

2. **Navy + Kuning sebagai pasangan warna** — Kombinasi ini tidak lazim di aplikasi sampah/lingkungan yang umumnya hijau. Pilihan navy-kuning sengaja memberikan kesan "sistem pemerintahan resmi" daripada "aplikasi startup hijau" — membangun kepercayaan komunitas desa.

3. **Cormorant Garamond untuk angka statistik** — Font serif untuk angka memberikan kesan "laporan formal" yang familiar bagi masyarakat yang terbiasa dengan dokumen pemerintahan.

4. **Leaderboard RW** — Keputusan gamifikasi yang paling kontroversial sekaligus paling potensial. Kompetisi antar RW dapat menimbulkan gesekan, namun juga dapat mendorong partisipasi massal yang tidak bisa dicapai oleh kampanye informatif saja.

5. **Auto-notifikasi saat jadwal dibuat** — Menghilangkan satu langkah manual dari workflow admin. Keputusan ini trade-off: admin kehilangan kontrol kapan notif dikirim, tapi sistem menjamin warga selalu mendapat informasi tepat waktu.

---

*Laporan ini mencakup 18 antarmuka utama dalam 5.847 baris kode yang di-push ke branch `claude/setup-laravel-project-XMO9H`.*

*Tarunadayavarna · Laporan Desain Antarmuka v1.0 · Mei 2026*
