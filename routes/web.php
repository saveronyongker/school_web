<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\GuruPktController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\JadwalPiketController;
use App\Http\Controllers\LaporanKBMController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DashboardController;
use Barryvdh\DomPDF\Facade\Pdf;


// =============================
// === RUTE UNTUK PUBLIC USER ==
// =============================

// Route::get('/test-pdf', function () {
//     $pdf = Pdf::loadView('welcome', []); // atau view lain
//     return $pdf->download('test.pdf');
// });

// // Halaman utama
// Route::get('/', function () {
//     $profil = ProfilSekolah::first();
    
//     // Jika tidak ada, buat default (opsional)
//     if (!$profil) {
//         $profil = ProfilSekolah::create([
//             'nama' => 'SMK Negeri Contoh',
//             'deskripsi' => 'Sekolah unggulan dengan fasilitas lengkap',
//             // field lainnya...
//         ]);
//     }

//     return view('welcome', compact('profil'));
// })->name('welcome');


Route::get("/", [HomeController::class, 'index'])->name('welcome');

// ini adalah route register guru mapel
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/guru-mapel', [RegisterController::class, 'showGuruMapelForm'])->name('guru_mapel');
    Route::post('/guru-mapel', [RegisterController::class, 'registerGuruMapel'])->name('guru_mapel.store');
});


// Halaman informasi sekolah untuk publik
Route::get('/informasi-sekolah', [InformasiController::class, 'InformasiSekolah'])->name('informasi.sekolah');
Route::get('/informasi-sekolah/{id}', [InformasiController::class, 'detail'])->name('informasi.detail');

// Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ==================================
// === RUTE KHUSUS ADMIN DENGAN MIDDLEWARE ===
// ==================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin 
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.page.dashboard');

    // Data Pengguna
    Route::prefix('data_pengguna')->group(function () {
        Route::get('/', [DataPenggunaController::class, 'index'])->name('data_pengguna.index');
        Route::get('/{user}/edit', [DataPenggunaController::class, 'edit'])->name('data_pengguna.edit');
        Route::put('/{user}', [DataPenggunaController::class, 'update'])->name('data_pengguna.update');
        Route::delete('/{user}', [DataPenggunaController::class, 'destroy'])->name('data_pengguna.destroy');
        Route::get('/{user}/confirm', [DataPenggunaController::class, 'confirm'])->name('data_pengguna.confirm');
    });

    // Informasi Sekolah - CRUD
    Route::prefix('informasi')->group(function () {
        Route::get('/', [InformasiController::class, 'index'])->name('informasi.index');
        Route::get('/create', [InformasiController::class, 'create'])->name('informasi.create');
        Route::post('/', [InformasiController::class, 'store'])->name('informasi.store');
        Route::get('/{informasi}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
        Route::put('/{informasi}', [InformasiController::class, 'update'])->name('informasi.update');
        Route::delete('/{informasi}', [InformasiController::class, 'destroy'])->name('informasi.destroy');
    });

    // Profil Sekolah
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('profil.index'); // Menampilkan profil
        Route::get('/edit', [ProfilController::class, 'edit'])->name('profil.edit'); // Form edit
        Route::put('/', [ProfilController::class, 'update'])->name('profil.update'); // Simpan perubahan
    });

    // Admin mengatur jadwal guru piket
    Route::prefix('jadwal')->group(function () {
        Route::get('/jadwal-piket', [JadwalPiketController::class, 'create'])->name('jadwal.piket.create');
        Route::post('/jadwal-piket/store-minggu-ini', [JadwalPiketController::class, 'storeMingguIni'])->name('jadwal.piket.store.minggu.ini'); // ✅ Baru
        Route::post('/jadwal-piket', [JadwalPiketController::class, 'store'])->name('jadwal.piket.store');
        Route::get('/jadwal-piket/lihat', [JadwalPiketController::class, 'show'])->name('jadwal.piket.show');

        // Edit jadwal harian
        Route::get('/jadwal-piket/edit/{tanggal}', [JadwalPiketController::class, 'editHarian'])->name('jadwal.piket.edit.harian');
        Route::put('/jadwal-piket/update/{tanggal}', [JadwalPiketController::class, 'updateHarian'])->name('jadwal.piket.update.harian');

        // Export PDF
        Route::get('/jadwal-piket/export-pdf', [JadwalPiketController::class, 'exportPdf'])->name('jadwal.piket.export.pdf');
    });

    // Route Kelas
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    // Route Siswa
    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    // AJAX Routes
    Route::get('/ajax/users', [AdminController::class, 'getAllUsers'])->name('ajax.users');
    
    // // Logout Admin
    // Route::post('/logout', function () { Auth::logout(); 
    //     return redirect('/login');})->name('logout');

});

// ===================================
// === RUTE KHUSUS GURU MAPEL ===
// ===================================
// Route::middleware(['web', 'auth', 'role:guru_mapel'])->group(function (){
Route::middleware(['auth', 'role:guru_mapel'])->group(function () {

    // Dashboard Guru Mapel
    Route::get('/dashboard', [GuruMapelController::class, 'index'])->name('gurumapel.home_gurumapel');

    // Isi Laporan Guru Mapel
    Route::get('/isi-laporan', [GuruMapelController::class, 'isiLaporan'])->name('gurumapel.isi_laporan');

    // Riwayat Laporan (dari GuruMapelController)
    Route::get('/laporan/riwayat', [GuruMapelController::class, 'riwayat'])->name('laporan.riwayat');
    Route::get('/riwayat', [GuruMapelController::class, 'riwayat'])->name('absensi.riwayat');

    Route::get('/laporan/{id}/edit', [LaporanKBMController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanKBMController::class, 'update'])->name('laporan.update');
    // Absensi
    // Route::get('/guru/absen', [LaporanKBMController::class, 'absen'])->name('gurumapel.absen');
    Route::post('/absensi/store-saja', [LaporanKBMController::class, 'storeAbsensiSaja'])->name('absensi.store.saja');
    Route::post('/absensi/store-dan-laporan', [LaporanKBMController::class, 'storeAbsensiDanLaporan'])->name('absensi.store.dan.laporan');
    
    // Route::get('/guru/dashboard', [GuruMapelController::class, 'laporan'])->name('gurumapel.laporan');

    // Route::get('/absensi', [LaporanKBMController::class, 'showAbsenForm'])->name('absensi.form');
    // Route::post('/absensi', [LaporanKBMController::class, 'storeAbsen'])->name('absensi.store');
    // Route::post('/absensi/store', [LaporanKBMController::class, 'storeAbsen'])->name('absensi.store');

     // absensi
    // Route::get('/absensi', [AbsenController::class, 'index'])->name('absensi.index');
    // Route::get('/kelas/{id}/siswa', [AbsenController::class, 'getSiswaByKelas'])->name('absensi.api.siswa');
    // Route::post('/store', [AbsenController::class, 'store'])->name('absensi.store');
    // Route::get('/riwayat', [AbsenController::class, 'riwayat'])->name('absensi.riwayat');
    // Route::get('/{id}', [AbsenController::class, 'show'])->name('absensi.show');
    // Route::delete('/{id}', [AbsenController::class, 'destroy'])->name('absensi.destroy');


    
    // Route untuk halaman gabungan laporan & absensi
    Route::get('/laporan-kbm-dan-absensi', [LaporanKBMController::class, 'createGabungan'])->name('laporan.create.gabungan');
    Route::post('/laporan-kbm-dan-absensi', [LaporanKBMController::class, 'storeGabungan'])->name('laporan.store.dan.absen');

    // --- Route Absensi Terpisah ---
    Route::get('/guru/absensi', [AbsenController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/load-siswa', [AbsenController::class, 'loadSiswa'])->name('absensi.load.siswa');
    Route::post('/absensi/store', [AbsenController::class, 'store'])->name('absensi.store');

    Route::post('/guru/load-siswa', [AbsenController::class, 'loadSiswa'])->name('guru.load.siswa');
    // Route untuk load siswa via AJAX (perbaiki ini)
    Route::post('/load-siswa', [LaporanKBMController::class, 'loadSiswa'])->name('load.siswa');
    // Route untuk load siswa via AJAX
    Route::post('/laporan-kbm-dan-absensi/load-siswa', [LaporanKBMController::class, 'loadSiswaNoApi'])->name('laporan.load.siswa');

    // Route::get('/absen/hari-ini', [AbsenController::class, 'riwayatHariIni'])->name('absen.hari_ini');

    // // Route untuk simpan absensi + redirect ke laporan
    // Route::post('/store-dan-laporan', [AbsenController::class, 'storeDanLaporan'])->name('absensi.store.dan.laporan');
    
    // // Form Isi Laporan KBM
    // Route::get('/laporan-kbm', [LaporanKBMController::class, 'create'])->name('laporan.create');
    // Route::post('/laporan-kbm', [LaporanKBMController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}', [LaporanKBMController::class, 'show'])->name('laporan.show');
    
});

// ===================================
// === RUTE KHUSUS GURU PIKET ===
// ===================================

Route::middleware(['auth', 'piket.hari_ini'])->group(function () {
//Route::middleware(['auth'])->prefix('piket')->group(function () {
    Route::get('/piket/dashboard', [LaporanKBMController::class, 'dashboardPiket'])->name('piket.dashboard');
    Route::post('/piket/konfirmasi/{id}', [LaporanKBMController::class, 'konfirmasi'])->name('piket.konfirmasi');
    Route::post('/piket/tolak/{id}', [LaporanKBMController::class, 'tolak'])->name('piket.tolak');
});

// ===================================
// === RUTE KHUSUS KEPALA SEKOLAH ===
// ===================================

// Route untuk Kepala Sekolah
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->group(function () {
    // Dashboard
    Route::get('/dashboard', [KepsekController::class, 'dashboard'])->name('kepsek.dashboard');
    
    // Laporan KBM
    Route::get('/laporan', [KepsekController::class, 'laporanIndex'])->name('kepsek.laporan.index');
    Route::get('/laporan/{id}', [KepsekController::class, 'laporanShow'])->name('kepsek.laporan.show');
    
    // Guru
    Route::get('/guru', [KepsekController::class, 'guruIndex'])->name('kepsek.guru.index');
    Route::get('/guru/{id}', [KepsekController::class, 'guruShow'])->name('kepsek.guru.show');
    Route::post('/guru/{id}/konfirmasi', [KepsekController::class, 'konfirmasiGuru'])->name('kepsek.guru.konfirmasi');
    
    // Jadwal Piket
    Route::get('/jadwal-piket', [KepsekController::class, 'jadwalPiket'])->name('kepsek.jadwal_piket.index');
    
    // Statistik
    Route::get('/statistik', [KepsekController::class, 'statistik'])->name('kepsek.statistik.index');
    
    // Informasi Sekolah
    Route::get('/informasi', [KepsekController::class, 'informasiIndex'])->name('kepsek.informasi.index');
    Route::get('/informasi/{id}', [KepsekController::class, 'informasiShow'])->name('kepsek.informasi.show');
    
}); 


// logout
Route::middleware(['auth'])->post('/logout', [LoginController::class, 'logout'])->name('logout');

