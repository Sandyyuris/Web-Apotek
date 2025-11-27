<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategoriSlug = $request->query('kategori');
        $searchQuery = $request->query('q');
        $query = Artikel::with('kategoriArtikel')->latest();
        $selectedKategoriName = 'Semua Artikel';
        if ($kategoriSlug && $kategoriSlug !== 'Semua Artikel') {
            $kategori = KategoriArtikel::where('slug', $kategoriSlug)->first();
            if ($kategori) {
                $query->where('id_kategori_artikel', $kategori->id_kategori_artikel);
                $selectedKategoriName = $kategori->nama_kategori;
            }
        }

        if ($searchQuery) {
            $query->where('judul', 'like', '%'.$searchQuery.'%');
        }

        $articles = $query->paginate(9)->withQueryString();
        $kategoris = KategoriArtikel::all();
        return view('artikel.index', compact('articles', 'selectedKategoriName', 'kategoris'));
    }

    public function detailArtikel($id, $slug)
    {
        $article = Artikel::with('kategoriArtikel')->findOrFail($id);
        return view('artikel.detail_artikel', compact('article'));
    }
}
