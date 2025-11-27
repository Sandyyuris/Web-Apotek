<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;

Route::get('/', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('artikel/{id}/{slug}', [ArtikelController::class, 'detailArtikel'])->name('artikel.detail');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/chat', [ChatBotController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatBotController::class, 'sendMessage'])->name('chat.send');

    Route::get('transaksi/produk', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('transaksi/tambah-keranjang', [TransaksiController::class, 'addToCart'])->name('transaksi.addToCart');
    Route::get('transaksi/hapus-keranjang/{id_produk}', [TransaksiController::class, 'removeFromCart'])->name('transaksi.removeFromCart');
    Route::post('transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

    Route::get('profil', [UserController::class, 'index'])->name('profile.index');
    Route::get('profil/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('profil/update', [UserController::class, 'update'])->name('profile.update');
    Route::get('profil/riwayat', [UserController::class, 'riwayatPembelian'])->name('profile.history');

    Route::get('transaksi/checkout/form', [TransaksiController::class, 'showCheckoutForm'])->name('transaksi.checkout.form');
    Route::post('transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');

    Route::group([], function () {
        Route::get('admin/artikel/create', [AdminController::class, 'createArtikel'])->name('admin.artikel.create');
        Route::post('admin/artikel', [AdminController::class, 'storeArtikel'])->name('admin.artikel.store');
        Route::get('admin/produk/create', [AdminController::class, 'createProduk'])->name('admin.produk.create');
        Route::post('admin/produk', [AdminController::class, 'storeProduk'])->name('admin.produk.store');
        Route::get('admin/pemasukan/harian', [AdminController::class, 'pemasukanHarian'])->name('admin.pemasukan.harian');

        Route::get('admin/pesanan', [AdminController::class, 'manageOrders'])->name('admin.orders.manage');
        Route::post('admin/pesanan/{transaksi}/process', [AdminController::class, 'processOrder'])->name('admin.orders.process');
        Route::post('admin/pesanan/{transaksi}/complete', [AdminController::class, 'completeOrder'])->name('admin.orders.complete');
        Route::get('admin/riwayat-pembelian/semua', [AdminController::class, 'allPurchaseHistory'])->name('admin.all.history');

        Route::get('admin/artikel/{artikel}/edit', [AdminController::class, 'editArtikel'])->name('admin.artikel.edit');
        Route::delete('admin/artikel/{artikel}', [AdminController::class, 'deleteArtikel'])->name('admin.artikel.delete');
        Route::patch('admin/artikel/{artikel}', [AdminController::class, 'updateArtikel'])->name('admin.artikel.update');

        Route::get('admin/produk/{produk}/edit', [AdminController::class, 'editProduk'])->name('admin.produk.edit');
        Route::delete('admin/produk/{produk}', [AdminController::class, 'deleteProduk'])->name('admin.produk.delete');
        Route::patch('admin/produk/{produk}', [AdminController::class, 'updateProduk'])->name('admin.produk.update');
    });
});
