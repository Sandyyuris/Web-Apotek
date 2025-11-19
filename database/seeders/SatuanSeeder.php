<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $satuans = [
            'Strip',
            'Tablet',
            'Unit',
            'Botol',
            'Kotak',
            'Pcs',
        ];

        foreach ($satuans as $satuan) {
            Satuan::firstOrCreate(['nama_satuan' => $satuan]);
        }
    }
}
