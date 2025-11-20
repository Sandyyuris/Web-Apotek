<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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
    // Lihat Profil Pengguna
    Route::get('profil', [UserController::class, 'index'])->name('profile.index'); // Gunakan 'profile.index' untuk Lihat Profil
    // Edit Profil (Form)
    Route::get('profil/edit', [UserController::class, 'edit'])->name('profile.edit');
    // Update Profil (Submit Form)
    Route::post('profil/update', [UserController::class, 'update'])->name('profile.update');
    // Riwayat Pembelian
    Route::get('profil/riwayat', [UserController::class, 'riwayatPembelian'])->name('profile.history');
    // Form Checkout
    Route::get('transaksi/checkout/form', [TransaksiController::class, 'showCheckoutForm'])->name('transaksi.checkout.form'); // <-- BARU
    // Proses checkout
    Route::post('transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

    // Rute Khusus Admin - menggunakan controller logic untuk otorisasi
    Route::group([], function () {
        Route::get('admin/artikel/create', [AdminController::class, 'createArtikel'])->name('admin.artikel.create');
        // V FIX: Tambahkan rute POST untuk memproses form
        Route::post('admin/artikel', [AdminController::class, 'storeArtikel'])->name('admin.artikel.store'); // <-- BARU
        Route::get('admin/produk/create', [AdminController::class, 'createProduk'])->name('admin.produk.create');
        Route::post('admin/produk', [AdminController::class, 'storeProduk'])->name('admin.produk.store'); // <-- BARU
        // Pemasukan harian
        Route::get('admin/pemasukan/harian', [AdminController::class, 'pemasukanHarian'])->name('admin.pemasukan.harian');

        // --- Rute Administrasi Pesanan BARU ---
        Route::get('admin/pesanan', [AdminController::class, 'manageOrders'])->name('admin.orders.manage');
        Route::post('admin/pesanan/{transaksi}/process', [AdminController::class, 'processOrder'])->name('admin.orders.process');
        Route::post('admin/pesanan/{transaksi}/complete', [AdminController::class, 'completeOrder'])->name('admin.orders.complete');
        Route::get('admin/riwayat-pembelian/semua', [AdminController::class, 'allPurchaseHistory'])->name('admin.all.history');

    });
});
