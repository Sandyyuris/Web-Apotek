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
    public function index(Request $request)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $searchQuery = $request->get('q');

        // Eager load relasi kategori dan SATUAN untuk menghindari N+1 query dan mengambil nama satuan
        $query = Produk::with(['kategori', 'satuan'])->where('stok', '>', 0)->orderBy('nama_produk'); // <-- PERUBAHAN

        // Filter berdasarkan nama produk (Pencarian) <-- BARU
        if ($searchQuery) {
            $query->where('nama_produk', 'like', '%'.$searchQuery.'%');
        }

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

        $produk = Produk::with('satuan')->findOrFail($request->id_produk); // <-- PERUBAHAN
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
            'nama_produk' => $produk->nama_produk,
            'harga_jual' => $produk->harga_jual,
            'satuan' => $produk->satuan->nama_satuan ?? 'Pcs', // <-- PERUBAHAN: Mengambil nama_satuan dari relasi
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
     * Proses checkout dan simpan transaksi beserta detailnya.
     */
    public function showCheckoutForm(Request $request) // <-- BARU
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Hitung subtotal produk tanpa biaya kirim
        $subtotalProduk = collect($cart)->sum('subtotal');

        // Biaya pengiriman akan dihitung dan ditampilkan di sisi klien/formulir
        $defaultTipe = 'Diambil di Apotek';

        return view('transaksi.checkout', compact('cart', 'subtotalProduk', 'defaultTipe'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus masuk untuk menyelesaikan transaksi.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 1. Validasi Input Baru
        $request->validate([
            'tipe_pengiriman' => 'required|in:Diambil di Apotek,Diantar',
            'metode_pembayaran' => 'required|in:Transfer,Cash',
            // Alamat wajib diisi jika tipe_pengiriman adalah 'Diantar'
            'alamat_pengiriman' => 'nullable|required_if:tipe_pengiriman,Diantar|string|max:500',
        ], [
            'alamat_pengiriman.required_if' => 'Alamat pengiriman wajib diisi jika Anda memilih pengiriman Diantar.',
        ]);

        // 2. Hitung Total Harga dan Biaya Kirim
        $subtotalProduk = collect($cart)->sum('subtotal');
        $biayaPengiriman = 0;
        $BIAYA_ANTAR = 10000; // Biaya tetap 10.000

        if ($request->tipe_pengiriman === 'Diantar') {
            $biayaPengiriman = $BIAYA_ANTAR;
        }

        $totalHarga = $subtotalProduk + $biayaPengiriman;


        DB::beginTransaction();

        try {
            // 3. Buat Transaksi Baru
            $transaksi = Transaksi::create([
                'id_users' => Auth::id(),
                'kode_transaksi' => 'TRX-' . Str::upper(Str::random(5)) . '-' . time(),
                'total_harga' => $totalHarga,
                'biaya_pengiriman' => $biayaPengiriman, // <-- BARU
                'tipe_pengiriman' => $request->tipe_pengiriman, // <-- BARU
                'alamat_pengiriman' => $request->alamat_pengiriman, // <-- BARU
                'metode_pembayaran' => $request->metode_pembayaran, // <-- BARU
                'status_pembayaran' => 'Pending',
                'status_pesanan' => 'Baru',
                 // Ubah status awal menjadi Pending
            ]);

            // 4. Simpan Detail Transaksi & Kurangi Stok
            foreach ($cart as $item) {
                // Simpan Detail
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_saat_transaksi' => $item['harga_jual'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi Stok Produk
                Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['quantity']);
            }

            // 5. Kosongkan Keranjang & Commit
            session()->forget('cart');
            DB::commit();

            return redirect('/')->with('success', 'Transaksi berhasil! Rincian: Total: Rp ' . number_format($totalHarga, 0, ',', '.') . '. Jenis Pengiriman: ' . $request->tipe_pengiriman . '. Metode Pembayaran: ' . $request->metode_pembayaran);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }
}
