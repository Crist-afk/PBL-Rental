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
        $products = [
            [
                'id'       => 1,
                'category' => 'GENSHIN IMPACT',
                'title'    => 'Raiden Shogun',
                'price'    => 180000,
                'color'    => 'bg-dark-chocolate'
            ],
            [
                'id'       => 2,
                'category' => 'ONE PIECE',
                'title'    => 'Monkey D. Luffy',
                'price'    => 120000,
                'color'    => 'bg-aloewood'
            ],
            [
                'id'       => 3,
                'category' => 'HONKAI',
                'title'    => 'Kafka',
                'price'    => 200000,
                'color'    => 'bg-milk-tea'
            ],
            [
                'id'       => 4,
                'category' => 'MARVEL',
                'title'    => 'Spider-Man',
                'price'    => 150000,
                'color'    => 'bg-sakura'
            ],
        ];

        // Karena file view kamu bernama product.blade.php (langsung di folder views/)
        return view('pages.product', compact('products'));
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
        ];

        $product = $allProducts[$id] ?? null;

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Khusus untuk Raiden Shogun (ID 1), tampilkan halaman kustom
        if ($id == 1) {
            return view('pages.Kostum.RaidenShogun', compact('product'));
        }

        return view('pages.product-detail', compact('product'));
    }
}