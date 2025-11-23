<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun Admin Default
        User::create([
            'name' => 'Admin Cantik',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'), // Passwordnya: 123
        ]);
    }
}