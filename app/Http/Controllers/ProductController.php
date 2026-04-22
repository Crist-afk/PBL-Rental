<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk
     */
    public function index()
    {
        $allProducts = [
            [
                'id'       => 1,
                'category' => 'GENSHIN IMPACT',
                'title'    => 'Raiden Shogun',
                'price'    => 180000,
                'color'    => 'bg-dark-chocolate',
                'image'    => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s'
            ],
            [
                'id'       => 2,
                'category' => 'ONE PIECE',
                'title'    => 'Monkey D. Luffy',
                'price'    => 120000,
                'color'    => 'bg-aloewood',
                'image'    => 'https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e'
            ],
            [
                'id'       => 3,
                'category' => 'HONKAI',
                'title'    => 'Kafka',
                'price'    => 200000,
                'color'    => 'bg-milk-tea',
                'image'    => 'https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg'
            ],
            [
                'id'       => 4,
                'category' => 'MARVEL',
                'title'    => 'Spider-Man',
                'price'    => 150000,
                'color'    => 'bg-sakura',
                'image'    => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s'
            ],
            [
                'id'       => 5,
                'category' => 'GENSHIN IMPACT',
                'title'    => 'Yae Miko',
                'price'    => 190000,
                'color'    => 'bg-milk-tea',
                'image'    => 'https://ae01.alicdn.com/kf/S5c23516ed69b45b3ae3f35e3fbad217d6.jpg'
            ],
            [
                'id'       => 6,
                'category' => 'JUJUTSU KAISEN',
                'title'    => 'Gojo Satoru',
                'price'       => 160000,
                'color'       => 'bg-sakura',
                'image'       => 'https://images-cdn.ubuy.co.in/65179920f4977158b35cafa6-gojo-satoru-costume-jujutsu-kaisen.jpg'
            ],
        ];

        // Pagination
        $page = request()->query('page', 1);
        $perPage = 4;
        $products = array_slice($allProducts, ($page - 1) * $perPage, $perPage);
        $totalPages = ceil(count($allProducts) / $perPage);

        return view('pages.product', compact('products', 'page', 'totalPages'));
    }

    /**
     * Menampilkan detail satu produk
     */
    public function show($id)
    {
        // Contoh data (nanti diganti dengan query database)
        $allProducts = [
            1 => [
                'id'          => 1,
                'category'    => 'GENSHIN IMPACT',
                'title'       => 'Raiden Shogun',
                'price'       => 180000,
                'color'       => 'bg-dark-chocolate',
                'description' => 'Kostum Raiden Shogun premium dengan detail bordir tinggi, wig, dan aksesoris lengkap. Ukuran M - XXL tersedia.'
            ],
            2 => [
                'id'          => 2,
                'category'    => 'ONE PIECE',
                'title'       => 'Monkey D. Luffy',
                'price'       => 120000,
                'color'       => 'bg-aloewood',
                'description' => 'Kostum Luffy Gear 5 dengan kualitas kain terbaik dan sangat nyaman digunakan.'
            ],
            3 => [
                'id'          => 3,
                'category'    => 'HONKAI',
                'title'       => 'Kafka',
                'price'       => 200000,
                'color'       => 'bg-milk-tea',
                'description' => 'Kostum Kafka lengkap dengan coat dan detail elegan.'
            ],
            4 => [
                'id'          => 4,
                'category'    => 'MARVEL',
                'title'       => 'Spider-Man',
                'price'       => 150000,
                'color'       => 'bg-sakura',
                'description' => 'Kostum Spider-Man dengan masker dan web shooter aksesoris.'
            ],
            5 => [
                'id'          => 5,
                'category'    => 'GENSHIN IMPACT',
                'title'       => 'Yae Miko',
                'price'       => 190000,
                'color'       => 'bg-milk-tea',
                'description' => 'Kostum Yae Miko dengan detail premium dan kain yang nyaman.'
            ],
            6 => [
                'id'          => 6,
                'category'    => 'JUJUTSU KAISEN',
                'title'       => 'Gojo Satoru',
                'price'       => 160000,
                'color'       => 'bg-sakura',
                'description' => 'Kostum Gojo Satoru lengkap dengan penutup mata.'
            ],
        ];

        $product = $allProducts[$id] ?? null;

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Khusus untuk halaman kostum spesifik
        $customViews = [
            1 => 'pages.Kostum.RaidenShogun',
            2 => 'pages.Kostum.Luffy',
            3 => 'pages.Kostum.Kafka',
            4 => 'pages.Kostum.Spiderman',
            5 => 'pages.Kostum.YaeMiko',
            6 => 'pages.Kostum.GojoSatoru',
        ];

        if (isset($customViews[$id])) {
            return view($customViews[$id], compact('product'));
        }

        return view('pages.product-detail', compact('product'));
    }
}