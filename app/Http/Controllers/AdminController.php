<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Produk; // <-- BARU
use App\Models\Kategori; // <-- BARU
use App\Models\Satuan; // <-- BARU
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
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

    public function pemasukanHarian(Request $request)
    {
        // Mendapatkan tanggal hari ini (sebagai string YYYY-MM-DD)
        $today = Carbon::now()->toDateString();

        // Mengambil semua detail transaksi hari ini, mengelompokkan per produk,
        $rekapitulasiPenjualan = DetailTransaksi::selectRaw('
                produks.nama_produk,
                detail_transaksis.harga_saat_transaksi AS harga_satuan,
                SUM(detail_transaksis.jumlah) AS total_kuantitas_terjual,
                SUM(detail_transaksis.subtotal) AS total_pemasukan_produk
            ')
            ->join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->join('produks', 'detail_transaksis.id_produk', '=', 'produks.id_produk')
            // PERUBAHAN KRUSIAL: Filter HANYA yang status pembayarannya 'Lunas'
            ->where('transaksis.status_pembayaran', 'Lunas')
            ->whereDate('transaksis.created_at', $today)
            ->groupBy('produks.nama_produk', 'detail_transaksis.harga_saat_transaksi')
            ->orderByDesc('total_pemasukan_produk')
            ->get();

        // Menghitung Total Pemasukan Keseluruhan hari ini
        $totalPemasukanHariIni = Transaksi::whereDate('created_at', $today)
            // PERUBAHAN KRUSIAL: Filter HANYA yang status pembayarannya 'Lunas'
            ->where('status_pembayaran', 'Lunas')
            ->sum('total_harga');

        return view('admin.pemasukan', compact('rekapitulasiPenjualan', 'totalPemasukanHariIni', 'today'));
    }

    public function manageOrders()
    {
        // Mengambil transaksi yang statusnya 'Baru' atau 'Diproses'
        // dan status pembayaran masih 'Pending'
        $orders = Transaksi::with('user', 'detailTransaksis.produk')
            ->whereIn('status_pesanan', ['Baru', 'Diproses'])
            ->where('status_pembayaran', 'Pending')
            ->latest()
            ->paginate(10);

        return view('admin.manajemen_pesanan', compact('orders'));
    }

    public function processOrder(Transaksi $transaksi)
    {
        if ($transaksi->status_pesanan === 'Selesai' || $transaksi->status_pembayaran === 'Lunas') {
            return redirect()->back()->with('error', 'Pesanan sudah selesai atau sudah lunas.');
        }

        // Set status pesanan menjadi 'Diproses'
        $transaksi->update([
            'status_pesanan' => 'Diproses',
        ]);

        return redirect()->route('admin.orders.manage')->with('success', 'Pesanan ' . $transaksi->kode_transaksi . ' berhasil diubah menjadi Diproses.');
    }

    public function completeOrder(Transaksi $transaksi)
    {
        if ($transaksi->status_pesanan === 'Selesai' || $transaksi->status_pembayaran === 'Lunas') {
            return redirect()->back()->with('error', 'Pesanan sudah selesai atau sudah lunas.');
        }

        $transaksi->update([
            'status_pesanan' => 'Selesai',
            'status_pembayaran' => 'Lunas',
        ]);

        return redirect()->route('admin.orders.manage')->with('success', 'Pesanan ' . $transaksi->kode_transaksi . ' berhasil diselesaikan dan dilunasi!');
    }
}
