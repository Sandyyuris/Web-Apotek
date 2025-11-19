<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel; // <-- BARU
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategoriSlug = $request->query('kategori');
        $searchQuery = $request->query('q');

        // Eager load relasi kategoriArtikel
        $query = Artikel::with('kategoriArtikel')->latest(); // <-- PERUBAHAN

        // Filter berdasarkan kategori
        $selectedKategoriName = 'Semua Artikel';
        if ($kategoriSlug && $kategoriSlug !== 'Semua Artikel') {
            $kategori = KategoriArtikel::where('slug', $kategoriSlug)->first();
            if ($kategori) {
                $query->where('id_kategori_artikel', $kategori->id_kategori_artikel);
                $selectedKategoriName = $kategori->nama_kategori;
            }
        }

        // Filter berdasarkan judul (Pencarian)
        if ($searchQuery) {
            $query->where('judul', 'like', '%'.$searchQuery.'%');
        }

        $articles = $query->paginate(9)->withQueryString();

        // Ambil semua kategori artikel untuk tampilan filter
        $kategoris = KategoriArtikel::all();

        return view('artikel.index', compact('articles', 'selectedKategoriName', 'kategoris')); // <-- PERUBAHAN variabel untuk view
    }

    public function detailArtikel($id, $slug)
    {
        // Tambahkan eager loading untuk relasi kategoriArtikel
        $article = Artikel::with('kategoriArtikel')->findOrFail($id); // <-- PERUBAHAN
        return view('artikel.detail_artikel', compact('article'));
    }
}
