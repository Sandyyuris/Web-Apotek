<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $searchQuery = $request->query('q'); // <-- BARU

        $query = Artikel::latest();

        // Filter berdasarkan kategori
        if ($kategori && $kategori !== 'Semua Artikel') {
            $query->where('kategori', $kategori);
        }

        // Filter berdasarkan judul (Pencarian) <-- BARU
        if ($searchQuery) {
            $query->where('judul', 'like', '%'.$searchQuery.'%');
        }

        $articles = $query->paginate(9)->withQueryString(); // <-- Tambahkan withQueryString()

        return view('artikel.index', compact('articles', 'kategori'));
    }

    public function detailArtikel($id, $slug)
    {
        $article = Artikel::findOrFail($id);
        return view('artikel.detail_artikel', compact('article'));
    }
}
