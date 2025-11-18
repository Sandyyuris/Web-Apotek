<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Suplemen dan Vitamin',
            'Obat dan Perawatan',
            'Sport dan Fitness',
            'Perangkat dan Peralatan',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama_kategori' => $kategori,
                'slug' => \Illuminate\Support\Str::slug($kategori),
            ]);
        }
    }
}
