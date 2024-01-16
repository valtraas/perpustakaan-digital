<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DaftarBukuPinjam;
use App\Http\Controllers\DaftarPinjaman;
use App\Http\Controllers\DaftarPinjamBuku;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KoleksiPribadi;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PinjamBukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagement;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// * Authentikasi
Route::controller(AuthController::class)->group(function () {
    // * register
    Route::get('/register', 'register')->name('register.index');
    Route::post('/register', 'registerUser')->name('register.user');

    //* login
    Route::get('/', 'index')->name('login.index');
    Route::post('login', 'login')->name('login.auth');
    Route::post('logout', 'logout')->name('logout');
});

// * Dashboard
Route::prefix('/dashboard-perpustakaan')->middleware('auth')->group(function () {

    // * dashboard-chart
    Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/graph', [DashboardController::class, 'graph'])->name('dashboard.graph');

    Route::middleware(['auth'])->group(function () {

        // * Daftar Buku
        Route::resource('/daftar-buku', BukuController::class);
        // * kategori Buku
        Route::resource('/kategori-buku', KategoriController::class);
        // * Daftar-peminjam
        Route::controller(DaftarPinjaman::class)->group(function () {
            Route::get('/daftar-peminjam', 'index')->name('daftar-peminjam.index');
            Route::get('/daftar-peminjam/{buku}/detail', 'detail')->name('daftar-peminjam.detail');
            Route::put('/daftar-peminjam/{buku}', 'update')->name('daftar-peminjam.update');
        });
        // * Laporan
        Route::controller(LaporanController::class)->group(function () {
            Route::get('/laporan-buku', 'buku')->name('laporan.buku');
            Route::get('/laporan-peminjam', 'peminjam')->name('laporan.peminjam');
            Route::get('/laporan', 'laporan')->name('laporan.all');
            Route::get('/laporan/print', 'print')->name('laporan.print');
        });
    });


    // * Daftar User 
    Route::controller(UserManagement::class)->middleware('petugas')->group(function () {
        Route::get('/user-management', 'index')->name('user.index');
        Route::put('/user-management/{user:username}', 'update')->name('user.update');
    });

    Route::middleware('peminjam')->group(function () {
        // * meminjam buku
        Route::controller(PinjamBukuController::class)->group(function () {
            // * daftar-buku peminjam
            Route::get('/pinjam-buku/daftar-buku', [PinjamBukuController::class, 'index'])->name('peminjam.daftar');
            // * detail buku
            Route::get('/pinjam-buku/{buku:slug}/detail-buku', [PinjamBukuController::class, 'show'])->name('peminjam.detail');
            // *pinjam buku
            Route::post('/pinjam-buku/daftar-buku', [PinjamBukuController::class, 'store'])->name('pinjam-buku.store');
            // * ulas buku
            Route::post('/ulas-buku', [PinjamBukuController::class, 'ulas'])->name('peminjam.ulas');
            Route::delete('/ulas-buku/{ulasan_buku:id}', [PinjamBukuController::class, 'ulasanDestroy'])->name('delte.ulasan');
        });

        //  * Daftar buku yang dipinjam
        Route::resource('/daftar-buku-pinjaman', DaftarPinjamBuku::class)->except(['create', 'store']);
        Route::post('/daftar-buku-pinjaman/pengembalian/{buku}', [DaftarPinjamBuku::class, 'bukuKembali'])->name('daftar-buku-pinjaman.kembali');
        Route::controller(KoleksiPribadi::class)->group(function () {
            // * daftar koleksi
            Route::get('/koleksi-buku', 'index')->name('koleksi.index');
            // * show buku
            Route::get('/koleksi-buku/{koleksi}/detail', 'show')->name('koleksi.detail');
            // * tandai sebagai favorit
            Route::post('/koleksi-buku', 'koleksi')->name('peminjam.koleksi');
            //  * hapus dari koleksi 
            Route::post('/koleksi-buku/{koleksi_pribadi:id}', 'koleksiDestroy')->name('koleksi.destroy');
        });
    });


    // * profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{user:username}', 'index')->name('profile.index');
        Route::put('/profile/{user:username}', 'update')->name('profile.update');
        Route::post('/profile/{user:username}/delete-photo', 'photoDestroy')->name('profile.delete-photo');
    });
});
