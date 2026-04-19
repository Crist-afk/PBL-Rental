<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPelangganController extends Controller
{
    /**
     * Menampilkan Dashboard Pelanggan
     */
    public function index()
    {
        // Data Dummy
        $stats = [
            'active_rentals' => 3,
            'total_rentals'  => 17,
            'reward_points'  => 450,
            'rating'         => 4.9,
        ];

        $current_rentals = [
            [
                'id'          => 1,
                'title'       => 'Raiden Shogun - Genshin Impact',
                'size'        => 'M',
                'return_date' => '18 April 2026',
                'price'       => 180000,
                'color'       => 'bg-dark-chocolate'
            ],
            [
                'id'          => 2,
                'title'       => 'Monkey D. Luffy - One Piece',
                'size'        => 'L',
                'return_date' => '20 April 2026',
                'price'       => 120000,
                'color'       => 'bg-aloewood'
            ],
        ];

        $recent_history = [
            [
                'title'  => 'Kafka - Honkai: Star Rail',
                'date'   => '5 April 2026',
                'price'  => 200000,
                'status' => 'Selesai'
            ],
            [
                'title'  => 'Spider-Man (Marvel)',
                'date'   => '28 Maret 2026',
                'price'  => 150000,
                'status' => 'Selesai'
            ],
        ];

        $recommendations = [
            [
                'title'    => 'Yae Miko',
                'category' => 'Genshin Impact',
                'color'    => 'bg-milk-tea'
            ],
            [
                'title'    => 'Gojo Satoru',
                'category' => 'Jujutsu Kaisen',
                'color'    => 'bg-sakura'
            ],
        ];

        return view('pages.DashPelanggan', compact(
            'stats', 
            'current_rentals', 
            'recent_history', 
            'recommendations'
        ));
    }
}