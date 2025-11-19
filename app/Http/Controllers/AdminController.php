<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\KategoriArtikel;


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
        // Kirim daftar kategori artikel ke view
        $kategoris = KategoriArtikel::all();
        return view('artikel.create', compact('kategoris')); // <-- PERUBAHAN
    }

    public function storeArtikel(Request $request)
    {
        // 1. Lakukan Validasi
        $request->validate([
            'judul' => 'required|max:255',
            'id_kategori_artikel' => 'required|exists:kategori_artikels,id_kategori_artikel', // <-- PERUBAHAN: Validasi ke tabel baru
            'isi' => 'required',
            'path_foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $path_foto = null;

        // 2. Tangani Upload File (jika ada)
        if ($request->hasFile('path_foto')) {
            $path_foto = $request->file('path_foto')->store('artikel_photos', 'public');
        }

        // 3. Simpan Data ke Database
        Artikel::create([
            'id_kategori_artikel' => $request->id_kategori_artikel, // <-- PERUBAHAN
            'judul' => $request->judul,
            'isi' => $request->isi,
            'path_foto' => $path_foto,
        ]);

        $kategoriNama = KategoriArtikel::find($request->id_kategori_artikel)->nama_kategori ?? 'Tanpa Kategori';

        return redirect()->route('artikel.index')->with('success', 'Artikel **' . $request->judul . '** di kategori **' . $kategoriNama . '** berhasil dipublikasikan!');
    }

    public function createProduk()
    {
        // Menampilkan form tambah produk (placeholder)
        return view('transaksi.create');
    }
}
