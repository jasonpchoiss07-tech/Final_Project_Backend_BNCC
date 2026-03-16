<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            'Elektronik',
            'Makanan & Minuman',
            'Pakaian',
            'Perabot Rumah',
            'Olahraga',
        ];

        foreach ($kategoris as $nama) {
            KategoriBarang::create(['nama_kategori' => $nama]);
        }
    }
}
