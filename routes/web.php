<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DaftarPermohonanController;
use App\Http\Controllers\DaftarPinjaman;
use App\Http\Controllers\DaftarPinjamBuku;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KoleksiPribadi;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesanBukuController;
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



// ? Authentikasi
Route::controller(AuthController::class)->group(function () {
    // * register
    Route::get('/register', 'register')->name('register.index');
    Route::post('/register', 'registerUser')->name('register.user');

    //* login
    Route::get('/', 'index')->name('login.index');
    Route::post('login', 'login')->name('login.auth');
    Route::post('logout', 'logout')->name('logout');
});

// ? Dashboard
Route::prefix('/dashboard-perpustakaan')->middleware('auth')->group(function () {

    // ! dashboard-chart
    Route::get('', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/graph', [DashboardController::class, 'graph'])->name('dashboard.graph');

    Route::middleware(['adminOrPetugas'])->group(function () {

        // * Daftar Buku
        Route::resource('/daftar-buku', BukuController::class);
        // * kategori Buku
        Route::resource('/kategori-buku', KategoriController::class);
        // * Daftar-peminjam
        Route::controller(DaftarPinjaman::class)->group(function () {
            Route::get('/daftar-peminjam', 'index')->name('daftar-peminjam.index');
            Route::get('/daftar-peminjam/{buku}/detail', 'detail')->name('daftar-peminjam.detail');
        });
        // * Daftar - Permohonan
        Route::controller(DaftarPermohonanController::class)->middleware(['petugas'])->group(function () {
            Route::get('/daftar-permohonan', 'index')->name('daftar-permohonan.index');
            Route::put('/daftar-permohonan/{buku}/setuju', 'setuju')->name('daftar-permohonan.setuju');
            Route::put('/daftar-permohonan/{buku}/penolakan', 'penolakan')->name('daftar-permohonan.penolakan');
            Route::put('/daftar-permohonan/{buku}/perpanjang', 'perpanjang')->name('daftar-permohonan.perpanjang');
            Route::put('/daftar-permohonan/{buku}/tolak-perpanjangan', 'tolakPerpanjangan')->name('daftar-permohonan.tolakPerpanjangan');
        });
        // * Laporan
        Route::controller(LaporanController::class)->group(function () {
            Route::get('/laporan-buku', 'buku')->name('laporan.buku');
            Route::get('/laporan-peminjam', 'peminjam')->name('laporan.peminjam');
            Route::get('/laporan', 'laporan')->name('laporan.all');
            Route::post('/laporan-excel', 'eksport')->name('laporan.export');
            Route::get('/laporan/print', 'print')->name('laporan.print');
        });
    });


    // ? Daftar User 
    Route::controller(UserManagement::class)->middleware('admin')->group(function () {
        Route::get('/user-management', 'index')->name('user.index');
        Route::get('/user-management/create', 'create')->name('user.create');
        Route::put('/user-management/{user:username}', 'destroy')->name('user.destroy');
    });

    Route::middleware('peminjam')->group(function () {
        // * meminjam buku
        Route::controller(PinjamBukuController::class)->group(function () {
            // * daftar-buku peminjam
            Route::get('/pinjam-buku/daftar-buku',  'index')->name('peminjam.daftar');
            // * detail buku
            Route::get('/pinjam-buku/{buku:slug}/detail-buku',  'show')->name('peminjam.detail');
            // *pinjam buku
            Route::post('/pinjam-buku/daftar-buku',  'store')->name('pinjam-buku.store');
            // * ulas buku
            Route::post('/ulas-buku',  'ulas')->name('peminjam.ulas');
            Route::delete('/ulas-buku/{ulasan_buku:id}',  'ulasanDestroy')->name('delte.ulasan');
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
        Route::get('/buku-pesanan', [PesanBukuController::class, 'index'])->name('pesan.buku');
        Route::delete('/buku-pesan/{buku}', [PesanBukuController::class, 'batalPesan'])->name('batal.pesan');

    });


    // ! profile
    Route::controller(ProfileController::class)->middleware('auth')->group(function () {
        Route::get('/profile/{user:username}', 'index')->name('profile.index');
        Route::put('/profile/{user:username}', 'update')->name('profile.update');
        Route::post('/profile/{user:username}/delete-photo', 'photoDestroy')->name('profile.delete-photo');
    });
});
