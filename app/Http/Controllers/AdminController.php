<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Produk; // <-- BARU
use App\Models\Kategori; // <-- BARU
use App\Models\Satuan; // <-- BARU
use Illuminate\Validation\Rule;


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
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();
        // Menggunakan view yang diperbarui dan passing data
        return view('transaksi.create', compact('kategoris', 'satuans')); // <-- PERUBAHAN
    }
    /**
     * Menyimpan produk baru ke database.
     */
    public function storeProduk(Request $request) // <-- BARU
    {
        // 1. Lakukan Validasi
        $request->validate([
            // Nama produk harus unik di tabel 'produks'
            'nama_produk' => ['required', 'string', 'max:255', Rule::unique('produks', 'nama_produk')],
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'id_satuan' => 'required|exists:satuans,id_satuan',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'nama_produk.unique' => 'Nama produk ini sudah ada di database.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',
        ]);

        // 2. Simpan Data ke Database
        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'id_satuan' => $request->id_satuan,
            'nama_produk' => $request->nama_produk,
            'stok' => $request->stok,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Produk ' . $produk->nama_produk . ' berhasil ditambahkan!');
    }
}
