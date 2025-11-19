<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Pemeriksaan peran Admin (id_role = 1)
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->id_role !== 1) {
                // Jika bukan Admin, tolak akses 403
                abort(403, 'Akses Dibatasi. Anda bukan Admin.');
            }
            return $next($request);
        });
    }

    public function createArtikel()
    {
        // Menampilkan form tambah artikel (placeholder)
        return view('artikel.create');
    }

    public function createProduk()
    {
        // Menampilkan form tambah produk (placeholder)
        return view('transaksi.create');
    }
}
