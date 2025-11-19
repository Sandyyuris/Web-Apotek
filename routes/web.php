<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Halaman Utama / Artikel Index
Route::get('/', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('artikel/{id}/{slug}', [ArtikelController::class, 'detailArtikel'])->name('artikel.detail');

// Rute Login
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Rute Register (PENTING: Harus ada name('register'))
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rute Logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Tampilkan daftar produk dan keranjang. Menerima parameter 'kategori' di URL.
    Route::get('transaksi/produk', [TransaksiController::class, 'index'])->name('transaksi.index');
    // Tambah ke keranjang
    Route::post('transaksi/tambah-keranjang', [TransaksiController::class, 'addToCart'])->name('transaksi.addToCart');
    // Hapus dari keranjang
    Route::get('transaksi/hapus-keranjang/{id_produk}', [TransaksiController::class, 'removeFromCart'])->name('transaksi.removeFromCart'); // <-- GANTI PARAMETER
    // Proses checkout
    Route::post('transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

    // Rute Khusus Admin - menggunakan controller logic untuk otorisasi
    Route::group([], function () {
        Route::get('admin/artikel/create', [AdminController::class, 'createArtikel'])->name('admin.artikel.create');
        Route::get('admin/produk/create', [AdminController::class, 'createProduk'])->name('admin.produk.create');
    });
});
