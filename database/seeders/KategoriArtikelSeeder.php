<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriArtikel;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Obat',
            'Tips Hidup Sehat',
        ];

        foreach ($kategoris as $kategori) {
            KategoriArtikel::firstOrCreate([
                'nama_kategori' => $kategori,
                'slug' => \Illuminate\Support\Str::slug($kategori),
            ]);
        }
    }
}
