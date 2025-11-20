<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Allstock',
            'email' => 'admin@allstock.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '081234567890',
        ]);

        // Staff user
        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@allstock.com',
            'password' => Hash::make('qwertyuiop'),
            'role' => 'staff',
            'is_active' => true,
            'phone' => '081234567891',
        ]);
    }
}
