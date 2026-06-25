<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanduanRentalController extends Controller
{
    /**
     * Tampilkan halaman Panduan Rental.
     * Halaman ini bisa diakses oleh user yang sudah login.
     * Jika user belum membaca panduan (has_seen_guide = false),
     * halaman akan menampilkan tombol "Saya Mengerti" untuk menyelesaikan onboarding.
     */
    public function index()
    {
        $showOnboarding = false;

        if (Auth::check() && !Auth::user()->has_seen_guide) {
            $showOnboarding = true;
        }

        return view('pages.panduan-rental', compact('showOnboarding'));
    }

    /**
     * User menekan tombol "Saya Mengerti" / "Mulai Menyewa".
     * Update has_seen_guide = true kemudian redirect ke dashboard pelanggan.
     */
    public function markAsSeen(Request $request)
    {
        $user = Auth::user();
        $user->has_seen_guide = true;
        $user->save();

        return redirect()->route('dashboard.pelanggan')
            ->with('success', 'Welcome to CosRent! Enjoy renting your favorite costumes. 🎉');
    }
}
