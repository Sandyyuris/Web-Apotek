<?php

namespace App\Http\Controllers;

use App\Models\Produk; // <-- GANTI DARI Obat
use App\Models\Kategori; // <-- BARU
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar produk, kategori, dan keranjang.
     */
    public function index(Request $request)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $query = Produk::where('stok', '>', 0)->orderBy('nama_produk');

        $selectedKategori = $request->get('kategori');

        // Filter berdasarkan kategori
        if ($selectedKategori) {
            $query->whereHas('kategori', function($q) use ($selectedKategori) {
                $q->where('slug', $selectedKategori);
            });
        }

        $produks = $query->paginate(12)->withQueryString();

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        return view('transaksi.index', compact('produks', 'cart', 'kategoris', 'selectedKategori')); // <-- Tambah variabel baru
    }

    /**
     * Menambahkan produk ke keranjang (menggunakan Session).
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk', // <-- GANTI DARI id_obat
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk); // <-- GANTI DARI Obat
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if ($quantity > $produk->stok) {
            return redirect()->back()->with('error', 'Stok ' . $produk->nama_produk . ' (' . $produk->stok . ') tidak mencukupi untuk permintaan ' . $quantity . '.');
        }

        // Jika item sudah ada di keranjang, tambahkan quantity-nya
        if (isset($cart[$produk->id_produk])) {
            $currentQuantity = $cart[$produk->id_produk]['quantity'];
            $newQuantity = $currentQuantity + $quantity;

            if ($newQuantity > $produk->stok) {
                return redirect()->back()->with('error', 'Total permintaan produk (' . $newQuantity . ') melebihi stok yang ada (' . $produk->stok . ').');
            }
            $quantity = $newQuantity;
        }

        $subtotal = $produk->harga_jual * $quantity;

        $cart[$produk->id_produk] = [
            'id_produk' => $produk->id_produk,
            'nama_produk' => $produk->nama_produk, // <-- GANTI DARI nama_obat
            'harga_jual' => $produk->harga_jual,
            'satuan' => $produk->satuan,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];

        session()->put('cart', $cart);

        return redirect()->route('transaksi.index')->with('success', $produk->nama_produk . ' berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function removeFromCart($id_produk) // <-- GANTI DARI id_obat
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id_produk])) {
            $produkName = $cart[$id_produk]['nama_produk']; // <-- GANTI DARI nama_obat
            unset($cart[$id_produk]);
            session()->put('cart', $cart);
            return redirect()->route('transaksi.index')->with('success', $produkName . ' berhasil dihapus dari keranjang.');
        }

        return redirect()->route('transaksi.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    /**
     * Memproses checkout dan menyimpan transaksi.
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus masuk untuk menyelesaikan transaksi.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalHarga = collect($cart)->sum('subtotal');

        DB::beginTransaction();

        try {
            // 1. Buat Transaksi Baru
            $transaksi = Transaksi::create([
                'id_users' => Auth::id(),
                'kode_transaksi' => 'TRX-' . Str::upper(Str::random(5)) . '-' . time(),
                'total_harga' => $totalHarga,
                'status_pembayaran' => 'Lunas',
            ]);

            // 2. Simpan Detail Transaksi & Kurangi Stok
            foreach ($cart as $item) {
                // Simpan Detail
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $item['id_produk'], // <-- GANTI DARI id_obat
                    'jumlah' => $item['quantity'],
                    'harga_saat_transaksi' => $item['harga_jual'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi Stok Produk
                Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['quantity']); // <-- GANTI DARI Obat
            }

            // 3. Kosongkan Keranjang & Commit
            session()->forget('cart');
            DB::commit();

            return redirect('/')->with('success', 'Transaksi berhasil! Total pembayaran: Rp ' . number_format($totalHarga, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            // Anda dapat menambahkan logging di sini: \Log::error($e->getMessage());
            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }
}
