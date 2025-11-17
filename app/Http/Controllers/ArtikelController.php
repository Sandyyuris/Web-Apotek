<?php

namespace App\Http\Controllers;

use App\Models\Artikel; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $articles = Artikel::latest()->paginate(9);
        return view('artikel', compact('articles'));
    }

    public function detailArtikel($slug)
    {
        return view('artikel_detail');
    }
}
