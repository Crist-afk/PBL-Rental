<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kostum; // Wajib memanggil model Kostum

class DashboardController extends Controller
{
    public function __construct()
    {
        // Proteksi: Hanya user yang sudah login yang bisa masuk ke Dashboard/Katalog
        $this->middleware('auth');
    }

    public function index()
    {
        // Tarik data kostum beserta kategorinya untuk ditampilkan di katalog
        $kostums = Kostum::with('kategori')->get();

        // Lempar data ke view dashboard pelanggan
        return view('pages.dashboard', compact('kostums'));
    }
}
