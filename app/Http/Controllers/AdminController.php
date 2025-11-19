<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;

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

public function storeArtikel(Request $request)
    {
        // 1. Lakukan Validasi
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => 'required',
            'isi' => 'required',
            'path_foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $path_foto = null;

        // 2. Tangani Upload File (jika ada)
        if ($request->hasFile('path_foto')) {
            // Simpan file ke folder 'artikel_photos' pada disk 'public'
            // Disk 'public' diarahkan ke storage/app/public/
            $path_foto = $request->file('path_foto')->store('artikel_photos', 'public');
        }

        // 3. Simpan Data ke Database
        Artikel::create([
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'path_foto' => $path_foto, // Simpan path relatif ke database
        ]);

        return redirect()->route('artikel.index')->with('success', 'Artikel **' . $request->judul . '** berhasil dipublikasikan!');
    }

    public function createProduk()
    {
        // Menampilkan form tambah produk (placeholder)
        return view('transaksi.create');
    }
}
