<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            [
                'id_kategori' => 1,
                'nama_menu'   => 'Nasi Goreng Spesial',
                'harga_menu'  => 25000,
                'stok_menu'   => 20,
                'image_menu'  => 'nasigoreng.png'
            ],
            [
                'id_kategori' => 1,
                'nama_menu'   => 'Ayam Geprek',
                'harga_menu'  => 20000,
                'stok_menu'   => 30,
                'image_menu'  => 'ayamgeprek.png'
            ],
            [
                'id_kategori' => 2,
                'nama_menu'   => 'Es Teh Manis',
                'harga_menu'  => 5000,
                'stok_menu'   => 50,
                'image_menu'  => 'esteh.png'
            ],
            [
                'id_kategori' => 2,
                'nama_menu'   => 'Jus Alpukat',
                'harga_menu'  => 15000,
                'stok_menu'   => 25,
                'image_menu'  => 'jusalpukat.png'
            ],
            [
                'id_kategori' => 3,
                'nama_menu'   => 'Puding Cokelat',
                'harga_menu'  => 12000,
                'stok_menu'   => 15,
                'image_menu'  => 'pudingcokelat.png'
            ],
        ];

        foreach ($menu as $item) {
            Menu::create($item);
        }
    }
}
