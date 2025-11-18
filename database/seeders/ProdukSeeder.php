<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Kategori;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori sudah ada
        $suplemenId = Kategori::where('slug', 'suplemen-dan-vitamin')->first()->id_kategori ?? 1;
        $obatId = Kategori::where('slug', 'obat-dan-perawatan')->first()->id_kategori ?? 2;
        $perangkatId = Kategori::where('slug', 'perangkat-dan-peralatan')->first()->id_kategori ?? 4;

        $produks = [
            [
                'id_kategori' => $obatId,
                'nama_produk' => 'Paracetamol 500mg',
                'satuan' => 'Strip',
                'stok' => 150,
                'harga_jual' => 5000,
                'deskripsi' => 'Obat penurun panas dan pereda nyeri ringan.',
                'created_at' => Carbon::now(),
            ],
            [
                'id_kategori' => $suplemenId,
                'nama_produk' => 'Vitamin C 1000mg',
                'satuan' => 'Tablet',
                'stok' => 300,
                'harga_jual' => 3000,
                'deskripsi' => 'Suplemen untuk meningkatkan daya tahan tubuh.',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'id_kategori' => $perangkatId,
                'nama_produk' => 'Tensimeter Digital',
                'satuan' => 'Unit',
                'stok' => 25,
                'harga_jual' => 350000,
                'deskripsi' => 'Alat pengukur tekanan darah digital otomatis.',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'id_kategori' => $obatId,
                'nama_produk' => 'Minyak Kayu Putih',
                'satuan' => 'Botol',
                'stok' => 200,
                'harga_jual' => 18000,
                'deskripsi' => 'Membantu meredakan perut kembung dan masuk angin.',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($produks as $produkData) {
            Produk::create($produkData);
        }
    }
}
