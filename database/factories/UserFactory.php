<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_user' => Str::uuid(),
            'nama_lengkap' => $this->faker->name(),
            'alamat_user' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'),
            'foto_user' => null,
            'jenis_kelamin' => 'L',
            'status' => 'aktif',
            'tanggal_masuk' => now(),
            'tanggal_keluar' => null,
            'id_role' => null,
        ];
    }
}
