<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
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
        $query = Produk::with(['kategori', 'satuan'])->where('stok', '>', 0)->orderBy('nama_produk');
        if ($searchQuery) {
            $query->where('nama_produk', 'like', '%'.$searchQuery.'%');
        }

        $selectedKategori = $request->get('kategori');
        if ($selectedKategori) {
            $query->whereHas('kategori', function($q) use ($selectedKategori) {
                $q->where('slug', $selectedKategori);
            });
        }

        $produks = $query->paginate(12)->withQueryString();
        $cart = session()->get('cart', []);
        return view('transaksi.index', compact('produks', 'cart', 'kategoris', 'selectedKategori'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::with('satuan')->findOrFail($request->id_produk);
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if ($quantity > $produk->stok) {
            return redirect()->back()->with('error_to_cart', 'Stok ' . $produk->nama_produk . ' (' . $produk->stok . ') tidak mencukupi untuk permintaan ' . $quantity . '.');
        }

        if (isset($cart[$produk->id_produk])) {
            $currentQuantity = $cart[$produk->id_produk]['quantity'];
            $newQuantity = $currentQuantity + $quantity;

            if ($newQuantity > $produk->stok) {
                return redirect()->back()->with('error_to_cart', 'Total permintaan produk (' . $newQuantity . ') melebihi stok yang ada (' . $produk->stok . ').');
            }
            $quantity = $newQuantity;
        }

        $subtotal = $produk->harga_jual * $quantity;
        $cart[$produk->id_produk] = [
            'id_produk' => $produk->id_produk,
            'nama_produk' => $produk->nama_produk,
            'harga_jual' => $produk->harga_jual,
            'satuan' => $produk->satuan->nama_satuan ?? 'Pcs',
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];

        session()->put('cart', $cart);
        return redirect()->route('transaksi.index')->with('add_to_cart', $produk->nama_produk . ' berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart($id_produk)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id_produk])) {
            $produkName = $cart[$id_produk]['nama_produk'];
            unset($cart[$id_produk]);
            session()->put('cart', $cart);
            return redirect()->route('transaksi.index')->with('remove_from_cart', $produkName . ' berhasil dihapus dari keranjang.');
        }
        return redirect()->route('transaksi.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function showCheckoutForm(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('transaksi.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
        $subtotalProduk = collect($cart)->sum('subtotal');
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
        $request->validate([
            'tipe_pengiriman' => 'required|in:Diambil di Apotek,Diantar',
            'metode_pembayaran' => 'required|in:Transfer,Cash',
            'alamat_pengiriman' => 'nullable|required_if:tipe_pengiriman,Diantar|string|max:500',
        ], [
            'alamat_pengiriman.required_if' => 'Alamat pengiriman wajib diisi jika Anda memilih pengiriman Diantar.',
        ]);

        $subtotalProduk = collect($cart)->sum('subtotal');
        $biayaPengiriman = 0;
        $BIAYA_ANTAR = 10000;

        if ($request->tipe_pengiriman === 'Diantar') {
            $biayaPengiriman = $BIAYA_ANTAR;
        }

        $totalHarga = $subtotalProduk + $biayaPengiriman;
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'id_users' => Auth::id(),
                'kode_transaksi' => 'TRX-' . Str::upper(Str::random(5)) . '-' . time(),
                'total_harga' => $totalHarga,
                'biaya_pengiriman' => $biayaPengiriman,
                'tipe_pengiriman' => $request->tipe_pengiriman,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'Pending',
                'status_pesanan' => 'Baru',
            ]);

            foreach ($cart as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['quantity'],
                    'harga_saat_transaksi' => $item['harga_jual'],
                    'subtotal' => $item['subtotal'],
                ]);
                Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['quantity']);
            }

            session()->forget('cart');
            DB::commit();
            return redirect('/')->with('success', 'Transaksi berhasil! Rincian: Total: Rp ' . number_format($totalHarga, 0, ',', '.') . '. Jenis Pengiriman: ' . $request->tipe_pengiriman . '. Metode Pembayaran: ' . $request->metode_pembayaran);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }
}
