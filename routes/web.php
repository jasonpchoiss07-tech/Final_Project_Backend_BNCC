<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\FakturController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Barang CRUD
    Route::resource('barang', AdminBarangController::class);
    // Kategori CRUD
    Route::resource('kategori', AdminKategoriController::class);
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    // Katalog
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{barangId}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::patch('/keranjang/update/{barangId}', [KeranjangController::class, 'updateKuantitas'])->name('keranjang.update');
    Route::delete('/keranjang/clear', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    // Faktur
    Route::get('/faktur/buat', [FakturController::class, 'create'])->name('faktur.create');
    Route::post('/faktur/simpan', [FakturController::class, 'store'])->name('faktur.store');
    Route::get('/faktur/{faktur}', [FakturController::class, 'show'])->name('faktur.show');
    Route::get('/faktur/{faktur}/cetak', [FakturController::class, 'cetak'])->name('faktur.cetak');
    Route::get('/riwayat-faktur', [FakturController::class, 'history'])->name('faktur.history');
});
