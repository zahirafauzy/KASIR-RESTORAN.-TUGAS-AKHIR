<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cart = [
            // [
            //     'id_menu' => 3,
            //     'jumlah'  => 1,
            // ],
            // [
            //     'id_menu' => 2,
            //     'jumlah'  => 2,
            // ],
        ];
        foreach ($cart as $item) {
            Cart::create($item);
        }
    }
}
