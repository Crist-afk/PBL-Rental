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

        // 3. Membuat Kategori Dummy
        $anime = \App\Models\Kategori::create([
            'nama_kategori' => 'Anime',
            'franchise' => 'Various Anime'
        ]);

        $game = \App\Models\Kategori::create([
            'nama_kategori' => 'Game',
            'franchise' => 'Various Games'
        ]);

        $superhero = \App\Models\Kategori::create([
            'nama_kategori' => 'Superhero',
            'franchise' => 'Marvel & DC'
        ]);

        // 4. Membuat Kostum Dummy
        \App\Models\Kostum::create([
            'kategori_id' => $anime->id,
            'nama_kostum' => 'Gojo Satoru',
            'stok' => 3,
            'harga_sewa' => 150000,
            'ukuran' => 'L, XL',
            'kelengkapan' => 'Wig, Eye Patch, Jujutsu High Uniform',
            'gambar' => 'gojo.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Kafka',
            'stok' => 2,
            'harga_sewa' => 200000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Wig, Coat, Shirt, Trousers, Accessories',
            'gambar' => 'kafka.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $anime->id,
            'nama_kostum' => 'Monkey D. Luffy',
            'stok' => 5,
            'harga_sewa' => 100000,
            'ukuran' => 'S, M, L',
            'kelengkapan' => 'Straw Hat, Red Vest, Shorts, Waist Sash',
            'gambar' => 'luffy.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Raiden Shogun',
            'stok' => 1,
            'harga_sewa' => 250000,
            'ukuran' => 'M',
            'kelengkapan' => 'Wig, Kimono, Obi, Hairpiece, Tabi',
            'gambar' => 'raiden.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $superhero->id,
            'nama_kostum' => 'Spider-Man',
            'stok' => 4,
            'harga_sewa' => 125000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Full Body Suit, Mask',
            'gambar' => 'spiderman.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Yae Miko',
            'stok' => 2,
            'harga_sewa' => 225000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Wig, Shrine Maiden Outfit, Accessories',
            'gambar' => 'yae.jpg',
        ]);

        $this->command->info('Kategori dan Kostum dummy berhasil ditambahkan!');
    }
}