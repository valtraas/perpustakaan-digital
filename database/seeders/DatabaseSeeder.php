<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Buku;
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

        \App\Models\User::create([
            'nama_lengkap' => 'Test User',
            'username' => 'Nepts',
            'alamat' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);
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

        Buku::factory(10)->create();
    }
}
