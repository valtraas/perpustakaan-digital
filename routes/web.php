<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
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
    Route::get('', function () {
        return view('layouts.templates.dashboard');
    })->name('dashboard');

    // * Daftar Buku
    Route::resource('/daftar-buku', BukuController::class);

});
