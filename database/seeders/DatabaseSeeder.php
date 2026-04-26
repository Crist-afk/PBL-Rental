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
            'gambar' => 'https://images-cdn.ubuy.co.in/65179920f4977158b35cafa6-gojo-satoru-costume-jujutsu-kaisen.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Kafka',
            'stok' => 2,
            'harga_sewa' => 200000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Wig, Coat, Shirt, Trousers, Accessories',
            'gambar' => 'https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $anime->id,
            'nama_kostum' => 'Monkey D. Luffy',
            'stok' => 5,
            'harga_sewa' => 100000,
            'ukuran' => 'S, M, L',
            'kelengkapan' => 'Straw Hat, Red Vest, Shorts, Waist Sash',
            'gambar' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Raiden Shogun',
            'stok' => 1,
            'harga_sewa' => 250000,
            'ukuran' => 'M',
            'kelengkapan' => 'Wig, Kimono, Obi, Hairpiece, Tabi',
            'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $superhero->id,
            'nama_kostum' => 'Spider-Man',
            'stok' => 4,
            'harga_sewa' => 125000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Full Body Suit, Mask',
            'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s',
        ]);

        \App\Models\Kostum::create([
            'kategori_id' => $game->id,
            'nama_kostum' => 'Yae Miko',
            'stok' => 2,
            'harga_sewa' => 225000,
            'ukuran' => 'M, L',
            'kelengkapan' => 'Wig, Shrine Maiden Outfit, Accessories',
            'gambar' => 'https://ae01.alicdn.com/kf/S5c23516ed69b45b3ae3f35e3fbad217d6.jpg',
        ]);

        $this->command->info('Kategori dan Kostum dummy berhasil ditambahkan!');
    }
}