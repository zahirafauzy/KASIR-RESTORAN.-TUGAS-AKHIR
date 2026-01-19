<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Makanan',
            'Minuman',
            'Dessert',
            'Cemilan',
            'Paket Hemat'
        ];

        foreach ($kategoris as $k) {
            Kategori::create([
                'nama_kategori' => $k
            ]);
        }
    }
}
