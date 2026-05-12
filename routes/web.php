<?php

use App\Http\Controllers\App\AuthController;
use App\Http\Controllers\App\BerandaController;
use App\Http\Controllers\App\EdukasiController as AppEdukasiController;
use App\Http\Controllers\App\JadwalController as AppJadwalController;
use App\Http\Controllers\App\KuisController as AppKuisController;
use App\Http\Controllers\App\LaporanController as AppLaporanController;
use App\Http\Controllers\App\NotifikasiController as AppNotifikasiController;
use App\Http\Controllers\App\ProfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\EdukasiController as AdminEdukasiController;
use App\Http\Controllers\Admin\KuisController as AdminKuisController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════
// MOBILE APP — /app
// ══════════════════════════════════
Route::prefix('app')->name('app.')->group(function () {

    // Guest only
    Route::middleware('guest')->group(function () {
        Route::get('/login',     [AuthController::class, 'loginPage'])->name('login');
        Route::post('/login',    [AuthController::class, 'login']);
        Route::get('/register',  [AuthController::class, 'registerPage'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });

    // Auth required (semua role)
    Route::middleware('auth')->group(function () {
        Route::get('/beranda',        [BerandaController::class,       'index'])->name('beranda');
        Route::get('/edukasi',        [AppEdukasiController::class,    'index'])->name('edukasi');
        Route::get('/edukasi/{slug}', [AppEdukasiController::class,    'detail'])->name('edukasi.detail');
        Route::get('/laporan',        [AppLaporanController::class,    'index'])->name('laporan');
        Route::get('/profil',         [ProfilController::class,        'index'])->name('profil');
        Route::put('/profil',         [ProfilController::class,        'update'])->name('profil.update');
        Route::get('/notifikasi',     [AppNotifikasiController::class, 'index'])->name('notifikasi');
        Route::post('/notifikasi/{id}/baca', [AppNotifikasiController::class, 'markRead'])->name('notifikasi.baca');
        Route::post('/logout',        [AuthController::class,          'logout'])->name('logout');

        // Jadwal (read)
        Route::get('/jadwal', [AppJadwalController::class, 'index'])->name('jadwal');

        // Kuis
        Route::get('/kuis/{id}',        [AppKuisController::class, 'show'])->name('kuis.show');
        Route::post('/kuis/{id}/submit', [AppKuisController::class, 'submit'])->name('kuis.submit');
    });

    // Petugas / admin update jadwal
    Route::middleware(['auth', 'role:petugas,admin_rw,super_admin'])->group(function () {
        Route::patch('/jadwal/{id}/status', [AppJadwalController::class, 'updateStatus'])->name('jadwal.status');
        Route::post('/jadwal/{id}/log',     [AppJadwalController::class, 'inputLog'])->name('jadwal.log');
    });
});

// ══════════════════════════════════
// ADMIN PANEL — /admin
// ══════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin,admin_rw'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users',     UserController::class);
    Route::resource('/jadwal',    AdminJadwalController::class);
    Route::resource('/edukasi',   AdminEdukasiController::class);
    Route::resource('/kuis',      AdminKuisController::class);

    Route::get('/laporan',        [AdminLaporanController::class,    'index'])->name('laporan.index');
    Route::get('/laporan/export', [AdminLaporanController::class,    'export'])->name('laporan.export');

    Route::resource('/notifikasi', AdminNotifikasiController::class)->only(['index', 'create', 'store']);

    Route::get('/', fn() => redirect()->route('admin.dashboard'));
});

// Redirect root ke app login
Route::get('/', fn() => redirect('/app/login'));
