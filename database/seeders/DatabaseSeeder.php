<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            ArtikelSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Sandy',
            'username' => 'admin',
            'password' => Hash::make('123' ),
            'id_role' => 1,
        ]);
    }
}
