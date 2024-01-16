<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Test User',
            'username' => 'Nepts1',
            'alamat' => 'Test User',
            'email' => 'test@example.com',
            'roles_id' => 1,
            'password' => Hash::make('password')
        ]);

        User::create([
            'nama_lengkap' => 'Test User',
            'username' => 'Nepts2',
            'alamat' => 'Test User',
            'email' => 'test1@example.com',
            'roles_id' => 2,
            'password' => Hash::make('password'),
        ]);
        User::create([
            'nama_lengkap' => 'Test User',
            'username' => 'Nepts3',
            'alamat' => 'Test User',
            'email' => 'test2@example.com',
            'roles_id' => 3,
            'password' => Hash::make('password')
        ]);
    }
}
