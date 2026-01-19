<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = [
            [
                'username' => 'admin',
                'password' => Hash::make('123'),
                'role' => 'admin'
            ],
            [
                'username' => 'kasir',
                'password' => Hash::make('123'),
                'role' => 'user'
            ],
        ];

        foreach ($user as $item) {
            User::create($item);
        }
    }
}
