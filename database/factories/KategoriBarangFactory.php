<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriBarangFactory extends Factory
{
    public function definition()
    {
        $kategoris = [
            'Elektronik', 'Makanan & Minuman', 'Pakaian', 'Perabot Rumah',
            'Olahraga', 'Kesehatan', 'Otomotif', 'Buku & Alat Tulis',
            'Mainan Anak', 'Kecantikan',
        ];

        return [
            'nama_kategori' => $this->faker->unique()->randomElement($kategoris),
        ];
    }
}
