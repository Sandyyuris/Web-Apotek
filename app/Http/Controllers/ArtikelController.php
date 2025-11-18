<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = Artikel::latest();

        // Jika parameter kategori ada dan bukan 'Semua Artikel', terapkan filter
        if ($kategori && $kategori !== 'Semua Artikel') {
            $query->where('kategori', $kategori);
        }
        $articles = $query->paginate(9);
        return view('artikel.index', compact('articles', 'kategori'));
    }

    public function detailArtikel($id, $slug)
    {
        $article = Artikel::findOrFail($id);
        return view('artikel.detail_artikel', compact('article'));
    }
}
