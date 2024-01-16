<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'buku_id' => $this->faker->unique()->numberBetween(1, 10),
            'tgl_peminjaman' => $this->faker->date(),
            'tgl_pengembalian' => $this->faker->date(),
            'status' => 'Belum Dikembalikan'
        ];
    }
}
