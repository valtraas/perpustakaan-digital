<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $roles = [
            'Admin',
            'petugas',
            'peminjam'
        ];
        for ($i = 0; $i < count($roles); $i++) {
            Roles::create([
                'nama' => $roles[$i]
            ]);
        }

        $this->call([
            UserSeeder::class,
        ]);


        Buku::factory(1)->create();
        // Peminjaman::factory(5)->create();
    }
}
