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
        User::updateOrCreate(
            ['email' => 'admin@cosrent.com'],
            [
                'nama' => 'Super Admin CosRent',
                'password' => Hash::make('password123'), // Passwordnya: password123
                'role' => 'admin',
            ]
        );

        // 2. Membuat Akun Pelanggan Uji Coba (Opsional)
        User::updateOrCreate(
            ['email' => 'user@cosrent.com'],
            [
                'nama' => 'Pelanggan Setia',
                'password' => Hash::make('password123'), // Passwordnya: password123
                'role' => 'pelanggan',
            ]
        );
        
        $this->command->info('Akun Admin dan User berhasil ditanamkan!');

        // 3. Membuat Kategori Dummy
        $anime = \App\Models\Kategori::updateOrCreate(
            ['nama_kategori' => 'Anime'],
            ['franchise' => 'Various Anime']
        );

        $game = \App\Models\Kategori::updateOrCreate(
            ['nama_kategori' => 'Game'],
            ['franchise' => 'Various Games']
        );

        $superhero = \App\Models\Kategori::updateOrCreate(
            ['nama_kategori' => 'Superhero'],
            ['franchise' => 'Marvel & DC']
        );

        // 4. Membuat Kostum Dummy
        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Gojo Satoru'],
            [
                'kategori_id' => $anime->id,
                'stok' => 3,
                'stok_per_ukuran' => ['L' => 1, 'XL' => 2],
                'harga_sewa' => 150000,
                'ukuran' => 'L, XL',
                'kelengkapan' => 'Wig, Eye Patch, Jujutsu High Uniform',
                'gambar' => 'kostum/gojo.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Kafka'],
            [
                'kategori_id' => $game->id,
                'stok' => 2,
                'stok_per_ukuran' => ['M' => 1, 'L' => 1],
                'harga_sewa' => 200000,
                'ukuran' => 'M, L',
                'kelengkapan' => 'Wig, Coat, Shirt, Trousers, Accessories',
                'gambar' => 'kostum/kafka.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Monkey D. Luffy'],
            [
                'kategori_id' => $anime->id,
                'stok' => 5,
                'stok_per_ukuran' => ['S' => 1, 'M' => 2, 'L' => 2],
                'harga_sewa' => 100000,
                'ukuran' => 'S, M, L',
                'kelengkapan' => 'Straw Hat, Red Vest, Shorts, Waist Sash',
                'gambar' => 'kostum/luffy.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Raiden Shogun'],
            [
                'kategori_id' => $game->id,
                'stok' => 1,
                'stok_per_ukuran' => ['M' => 1],
                'harga_sewa' => 250000,
                'ukuran' => 'M',
                'kelengkapan' => 'Wig, Kimono, Obi, Hairpiece, Tabi',
                'gambar' => 'kostum/raiden.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Spider-Man'],
            [
                'kategori_id' => $superhero->id,
                'stok' => 4,
                'stok_per_ukuran' => ['M' => 2, 'L' => 2],
                'harga_sewa' => 125000,
                'ukuran' => 'M, L',
                'kelengkapan' => 'Full Body Suit, Mask',
                'gambar' => 'kostum/spiderman.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Yae Miko'],
            [
                'kategori_id' => $game->id,
                'stok' => 2,
                'stok_per_ukuran' => ['M' => 1, 'L' => 1],
                'harga_sewa' => 225000,
                'ukuran' => 'M, L',
                'kelengkapan' => 'Wig, Shrine Maiden Outfit, Accessories',
                'gambar' => 'kostum/yae.jpg',
            ]
        );

        $this->command->info('Kategori dan Kostum dummy berhasil ditambahkan!');
    }
}
