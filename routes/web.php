<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Halaman Utama / Artikel Index
Route::get('/', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('artikel/{slug}', [ArtikelController::class, 'detailArtikel'])->name('artikel.detail');

// Rute Login
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Rute Register (PENTING: Harus ada name('register'))
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rute Logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
