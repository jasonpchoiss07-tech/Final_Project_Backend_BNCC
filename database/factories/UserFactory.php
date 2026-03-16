<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_lengkap'    => $this->faker->name(),
            'email'           => $this->faker->unique()->userName() . '@gmail.com',
            'password'        => Hash::make('password'),
            'nomor_handphone' => '08' . $this->faker->numerify('##########'),
            'role'            => 'user',
            'remember_token'  => Str::random(10),
        ];
    }
}
