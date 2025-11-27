<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Api\Upload\UploadApi;



class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->id_role !== 1) {
                abort(403, 'Akses Dibatasi. Anda bukan Admin.');
            }
            return $next($request);
        });
    }

    public function createArtikel()
    {
        $kategoris = KategoriArtikel::all();
        return view('artikel.create', compact('kategoris'));
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_kategori_artikel' => 'required|exists:kategori_artikels,id_kategori_artikel',
            'isi' => 'required',
            'path_foto' => 'nullable|image|max:5120',
        ]);

        $folderPath = 'web-apotek-artikel';
        $file = $request->file('path_foto')->getClientOriginalName();
        $file_name = pathinfo($file, PATHINFO_FILENAME);
        $public_id = date('y-m-d_His') . '_' . $file_name;
        $upload  =  (new  UploadApi())->upload(  $request->file('path_foto')->getRealPath(),
        [
            'public_id'  =>  $public_id,
            'folder'  =>  $folderPath
        ]);
        $secureUrl  =  $upload['secure_url'];

        Artikel::create([
            'id_kategori_artikel' => $request->id_kategori_artikel,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'path_foto' => $secureUrl,
        ]);

        $kategoriNama = KategoriArtikel::find($request->id_kategori_artikel)->nama_kategori ?? 'Tanpa Kategori';

        return redirect()->route('artikel.index')->with('success', 'Artikel ' . $request->judul . ' di kategori ' . $kategoriNama . ' berhasil dipublikasikan!');
    }

    public function editArtikel(Artikel $artikel)
    {
        $kategoris = KategoriArtikel::all();
        return view('artikel.edit', compact('artikel', 'kategoris'));
    }

    public function updateArtikel(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => [
                'required',
                'max:255',
                Rule::unique('artikels', 'judul')->ignore($artikel->id_artikel, 'id_artikel'),
            ],
            'id_kategori_artikel' => 'required|exists:kategori_artikels,id_kategori_artikel',
            'isi' => 'required',
            'path_foto' => 'nullable|image|max:5120',
        ]);

        $dataToUpdate = $request->only(['id_kategori_artikel', 'judul', 'isi']);
        $secureUrl = $artikel->path_foto;

        if ($request->hasFile('path_foto')) {
            $folderPath = 'web-apotek-artikel';
            $file = $request->file('path_foto')->getClientOriginalName();
            $file_name = pathinfo($file, PATHINFO_FILENAME);
            $public_id = date('y-m-d_His') . '_' . $file_name;
            $upload  =  (new  UploadApi())->upload(  $request->file('path_foto')->getRealPath(),
            [
                'public_id'  =>  $public_id,
                'folder'  =>  $folderPath
            ]);
            $secureUrl  =  $upload['secure_url'];
            $dataToUpdate['path_foto'] = $secureUrl;
        }

        $artikel->update($dataToUpdate);
        return redirect()->route('artikel.detail', ['id' => $artikel->id_artikel, 'slug' => \Illuminate\Support\Str::slug($artikel->judul)])
            ->with('success', 'Artikel ' . $artikel->judul . ' berhasil diperbarui!');
    }

    public function deleteArtikel(Artikel $artikel)
    {
        $judul = $artikel->judul;
        $artikel->delete();
        return redirect()->route('artikel.index')->with('success', 'Artikel ' . $judul . ' berhasil dihapus.');
    }


    public function createProduk()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();
        return view('transaksi.create', compact('kategoris', 'satuans'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
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

    public function editProduk(Produk $produk)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();

        return view('transaksi.edit', compact('produk', 'kategoris', 'satuans'));
    }

    public function updateProduk(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produks', 'nama_produk')->ignore($produk->id_produk, 'id_produk')
            ],
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

        $produk->update($request->only(['nama_produk', 'id_kategori', 'id_satuan', 'stok', 'harga_jual', 'deskripsi']));
        return redirect()->route('transaksi.index')->with('success', 'Produk ' . $produk->nama_produk . ' berhasil diperbarui!');
    }

    public function deleteProduk(Produk $produk)
    {
        $namaProduk = $produk->nama_produk;

        try {
            if ($produk->detailTransaksis()->exists()) {
                return redirect()->back()->with('error', 'Produk ' . $namaProduk . ' tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
            }
            $produk->delete();
            return redirect()->route('transaksi.index')->with('success', 'Produk ' . $namaProduk . ' berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    public function pemasukanHarian(Request $request)
    {
        $today = Carbon::now()->toDateString();
        $rekapitulasiPenjualan = DetailTransaksi::selectRaw('
                produks.nama_produk,
                detail_transaksis.harga_saat_transaksi AS harga_satuan,
                SUM(detail_transaksis.jumlah) AS total_kuantitas_terjual,
                SUM(detail_transaksis.subtotal) AS total_pemasukan_produk
            ')
            ->join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->join('produks', 'detail_transaksis.id_produk', '=', 'produks.id_produk')
            ->where('transaksis.status_pembayaran', 'Lunas')
            ->whereDate('transaksis.created_at', $today)
            ->groupBy('produks.nama_produk', 'detail_transaksis.harga_saat_transaksi')
            ->orderByDesc('total_pemasukan_produk')
            ->get();

        $totalPemasukanHariIni = Transaksi::whereDate('created_at', $today)
            ->where('status_pembayaran', 'Lunas')
            ->sum('total_harga');

        return view('admin.pemasukan', compact('rekapitulasiPenjualan', 'totalPemasukanHariIni', 'today'));
    }

    public function manageOrders()
    {
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

    public function allPurchaseHistory()
    {
        $allHistories = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->latest()
            ->paginate(15);
        $totalPemasukan = Transaksi::where('status_pembayaran', 'Lunas')->sum('total_harga');
        return view('admin.riwayat_semua_pembelian', compact('allHistories', 'totalPemasukan'));
    }
}
// asdasd
