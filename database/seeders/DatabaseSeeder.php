<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KategoriSeeder::class,
            SatuanSeeder::class,
            KategoriArtikelSeeder::class,
            ArtikelSeeder::class,
            ProdukSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Sandy',
            'username' => 'admin',
            'password' => Hash::make('123' ),
            'id_role' => 1,
        ]);
    }
}
