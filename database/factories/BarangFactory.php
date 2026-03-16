<?php

namespace Database\Factories;

use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    public function definition()
    {
        $namaBarang = [
            'Laptop ASUS VivoBook', 'Smartphone Samsung A54', 'Headphone Sony WH',
            'Kemeja Batik Premium', 'Celana Jeans Slim Fit', 'Sepatu Sneakers Nike',
            'Bakmi Goreng Spesial', 'Kopi Arabika Gayo', 'Teh Hijau Premium',
            'Meja Belajar Kayu Jati', 'Kursi Gaming Ergonomis', 'Lampu LED Smart',
            'Dumbbell Set 10kg', 'Sepatu Lari Adidas', 'Raket Badminton Yonex',
        ];

        return [
            'kategori_id'   => KategoriBarang::inRandomOrder()->first()?->id ?? 1,
            'nama_barang'   => $this->faker->unique()->randomElement($namaBarang),
            'harga_barang'  => $this->faker->numberBetween(10000, 5000000),
            'jumlah_barang' => $this->faker->numberBetween(0, 100),
            'foto_barang'   => null,
        ];
    }
}
