<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now  = Carbon::now();
        $pw   = Hash::make('password');
        $week = Carbon::now()->startOfWeek(); // Senin minggu ini

        // ══════════════════════════════════════════
        // 1. RW
        // ══════════════════════════════════════════
        DB::table('rw')->insert([
            ['nama' => 'RW 01', 'ketua_nama' => 'Pak Hendra',   'alamat' => 'Jl. Mawar No. 1-35',   'jumlah_kk' => 85,  'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'RW 02', 'ketua_nama' => 'Pak Darto',    'alamat' => 'Jl. Melati No. 5-50',   'jumlah_kk' => 92,  'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'RW 03', 'ketua_nama' => 'Pak Suparman', 'alamat' => 'Jl. Dahlia No. 1-40',   'jumlah_kk' => 78,  'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'RW 04', 'ketua_nama' => 'Pak Wahyu',    'alamat' => 'Jl. Kenanga No. 2-44',  'jumlah_kk' => 104, 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'RW 05', 'ketua_nama' => 'Pak Bambang',  'alamat' => 'Jl. Anggrek No. 1-28',  'jumlah_kk' => 67,  'created_at' => $now, 'updated_at' => $now],
        ]);

        // ══════════════════════════════════════════
        // 2. USERS
        // ══════════════════════════════════════════

        // Super Admin (id: 1)
        DB::table('users')->insert([
            'nama' => 'Admin Tarunadayavarna', 'username' => 'superadmin',
            'password' => $pw, 'role' => 'super_admin', 'rw_id' => null,
            'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
        ]);

        // Admin RW 01-05 (id: 2-6)
        $adminRwNama = ['Ibu Ratna', 'Pak Slamet', 'Ibu Dewi', 'Pak Rudi', 'Pak Agus'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'nama' => $adminRwNama[$i - 1], 'username' => 'admin_rw0' . $i,
                'password' => $pw, 'role' => 'admin_rw', 'rw_id' => $i,
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // Petugas RW 01-05 (id: 7-11)
        $petugasNama = ['Budi Santoso', 'Heru Prabowo', 'Andi Wijaya', 'Doni Kurniawan', 'Fitra Maulana'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'nama' => $petugasNama[$i - 1], 'username' => 'petugas0' . $i,
                'password' => $pw, 'role' => 'petugas', 'rw_id' => $i,
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // Warga 3 per RW = 15 warga (id: 12-26)
        $wargaNama = [
            1 => ['Pak Harjo',    'Ibu Sari',     'Pak Bejo'],
            2 => ['Pak Joko',     'Ibu Wati',     'Pak Karno'],
            3 => ['Ibu Lastri',   'Pak Purnomo',  'Ibu Yanti'],
            4 => ['Pak Sugiyo',   'Ibu Murniah',  'Pak Wahid'],
            5 => ['Pak Tarno',    'Ibu Sumiati',  'Pak Gunadi'],
        ];
        for ($rw = 1; $rw <= 5; $rw++) {
            for ($w = 1; $w <= 3; $w++) {
                DB::table('users')->insert([
                    'nama'      => $wargaNama[$rw][$w - 1],
                    'username'  => 'warga_rw0' . $rw . '_' . $w,
                    'password'  => $pw,
                    'role'      => 'warga',
                    'rw_id'     => $rw,
                    'is_active' => true,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        // ══════════════════════════════════════════
        // 3. JADWAL (25 jadwal: 5 RW × 5 jadwal per RW)
        // Minggu ini: Senin(+0), Rabu(+2), Jumat(+4)
        // + 2 jadwal minggu lalu untuk riwayat
        // ══════════════════════════════════════════

        // petugas_id offset: petugas RW-N = id (6 + N)
        $jadwalDefs = [
            // [rw_id, hari_offset, waktu_mulai, waktu_selesai, jenis, status, estimasi_kg]
            // RW 01
            [1, -7, '07:00', '09:00', 'organik',    'selesai',  120.00],
            [1, -5, '08:00', '10:00', 'anorganik',  'selesai',  80.00],
            [1,  0, '07:00', '09:00', 'campuran',   'menunggu', 100.00],
            [1,  2, '08:00', '10:00', 'organik',    'proses',   110.00],
            [1,  4, '07:30', '09:30', 'b3',         'menunggu', 50.00],
            // RW 02
            [2, -7, '08:00', '10:00', 'organik',    'selesai',  150.00],
            [2, -5, '07:00', '09:00', 'anorganik',  'selesai',  90.00],
            [2,  1, '07:00', '09:00', 'organik',    'menunggu', 130.00],
            [2,  3, '08:00', '10:00', 'campuran',   'proses',   120.00],
            [2,  4, '09:00', '11:00', 'anorganik',  'menunggu', 75.00],
            // RW 03
            [3, -7, '07:00', '09:00', 'organik',    'selesai',  95.00],
            [3, -4, '08:00', '10:00', 'daur_ulang', 'selesai',  70.00],
            [3,  0, '08:00', '10:00', 'anorganik',  'menunggu', 85.00],
            [3,  2, '07:00', '09:00', 'organik',    'proses',   100.00],
            [3,  4, '09:00', '11:00', 'campuran',   'menunggu', 90.00],
            // RW 04
            [4, -7, '07:00', '09:00', 'organik',    'selesai',  180.00],
            [4, -5, '08:00', '10:00', 'b3',         'selesai',  60.00],
            [4,  1, '07:00', '09:00', 'organik',    'menunggu', 160.00],
            [4,  3, '08:00', '10:00', 'anorganik',  'proses',   95.00],
            [4,  5, '07:30', '09:30', 'campuran',   'menunggu', 140.00],
            // RW 05
            [5, -7, '08:00', '10:00', 'organik',    'selesai',  110.00],
            [5, -4, '07:00', '09:00', 'anorganik',  'selesai',  65.00],
            [5,  2, '07:00', '09:00', 'campuran',   'menunggu', 80.00],
            [5,  3, '08:00', '10:00', 'organik',    'proses',   95.00],
            [5,  5, '09:00', '11:00', 'b3',         'menunggu', 45.00],
        ];

        $jadwalIds = [];
        foreach ($jadwalDefs as $j) {
            [$rwId, $hariOffset, $mulai, $selesai, $jenis, $status, $estimasi] = $j;
            $petugasId = 6 + $rwId; // petugas RW-N = user id (6+N)
            $tanggal   = $week->copy()->addDays($hariOffset);

            $id = DB::table('jadwal')->insertGetId([
                'rw_id'          => $rwId,
                'petugas_id'     => $petugasId,
                'tanggal'        => $tanggal->toDateString(),
                'waktu_mulai'    => $mulai . ':00',
                'waktu_selesai'  => $selesai . ':00',
                'jenis_sampah'   => $jenis === 'daur_ulang' ? 'anorganik' : $jenis,
                'status'         => $status,
                'estimasi_kg'    => $estimasi,
                'created_by'     => 1 + $rwId, // admin RW bersangkutan
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);

            $jadwalIds[] = ['id' => $id, 'status' => $status, 'waktu_selesai' => $selesai, 'tanggal' => $tanggal];
        }

        // ══════════════════════════════════════════
        // 4. PENGANGKUTAN_LOG untuk semua jadwal "selesai"
        // ══════════════════════════════════════════
        $beratSample = [142.5, 88.0, 97.3, 68.0, 176.2, 88.5, 62.0, 108.0, 93.5, 110.0];
        $beratIdx    = 0;

        foreach ($jadwalIds as $j) {
            if ($j['status'] === 'selesai') {
                $selesaiAt = Carbon::parse($j['tanggal']->toDateString() . ' ' . $j['waktu_selesai']);
                DB::table('pengangkutan_log')->insert([
                    'jadwal_id'       => $j['id'],
                    'berat_actual_kg' => $beratSample[$beratIdx % count($beratSample)],
                    'foto_bukti_url'  => null,
                    'catatan'         => 'Pengangkutan selesai tepat waktu.',
                    'selesai_at'      => $selesaiAt,
                    'created_at'      => $selesaiAt,
                ]);
                $beratIdx++;
            }
        }

        // ══════════════════════════════════════════
        // 5. EDUKASI (6 konten)
        // ══════════════════════════════════════════
        $edukasiInserts = [
            [
                'judul'        => 'Cara Memilah Sampah Organik di Rumah',
                'slug'         => 'cara-memilah-sampah-organik-di-rumah',
                'konten'       => "Sampah organik adalah sampah yang berasal dari makhluk hidup dan dapat terurai secara alami.\n\nContoh sampah organik:\n- Sisa makanan (nasi, sayuran, buah)\n- Daun-daunan kering\n- Potongan rumput dan tanaman\n\nCara memilah:\n1. Sediakan tempat sampah khusus berwarna hijau untuk sampah organik\n2. Pisahkan dari sampah plastik dan kertas\n3. Kumpulkan di kantong yang mudah terurai\n4. Letakkan di depan rumah sesuai jadwal pengangkutan organik\n\nSampah organik yang dikelola dengan baik dapat menjadi kompos yang bermanfaat untuk tanaman.",
                'kategori'     => 'organik',
                'format'       => 'artikel',
                'durasi_menit' => 3,
                'is_published' => true,
                'created_by'   => 1,
            ],
            [
                'judul'        => 'Manfaat Kompos dari Sampah Dapur',
                'slug'         => 'manfaat-kompos-dari-sampah-dapur',
                'konten'       => "Sampah dapur seperti kulit buah, sisa sayuran, dan ampas kopi dapat diolah menjadi kompos berkualitas tinggi.\n\nManfaat kompos:\n- Menyuburkan tanah secara alami\n- Mengurangi penggunaan pupuk kimia\n- Mengurangi volume sampah yang dibuang\n- Hemat biaya berkebun\n\nCara membuat kompos sederhana:\n1. Kumpulkan sisa makanan organik dalam wadah tertutup\n2. Tambahkan tanah atau dedaunan kering\n3. Aduk setiap 3 hari\n4. Setelah 4-6 minggu, kompos siap digunakan\n\nSatu rumah tangga dapat menghasilkan 2-5 kg kompos per bulan dari sisa dapur.",
                'kategori'     => 'organik',
                'format'       => 'artikel',
                'durasi_menit' => 4,
                'is_published' => true,
                'created_by'   => 1,
            ],
            [
                'judul'        => 'Panduan Memilah Sampah Plastik dan Kertas',
                'slug'         => 'panduan-memilah-sampah-plastik-dan-kertas',
                'konten'       => "Sampah anorganik meliputi plastik, kertas, kaca, dan logam yang tidak dapat terurai secara alami namun dapat didaur ulang.\n\nJenis sampah anorganik yang dapat didaur ulang:\n- Botol plastik (kode 1 PET dan 2 HDPE)\n- Kardus dan kertas\n- Kaleng aluminium dan besi\n- Botol kaca\n\nLangkah memilah:\n1. Cuci terlebih dahulu agar tidak berbau\n2. Pisahkan plastik, kertas, dan logam dalam wadah berbeda\n3. Ratakan kardus sebelum dikumpulkan\n4. Kumpulkan di tempat khusus yang ditentukan RW\n\nSampah anorganik yang bersih dan terpilah memiliki nilai jual lebih tinggi di bank sampah.",
                'kategori'     => 'anorganik',
                'format'       => 'artikel',
                'durasi_menit' => 4,
                'is_published' => true,
                'created_by'   => 1,
            ],
            [
                'judul'        => 'Bank Sampah: Ubah Sampah Jadi Uang',
                'slug'         => 'bank-sampah-ubah-sampah-jadi-uang',
                'konten'       => "Bank sampah adalah tempat pengumpulan sampah yang telah dipilah dan dapat ditukar dengan uang atau tabungan.\n\nJenis sampah yang diterima bank sampah:\n- Botol plastik bersih: Rp 1.000-2.000/kg\n- Kardus dan kertas koran: Rp 500-1.000/kg\n- Kaleng aluminium: Rp 5.000-8.000/kg\n- Besi tua: Rp 1.000-2.000/kg\n\nCara bergabung bank sampah:\n1. Daftarkan nama dan nomor rekening tabungan\n2. Pilah sampah di rumah sebelum dibawa\n3. Timbang sampah saat penyetoran\n4. Saldo dicatat dalam buku tabungan\n5. Uang dapat dicairkan kapan saja\n\nDengan aktif ke bank sampah, satu keluarga dapat menghemat Rp 50.000-200.000 per bulan.",
                'kategori'     => 'anorganik',
                'format'       => 'artikel',
                'durasi_menit' => 5,
                'is_published' => true,
                'created_by'   => 1,
            ],
            [
                'judul'        => 'Bahaya Sampah B3 dan Cara Membuangnya',
                'slug'         => 'bahaya-sampah-b3-dan-cara-membuangnya',
                'konten'       => "Sampah B3 (Bahan Berbahaya dan Beracun) adalah sampah yang mengandung zat berbahaya bagi kesehatan dan lingkungan.\n\nContoh sampah B3 rumah tangga:\n- Baterai bekas\n- Lampu neon dan LED\n- Cat dan thinner\n- Obat-obatan kadaluarsa\n- Pestisida dan insektisida\n- Aki kendaraan\n\nBAHAYA membuang B3 sembarangan:\n- Mencemari tanah dan air tanah\n- Meracuni hewan dan tumbuhan\n- Menyebabkan penyakit pada manusia\n\nCara membuang B3 yang benar:\n1. Simpan dalam wadah aslinya, jangan dicampur\n2. Beri label 'BERBAHAYA'\n3. Serahkan ke petugas pengangkutan B3 pada jadwal khusus\n4. Jangan dibakar atau dibuang ke saluran air",
                'kategori'     => 'b3',
                'format'       => 'video',
                'video_url'    => null,
                'durasi_menit' => 6,
                'is_published' => true,
                'created_by'   => 1,
            ],
            [
                'judul'        => 'Kreasi Daur Ulang: Sampah Jadi Kerajinan',
                'slug'         => 'kreasi-daur-ulang-sampah-jadi-kerajinan',
                'konten'       => "Sampah yang tampaknya tidak berguna ternyata dapat diubah menjadi kerajinan tangan yang bernilai tinggi.\n\nIde kreatif daur ulang:\n\n1. Botol plastik → Pot tanaman\n   Bersihkan botol bekas, isi dengan tanah, tanam bibit sayuran mini.\n\n2. Kaleng bekas → Tempat pensil\n   Cat kaleng dengan warna kesukaan, tambahkan dekorasi.\n\n3. Kardus → Rak mini\n   Potong dan susun kardus tebal menjadi rak buku kecil yang kuat.\n\n4. Kain perca → Lap atau taplak\n   Gabungkan potongan kain bekas menjadi lap dapur yang cantik.\n\n5. Koran → Keranjang anyaman\n   Gulung koran menjadi batang, anyam menjadi keranjang serbaguna.\n\nDengan kreativitas, kita bisa mengurangi sampah sekaligus menghasilkan produk bernilai ekonomi.",
                'kategori'     => 'daur_ulang',
                'format'       => 'artikel',
                'durasi_menit' => 5,
                'is_published' => true,
                'created_by'   => 1,
            ],
        ];

        foreach ($edukasiInserts as $e) {
            DB::table('edukasi')->insert(array_merge($e, [
                'thumbnail_url' => null,
                'video_url'     => $e['video_url'] ?? null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]));
        }

        // edukasi id organik pertama = 1
        $edukasiOrganikId = 1;

        // ══════════════════════════════════════════
        // 6. KUIS
        // ══════════════════════════════════════════

        // Kuis 1: terkait edukasi organik
        $kuis1Id = DB::table('kuis')->insertGetId([
            'edukasi_id'   => $edukasiOrganikId,
            'judul'        => 'Kuis Sampah Organik',
            'durasi_menit' => 5,
            'is_active'    => true,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('kuis_soal')->insert([
            ['kuis_id' => $kuis1Id, 'pertanyaan' => 'Manakah yang termasuk sampah organik?', 'pilihan_a' => 'Botol plastik', 'pilihan_b' => 'Sisa nasi', 'pilihan_c' => 'Baterai bekas', 'pilihan_d' => 'Kaleng susu', 'jawaban_benar' => 'b', 'urutan' => 1, 'created_at' => $now],
            ['kuis_id' => $kuis1Id, 'pertanyaan' => 'Sampah organik dapat diolah menjadi apa?', 'pilihan_a' => 'Plastik daur ulang', 'pilihan_b' => 'Bahan bakar', 'pilihan_c' => 'Kompos', 'pilihan_d' => 'Kertas baru', 'jawaban_benar' => 'c', 'urutan' => 2, 'created_at' => $now],
            ['kuis_id' => $kuis1Id, 'pertanyaan' => 'Warna tempat sampah organik yang dianjurkan adalah?', 'pilihan_a' => 'Merah', 'pilihan_b' => 'Biru', 'pilihan_c' => 'Hitam', 'pilihan_d' => 'Hijau', 'jawaban_benar' => 'd', 'urutan' => 3, 'created_at' => $now],
            ['kuis_id' => $kuis1Id, 'pertanyaan' => 'Berapa lama waktu yang dibutuhkan untuk membuat kompos sederhana?', 'pilihan_a' => '1-2 hari', 'pilihan_b' => '1-2 minggu', 'pilihan_c' => '4-6 minggu', 'pilihan_d' => '6-12 bulan', 'jawaban_benar' => 'c', 'urutan' => 4, 'created_at' => $now],
            ['kuis_id' => $kuis1Id, 'pertanyaan' => 'Manakah bukan contoh sampah organik?', 'pilihan_a' => 'Kulit pisang', 'pilihan_b' => 'Daun kering', 'pilihan_c' => 'Sisa sayuran', 'pilihan_d' => 'Kantong plastik', 'jawaban_benar' => 'd', 'urutan' => 5, 'created_at' => $now],
        ]);

        // Kuis 2: umum pemilahan
        $kuis2Id = DB::table('kuis')->insertGetId([
            'edukasi_id'   => null,
            'judul'        => 'Kuis Umum: Cara Memilah Sampah',
            'durasi_menit' => 7,
            'is_active'    => true,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('kuis_soal')->insert([
            ['kuis_id' => $kuis2Id, 'pertanyaan' => 'Sampah B3 singkatan dari?', 'pilihan_a' => 'Besar, Bau, Berbahaya', 'pilihan_b' => 'Bahan Berbahaya dan Beracun', 'pilihan_c' => 'Barang Bekas Berulang', 'pilihan_d' => 'Bukan Bahan Bakar', 'jawaban_benar' => 'b', 'urutan' => 1, 'created_at' => $now],
            ['kuis_id' => $kuis2Id, 'pertanyaan' => 'Lampu neon bekas termasuk kategori sampah apa?', 'pilihan_a' => 'Organik', 'pilihan_b' => 'Anorganik', 'pilihan_c' => 'B3', 'pilihan_d' => 'Daur ulang', 'jawaban_benar' => 'c', 'urutan' => 2, 'created_at' => $now],
            ['kuis_id' => $kuis2Id, 'pertanyaan' => 'Apa manfaat utama memilah sampah?', 'pilihan_a' => 'Menambah pekerjaan', 'pilihan_b' => 'Mempermudah daur ulang dan mengurangi pencemaran', 'pilihan_c' => 'Menghemat listrik', 'pilihan_d' => 'Mengurangi bau', 'jawaban_benar' => 'b', 'urutan' => 3, 'created_at' => $now],
            ['kuis_id' => $kuis2Id, 'pertanyaan' => 'Sampah plastik yang dapat didaur ulang sebaiknya...', 'pilihan_a' => 'Dibakar agar habis', 'pilihan_b' => 'Dibuang ke sungai', 'pilihan_c' => 'Dicuci lalu dikumpulkan terpisah', 'pilihan_d' => 'Dikubur dalam tanah', 'jawaban_benar' => 'c', 'urutan' => 4, 'created_at' => $now],
            ['kuis_id' => $kuis2Id, 'pertanyaan' => 'Bank sampah berfungsi untuk?', 'pilihan_a' => 'Menyimpan uang', 'pilihan_b' => 'Mengolah sampah menjadi tabungan', 'pilihan_c' => 'Membakar sampah', 'pilihan_d' => 'Mengubur sampah', 'jawaban_benar' => 'b', 'urutan' => 5, 'created_at' => $now],
        ]);

        // ══════════════════════════════════════════
        // 7. LAPORAN BULANAN
        // Bulan ini + bulan lalu untuk 5 RW
        // ══════════════════════════════════════════
        $bulanIni  = (int) $now->month;
        $tahunIni  = (int) $now->year;
        $bulanLalu = $bulanIni === 1 ? 12 : $bulanIni - 1;
        $tahunLalu = $bulanIni === 1 ? $tahunIni - 1 : $tahunIni;

        // [total_kg, organik_kg, anorganik_kg, b3_kg, jumlah_angkut, tingkat_pilah, skor]
        $laporanData = [
            1 => ['bulan_ini' => [420.5, 280.0, 120.0, 20.5, 18, 85, 88], 'bulan_lalu' => [390.0, 250.0, 115.0, 25.0, 16, 80, 82]],
            2 => ['bulan_ini' => [530.0, 350.0, 160.0, 20.0, 22, 91, 94], 'bulan_lalu' => [500.0, 320.0, 150.0, 30.0, 20, 87, 90]],
            3 => ['bulan_ini' => [315.0, 200.0, 100.0, 15.0, 14, 78, 75], 'bulan_lalu' => [290.0, 185.0,  90.0, 15.0, 12, 74, 70]],
            4 => ['bulan_ini' => [680.0, 450.0, 200.0, 30.0, 26, 93, 97], 'bulan_lalu' => [640.0, 420.0, 190.0, 30.0, 24, 90, 94]],
            5 => ['bulan_ini' => [260.0, 160.0,  85.0, 15.0, 10, 72, 67], 'bulan_lalu' => [240.0, 145.0,  80.0, 15.0,  9, 70, 65]],
        ];

        foreach ($laporanData as $rwId => $data) {
            [$tk, $ok, $ak, $bk, $ja, $tp, $sk] = $data['bulan_ini'];
            DB::table('laporan_bulanan')->insert([
                'rw_id' => $rwId, 'bulan' => $bulanIni, 'tahun' => $tahunIni,
                'total_kg' => $tk, 'organik_kg' => $ok, 'anorganik_kg' => $ak, 'b3_kg' => $bk, 'daur_ulang_kg' => 0,
                'jumlah_pengangkutan' => $ja, 'tingkat_pilah_persen' => $tp, 'skor_rw' => $sk,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            [$tk, $ok, $ak, $bk, $ja, $tp, $sk] = $data['bulan_lalu'];
            DB::table('laporan_bulanan')->insert([
                'rw_id' => $rwId, 'bulan' => $bulanLalu, 'tahun' => $tahunLalu,
                'total_kg' => $tk, 'organik_kg' => $ok, 'anorganik_kg' => $ak, 'b3_kg' => $bk, 'daur_ulang_kg' => 0,
                'jumlah_pengangkutan' => $ja, 'tingkat_pilah_persen' => $tp, 'skor_rw' => $sk,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ══════════════════════════════════════════
        // 8. NOTIFIKASI + NOTIFIKASI_USER
        // ══════════════════════════════════════════
        $notifData = [
            [
                'judul'       => 'Jadwal Pengangkutan Besok',
                'pesan'       => 'Pengangkutan sampah organik dijadwalkan besok pukul 07.00-09.00. Harap letakkan sampah di depan rumah paling lambat pukul 06.45.',
                'tipe'        => 'jadwal',
                'target_role' => 'warga',
                'target_rw_id' => null,
                'created_by'  => 1,
            ],
            [
                'judul'       => 'Tips Pemilahan Sampah Anorganik',
                'pesan'       => 'Pastikan sampah plastik dan kertas dicuci sebelum dikumpulkan agar tidak berbau dan memiliki nilai jual lebih tinggi di bank sampah.',
                'tipe'        => 'info',
                'target_role' => 'semua',
                'target_rw_id' => null,
                'created_by'  => 1,
            ],
            [
                'judul'       => 'Pengumuman: Lomba RW Terbersih',
                'pesan'       => 'Penilaian Lomba RW Terbersih akan dilaksanakan akhir bulan ini. Mari tingkatkan partisipasi pemilahan sampah di RW masing-masing!',
                'tipe'        => 'broadcast',
                'target_role' => 'semua',
                'target_rw_id' => null,
                'created_by'  => 1,
            ],
        ];

        $notifIds = [];
        foreach ($notifData as $n) {
            $notifIds[] = DB::table('notifikasi')->insertGetId(array_merge($n, ['created_at' => $now]));
        }

        // Kirim notifikasi ke semua warga
        $allWarga = DB::table('users')->where('role', 'warga')->pluck('id');
        foreach ($notifIds as $notifId) {
            foreach ($allWarga as $userId) {
                DB::table('notifikasi_user')->insert([
                    'notifikasi_id' => $notifId,
                    'user_id'       => $userId,
                    'is_read'       => false,
                    'read_at'       => null,
                    'created_at'    => $now,
                ]);
            }
        }
    }
}
