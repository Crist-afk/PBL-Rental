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
        ];

        $current_rentals = [
            [
                'id'          => 1,
                'title'       => 'Raiden Shogun - Genshin Impact',
                'size'        => 'M',
                'return_date' => '18 April 2026',
                'price'       => 180000,
                'color'       => 'bg-dark-chocolate',
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s'
            ],
            [
                'id'          => 2,
                'title'       => 'Monkey D. Luffy - One Piece',
                'size'        => 'L',
                'return_date' => '20 April 2026',
                'price'       => 120000,
                'color'       => 'bg-aloewood',
                'image'       => 'https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e'
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
                'color'    => 'bg-milk-tea',
                'image'    => 'https://ae01.alicdn.com/kf/S5c23516ed69b45b3ae3f35e3fbad217d6.jpg'
            ],
            [
                'title'    => 'Gojo Satoru',
                'category' => 'Jujutsu Kaisen',
                'color'    => 'bg-sakura',
                'image'    => 'https://images-cdn.ubuy.co.in/65179920f4977158b35cafa6-gojo-satoru-costume-jujutsu-kaisen.jpg'
            ],
        ];

        return view('pages.DashPelanggan', compact(
            'stats', 
            'current_rentals', 
            'recent_history', 
            'recommendations'
        ));
    }

    /**
     * Menampilkan Halaman Booking
     */
    public function booking(Request $request)
    {
        return view('pages.Booking', [
            'kostum_id' => $request->query('kostum_id'),
            'selected_size' => $request->query('size'),
            'tanggal_sewa' => $request->query('tanggal_sewa'),
            'tanggal_kembali' => $request->query('tanggal_kembali'),
        ]);
    }

    /**
     * Menangani Pengiriman Form Booking
     */
    public function storeBooking(Request $request)
    {
        // Simulasi penyimpanan data
        // $request->validate([...]);
        
        return redirect()->route('booking.index')->with('success', 'Reservasi berhasil!');
    }

    /**
     * Menampilkan Halaman Riwayat
     */
    public function riwayat()
    {
        return view('pages.Riwayat');
    }
}