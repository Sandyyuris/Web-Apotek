<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nama_role' => 'Admin'],
            ['nama_role' => 'Dokter'],
            ['nama_role' => 'Customer'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
