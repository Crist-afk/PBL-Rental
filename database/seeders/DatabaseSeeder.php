<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Membuat Akun Admin Utama
        User::create([
            'nama' => 'Super Admin CosRent',
            'email' => 'admin@cosrent.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Pelanggan Uji Coba (Opsional)
        User::create([
            'nama' => 'Pelanggan Setia',
            'email' => 'user@cosrent.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);
        
        $this->command->info('Akun Admin dan User berhasil ditanamkan!');
    }
}