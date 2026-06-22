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
                'stok' => 31,
                'stok_per_ukuran' => ['L' => 11, 'XL' => 10, 'XXL' => 10],
                'harga_sewa' => 150000,
                'ukuran' => 'L, XL, XXL',
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
                'stok' => 4,
                'stok_per_ukuran' => ['M' => 1, 'L' => 1, 'XL' => 2],
                'harga_sewa' => 250000,
                'ukuran' => 'M, L, XL',
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

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Saitama'],
            [
                'kategori_id' => $anime->id,
                'stok' => 4,
                'stok_per_ukuran' => ['M' => 1, 'L' => 2, 'XL' => 1],
                'harga_sewa' => 180000,
                'ukuran' => 'M, L, XL',
                'kelengkapan' => 'Full Set',
                'gambar' => 'kostum/sNz4TMcfuxlsUhygTohbYtD1noAeGF74o8hblkkc.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Anya Forger'],
            [
                'kategori_id' => $anime->id,
                'stok' => 6,
                'stok_per_ukuran' => ['M' => 2, 'L' => 2, 'XL' => 2],
                'harga_sewa' => 150000,
                'ukuran' => 'M, L, XL',
                'kelengkapan' => 'Eden Academy Uniform Dress, Detachable White Collar with Red Ribbon Tie, Character Pink Wig, Pair of Anya\'s Signature Hair Ornaments, Pair of Over-Knee White Socks',
                'gambar' => 'kostum/AfWzRkT9xKv7XW9SH9VAVG0qgvxDUFQGTupQeHTq.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Geto Suguru'],
            [
                'kategori_id' => $anime->id,
                'stok' => 3,
                'stok_per_ukuran' => ['M' => 1, 'L' => 1, 'XL' => 1],
                'harga_sewa' => 160000,
                'ukuran' => 'M, L, XL',
                'kelengkapan' => 'Jujutsu High School Uniform Jacket, Matching Baggy Hakama-style Pants, Character Black Wig',
                'gambar' => 'kostum/vsQetkpy3qBCvDqgwqxPuBaoHoerolvxLmZlJvRW.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Son Goku'],
            [
                'kategori_id' => $anime->id,
                'stok' => 4,
                'stok_per_ukuran' => ['L' => 2, 'XL' => 2],
                'harga_sewa' => 200000,
                'ukuran' => 'L, XL',
                'kelengkapan' => 'Orange Gi Top, Blue Inner Undershirt, Matching Orange Baggy Pants, Blue Waist Sash Tie, Pair of Blue Wristbands',
                'gambar' => 'kostum/LCBrkbsVEGwBWITf3ic20Wfvsxo0MAKDRfF3sYC0.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Yoichi Isagi'],
            [
                'kategori_id' => $anime->id,
                'stok' => 3,
                'stok_per_ukuran' => ['M' => 1, 'L' => 1, 'XL' => 1],
                'harga_sewa' => 150000,
                'ukuran' => 'M, L, XL',
                'kelengkapan' => 'Blue Team Z Soccer Jersey, Matching Blue Soccer Shorts, Full-Body Black Bodysuit',
                'gambar' => 'kostum/u8WztvXnYyuM7UcBrcQAKxv8igEel05KtkK3QrKW.jpg',
            ]
        );

        \App\Models\Kostum::updateOrCreate(
            ['nama_kostum' => 'Michael Kaiser'],
            [
                'kategori_id' => $anime->id,
                'stok' => 4,
                'stok_per_ukuran' => ['M' => 1, 'L' => 2, 'XL' => 1],
                'harga_sewa' => 150000,
                'ukuran' => 'M, L, XL',
                'kelengkapan' => 'Bastard München Soccer Jersey (with "KAISER 10" print on the back and gold trim details), Matching Black Soccer Shorts (with number 10 print)',
                'gambar' => 'kostum/WKNcY7kBqPBcRIWYSmU7dv5nku7MaaBloI8KkD2W.jpg',
            ]
        );

        $this->command->info('Kategori dan Kostum dummy berhasil ditambahkan!');
    }
}

