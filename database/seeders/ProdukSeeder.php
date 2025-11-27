<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Satuan;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Kategori (Pastikan slug sesuai dengan database Anda atau KategoriSeeder)
        $katObat = Kategori::where('slug', 'obat-dan-perawatan')->first()->id_kategori ?? 1;
        $katSuplemen = Kategori::where('slug', 'suplemen-dan-vitamin')->first()->id_kategori ?? 2;
        $katAlat = Kategori::where('slug', 'perangkat-dan-peralatan')->first()->id_kategori ?? 3;

        // Ambil ID Satuan
        $strip = Satuan::where('nama_satuan', 'Strip')->first()->id_satuan ?? 1;
        $botol = Satuan::where('nama_satuan', 'Botol')->first()->id_satuan ?? 2;
        $pcs = Satuan::where('nama_satuan', 'Pcs')->first()->id_satuan ?? 3;
        $tube = Satuan::firstOrCreate(['nama_satuan' => 'Tube'])->id_satuan;
        $box = Satuan::firstOrCreate(['nama_satuan' => 'Box'])->id_satuan;

        $products = [
            // Obat-obatan
            ['id_kategori' => $katObat, 'id_satuan' => $strip, 'nama_produk' => 'Paracetamol 500mg', 'harga_jual' => 3500, 'stok' => 100, 'deskripsi' => 'Obat pereda nyeri dan penurun demam.'],
            ['id_kategori' => $katObat, 'id_satuan' => $strip, 'nama_produk' => 'Amoxicillin 500mg', 'harga_jual' => 8000, 'stok' => 50, 'deskripsi' => 'Antibiotik untuk infeksi bakteri (harus dengan resep dokter).'],
            ['id_kategori' => $katObat, 'id_satuan' => $botol, 'nama_produk' => 'Sirup Obat Batuk Hitam', 'harga_jual' => 12000, 'stok' => 40, 'deskripsi' => 'Meredakan batuk berdahak dan melegakan tenggorokan.'],
            ['id_kategori' => $katObat, 'id_satuan' => $strip, 'nama_produk' => 'Antangin JRG', 'harga_jual' => 4500, 'stok' => 200, 'deskripsi' => 'Herbal untuk mengatasi masuk angin, mual, dan kembung.'],
            ['id_kategori' => $katObat, 'id_satuan' => $tube, 'nama_produk' => 'Salep Kulit 88', 'harga_jual' => 15000, 'stok' => 30, 'deskripsi' => 'Obat luar untuk penyakit kulit karena jamur.'],
            ['id_kategori' => $katObat, 'id_satuan' => $strip, 'nama_produk' => 'Promag Tablet', 'harga_jual' => 9000, 'stok' => 150, 'deskripsi' => 'Menetralkan asam lambung dan meredakan nyeri maag.'],
            ['id_kategori' => $katObat, 'id_satuan' => $botol, 'nama_produk' => 'Minyak Kayu Putih Cap Lang 60ml', 'harga_jual' => 24000, 'stok' => 80, 'deskripsi' => 'Menghangatkan tubuh dan mencegah gigitan nyamuk.'],
            ['id_kategori' => $katObat, 'id_satuan' => $strip, 'nama_produk' => 'Bodrex Sakit Kepala', 'harga_jual' => 5000, 'stok' => 120, 'deskripsi' => 'Meredakan sakit kepala ringan hingga sedang.'],
            ['id_kategori' => $katObat, 'id_satuan' => $botol, 'nama_produk' => 'Betadine Antiseptic 30ml', 'harga_jual' => 35000, 'stok' => 45, 'deskripsi' => 'Cairan antiseptik untuk mencegah infeksi pada luka.'],
            ['id_kategori' => $katObat, 'id_satuan' => $tube, 'nama_produk' => 'Voltaren Emulgel', 'harga_jual' => 65000, 'stok' => 25, 'deskripsi' => 'Gel pereda nyeri otot dan sendi.'],

            // Suplemen & Vitamin
            ['id_kategori' => $katSuplemen, 'id_satuan' => $botol, 'nama_produk' => 'Enervon-C Multivitamin', 'harga_jual' => 45000, 'stok' => 60, 'deskripsi' => 'Kombinasi Vitamin C dan B Kompleks untuk daya tahan tubuh.'],
            ['id_kategori' => $katSuplemen, 'id_satuan' => $strip, 'nama_produk' => 'Imboost Force', 'harga_jual' => 75000, 'stok' => 40, 'deskripsi' => 'Suplemen peningkat sistem kekebalan tubuh.'],
            ['id_kategori' => $katSuplemen, 'id_satuan' => $botol, 'nama_produk' => 'CDR Calcium-D-Redoxon', 'harga_jual' => 55000, 'stok' => 55, 'deskripsi' => 'Kalsium dan vitamin D untuk kesehatan tulang.'],
            ['id_kategori' => $katSuplemen, 'id_satuan' => $strip, 'nama_produk' => 'Sangobion Kapsul', 'harga_jual' => 20000, 'stok' => 90, 'deskripsi' => 'Penambah darah untuk mengatasi anemia.'],
            ['id_kategori' => $katSuplemen, 'id_satuan' => $botol, 'nama_produk' => 'Madu TJ Murni 150gr', 'harga_jual' => 28000, 'stok' => 70, 'deskripsi' => 'Madu murni asli untuk kesehatan harian.'],

            // Alat Kesehatan
            ['id_kategori' => $katAlat, 'id_satuan' => $box, 'nama_produk' => 'Masker Medis 3-Ply (Isi 50)', 'harga_jual' => 35000, 'stok' => 100, 'deskripsi' => 'Masker sekali pakai untuk perlindungan pernapasan.'],
            ['id_kategori' => $katAlat, 'id_satuan' => $pcs, 'nama_produk' => 'Termometer Digital Omron', 'harga_jual' => 85000, 'stok' => 20, 'deskripsi' => 'Alat pengukur suhu tubuh akurat dan cepat.'],
            ['id_kategori' => $katAlat, 'id_satuan' => $botol, 'nama_produk' => 'Hand Sanitizer Dettol 50ml', 'harga_jual' => 15000, 'stok' => 150, 'deskripsi' => 'Pembersih tangan praktis tanpa bilas.'],
            ['id_kategori' => $katAlat, 'id_satuan' => $pcs, 'nama_produk' => 'Kapas Pembersih Selection', 'harga_jual' => 12000, 'stok' => 85, 'deskripsi' => 'Kapas lembut untuk keperluan medis dan kosmetik.'],
            ['id_kategori' => $katAlat, 'id_satuan' => $pcs, 'nama_produk' => 'Perban Elastis 5cm', 'harga_jual' => 10000, 'stok' => 60, 'deskripsi' => 'Perban untuk membalut luka atau cedera otot.'],
        ];

        foreach ($products as $data) {
            Produk::create([
                'id_kategori' => $data['id_kategori'],
                'id_satuan' => $data['id_satuan'],
                'nama_produk' => $data['nama_produk'],
                'stok' => $data['stok'],
                'harga_jual' => $data['harga_jual'],
                'deskripsi' => $data['deskripsi'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
